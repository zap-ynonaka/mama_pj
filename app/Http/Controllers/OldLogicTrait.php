<?php

namespace App\Http\Controllers;

use App\Consts;      // 定数
use Route;
use Log;

trait OldLogicTrait
{
    protected $baseUrl;
    protected $requestParam;


    protected $serviceKey;
    protected $packId;
    protected $menuId;
    protected $auth_id;
    protected $password;
    protected $requestUrl;
    protected $status = false;
    protected $result = '';
    protected $params = [];
    protected $option = [];
    protected $userInfo;
    protected $friendInfo;

    protected $LOGIC_SUCCESS_CODE = 2000;


    // リクエスト
    private function request($params=[])
    {
        $this->requestParam = [
            'content'   => 836,
//            'content'   => 10001,
            'pkg'       => Consts::OLD_LOGIC_PACKAGE,
            'user_name' => Consts::OLD_LOGIC_ACCOUNT,
            'key'       => md5(Consts::OLD_LOGIC_ACCOUNT.date("YmdHi").Consts::OLD_LOGIC_SECRETKEY),
        ];
        if (Consts::OLD_LOGIC_PLATFORM) {
            $this->requestParam += ['platform'  => Consts::OLD_LOGIC_PLATFORM];
        }
        $this->baseUrl = 'http://'.Consts::OLD_LOGIC_API_URL[env('APP_ENV')].':8080/Uranai/Uranai?';


        // ロジック接続
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->baseUrl.http_build_query($this->requestParam).'&'.http_build_query($params));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $xml = curl_exec($ch);
        curl_close($ch);
        
        // 文字コード: sjis -> utf8 変換
        mb_convert_encoding($xml, 'utf8', 'sjis');
//        $ret = json_decode( json_encode( simplexml_load_string($xml) ), TRUE );   // Object -> 配列
        $ret = simplexml_load_string($xml);
        if (@$ret->result == $this->LOGIC_SUCCESS_CODE) {
            // 情報取得 or 占断結果取得 or 姓名チェック
            $this->result = $ret;
            return true;
        } elseif (isset($ret->error_code)) {
            logger(sprintf("[ERROR] LogicBase : %s %s \n", date("Y-m-d H:i:s"), sprintf("%d: %s", $ret->error_code, $ret->error_msg)));
        } else {
            logger(sprintf("[ERROR] LogicBase : %s %s \n", date("Y-m-d H:i:s"), sprintf("%d: %s %s %s", @$ret->status, @$ret->error, @$ret->message, @$ret->path)));
        }
        return false;
    }

    /**
     * ロジック実行結果取得
     * @return JSON
     */
    public function getResult()
    {
        return $this->result;
    }











    /**
     * ロジックで使用するパラメーターを取得
     * @param int $logicMenuId logic menu id
     * @return array
     */
    public function getLogicParameters($logicMenuId)
    {
        $this->setMenuId($logicMenuId);
        $this->getMenuInfo();
        $result = $this->getResult();
        if (!$result) {
            return [];
        }
        $params = [];

        foreach ($result[0]->items[0] as $key => $value) {
            $params[$key] = $value;
        }
        return $params;
    }

    /**
     * ロジックで使用するパラメーターを取得
     * @param int $logicMenuId logic menu id
     * @return array
     */
    public function getLogicMultiParameters($logicMenuIds)
    {
        $params = [];
        $this->setMultiMenuId($logicMenuIds);
        $status = $this->getMenuInfo();
        if (!$status) {
        } else {
          $result = $this->getResult();
          if (!$result) {
              return [];
          }
          foreach ($result[0]->items as $key => $value) {
              $params[] = $value->req_params;
          }
        }
        return $params;
    }


    /**
     * 占断情報のURLパラメータを生成
     * @return string
     */
    public function getRequestParam()
    {
        $array = [];
        foreach ($this->params as $key => $val) {
            // パラメータが空の場合は、URLに追加しない
            if (empty($val)) {
                continue;
            }
            // 出生時刻に:があれば除いておく
            if ($key == 'birthtime' || $key == 'target_birthtime') {
                $val = str_replace(":", "", $val);
            }
            // 性別・血液型は大文字にして渡す
            if ($key == 'gender' || $key == 'target_gender' || $key == 'blood' || $key == 'target_blood') {
                $val = strtoupper($val);
            }
            $array[] = "{$key}=" . urlencode($val);
        }
        $uid = $this->userInfo->uid ?? 0;

        $array[] = "uid=" . $uid;
        return join('&', $array);
    }



    /**
     * ロジック実行結果取得
     * @return array テンプレート用に整形したもの
     */
    public function getLogicResult()
    {
        $result = [];

        if (isset($this->result) && $ret = $this->result) {
            foreach ($ret->items as $item) {
                $logic = [];
                $logic['menu_id'] = $item->menu;
                $logic['title'] = $item->title;
                $logic['description'] = $item->description;
                foreach ($item->body as $body) {
                    foreach ($body->res_codes as $res) {
                        $tmp = [];
                        $tmp['datetime'] = $body->datetime;
                        $tmp['unsei1'] = $res->unsei1 ?? '';
                        $tmp['unsei2'] = $res->unsei2 ?? '';
                        $tmp['unsei3'] = $res->unsei3 ?? '';
                        $tmp['name1'] = $res->name1 ?? '';
                        $tmp['name2'] = $res->name2 ?? '';
                        $tmp['name3'] = $res->name3 ?? '';
                        $tmp['name4'] = $res->name4 ?? '';
                        $tmp['name5'] = $res->name5 ?? '';
                        $tmp['text1'] = $res->text1 ?? '';
                        $tmp['text2'] = $res->text2 ?? '';
                        $tmp['text3'] = $res->text3 ?? '';
                        $tmp['text4'] = $res->text4 ?? '';
                        $tmp['text5'] = $res->text5 ?? '';
                        $tmp['image1'] = $res->image1 ?? '';
                        $tmp['image2'] = $res->image2 ?? '';
                        $tmp['image3'] = $res->image3 ?? '';
                        $tmp['image4'] = $res->image4 ?? '';
                        $tmp['image5'] = $res->image5 ?? '';
                        $tmp['summary'] = $res->summary ?? '';
                        $logic['body'][] = $tmp;
                    }
                }
                $result[] = $logic;
            }
        }

        return $result;
    }

    // 占断必要パラメータ一覧取得(1ロジック分)
    public function _getLogicInformation(int $logicMenuId)
    {
        $requiredParam = [];
        if ($result = $this->getLogicParameters($logicMenuId)) {
            $requiredParam = $result['req_params'];
        }
        return $requiredParam;
    }

    // 占断必要パラメータ一覧取得(複数ロジック分)
    public function _getLogicMultiInformation($logicMenuIds)
    {
        $requiredParam = [];
        if ($result = $this->getLogicMultiParameters($logicMenuIds)) {
            $requiredParam = $result;
        }
        return $requiredParam;
    }

    public function _callLogicWithPost(int $logicMenuId, array $option)
    {
        $this->setMenuId($logicMenuId);
        $this->setOption($option);
        $this->getMenuResult();
        if ($result = $this->getLogicResult()) {
            // 結果に加工が必要なら実装
            $result = $this->_formationLogicResult($result);
        }
        return $result;
    }

    protected function _formationLogicResult(array $result = [], $label = null)
    {
        $tmpResult = [];
        $result = $this->_formationCommon($result[0]) ?? [];
//        if (isset($result['body']['image1']) && $result['body']['image1']) {
//            $this->menuObj['menu_image'] = $result['body']['image1'];
//        }
        $str = explode('Controller',class_basename(Route::currentRouteAction()));
        $label = $label ?? mb_strtolower($str[0]);
        $tmpResult[$label] = $result;
        return $tmpResult;
    }
    /**
     * ロジックの結果データの整形
     * @param array $result logic result
     * @return array $cycle
     */
    protected function _formationCommon(array $result = [])
    {
        $common = [];
        if (isset($result['body'])) {
            $common['title'] = $result['title'] ?? '';
            $common['description'] = $result['description'] ?? '';
            $common['body'] = $result['body'][0] ?? [];
        }
        return $common;
    }

    // 入力パラメータ
    protected function _getLogicOptionParam()
    {
        $data = date('Y-m-d');
        return ['birthtime' => '9999', 'target_birthtime' => '9999', 'time' => '1200', 'date' => $data, 'from_pref' => '兵庫県', 'target_from_pref' => '兵庫県'];
    }

    /**
     * フロントから受ける誕生日の値をロジックサーバーの形式に変換して返す
     * @param  string $date (ex.20180226)
     * @return string $date (ex.2018-02-26)
     */
    protected function _formatLogicBirtyday($date)
    {
        preg_match('/([1-9]{1}[0-9]{3})([0-9]{2})([0-9]{2})/', $date, $matches);
        if (isset($matches[1]) && isset($matches[2]) && isset($matches[3]) && (checkdate($matches[2], $matches[3], $matches[1]))) {
            return sprintf('%04d-%02d-%02d', $matches[1], $matches[2], $matches[3]);
        }
        return $date;
    }

    /**
     * フロントから受ける出生時間の値をロジックサーバーの形式に変換して返す
     * @param string $time (ex.12:00:00)
     * @return string $time (ex.1200)
     */
    protected function _formatLogicBirtytime($time)
    {
        preg_match('/([0-9]{2}):([0-9]{2}):([0-9]{2})/', $time, $matches);
        if (isset($matches[1]) && isset($matches[2])) {
            return sprintf('%02d%02d', $matches[1], $matches[2]);
        }
        return $time;
    }
}
