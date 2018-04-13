<?php

namespace App\Http\Controllers;

use App\Consts;      // 定数
use Route;

trait LogicTrait
{

    protected $serviceKey;
    protected $packId;
    protected $menuId;
    protected $auth_id;
    protected $password;
    protected $baseUrl;
    protected $requestUrl;
    protected $status = false;
    protected $result = '';
    protected $params = [];
    protected $option = [];
    protected $userInfo;
    protected $friendInfo;

    protected $LOGIC_SUCCESS_CODE = 2000;

    /**
     * LogicComponent initialize
     * ロジック接続先URLを確定(request前に呼び出し。menuId, packIdは初期化対象から除外)
     * @param void
     * @return void
     */
    private function initialize()
    {
        $hostname = config('app.MyDomain.' . env('APP_ENV'));

        $this->serviceKey   = 'demo_lf';      // アカウント
        $this->auth_id      = "lf";           // ID
        $this->password     = 'lovefortune';  // パスワード
//        $this->serviceKey = 'contents_pj';
//        $this->auth_id = "cocoloni";
//        $this->password = "plus";
//        $this->baseUrl = Consts::LOGIC_API_URL[env('APP_ENV')].'/logicsrv2/zapi/v1.0';
        // echo env('APP_ENV')."|".Consts::LOGIC_API_URL[env('APP_ENV')];
    }

    /**
     * サービスキーの設定
     * @param string $serviceKey サービスキー
     * @return void
     */
    public function setServiceKey($serviceKey)
    {
        $this->serviceKey = $serviceKey;
    }

    /**
     * パックIDの設定
     * @param int $packId パックID
     * @return void
     */
    public function setPackId(int $packId)
    {
        $this->packId = $packId;
    }

    /**
     * メニューIDの設定
     * @param int $menuId メニューID
     * @return void
     */
    public function setMenuId(int $menuId)
    {
        $this->menuId = $menuId;
    }

    /**
     * メニューID(カンマ区切り複数指定)の設定
     * @param string $menuIds メニューID
     * @return void
     */
    public function setMultiMenuId($menuId)
    {
        $this->menuId = $menuId;
    }

    /**
     * メニューIDの設定
     * @param array $option 後で上書きしたいパラメータ
     * @return void
     */
    public function setOption(array $option)
    {
        $this->option = $option;
    }

    /**
     * ユーザー情報の設定
     * @param int $userInfo ユーザー情報
     * @return void
     */
    public function setUserInfo($userInfo)
    {
        $this->userInfo = $userInfo;
    }

    /**
     * フレンド情報の設定
     * @param int $friendInfo 友達情報
     * @return void
     */
    public function setFriendInfo($friendInfo)
    {
        $this->friendInfo = $friendInfo;
    }

    /**
     * サービスキーからパック一覧を取得
     * @return bool
     */
    public function getServicePackList()
    {
        $this->initialize();
        $this->requestUrl = $this->baseUrl . '/service/packs/' . $this->serviceKey;
        return $this->request();
    }

    /**
     * サービスキーからメニュー一覧を取得
     * @return bool
     */
    public function getServiceMenuList()
    {
        $this->initialize();
        $this->requestUrl = $this->baseUrl . '/service/menus/' . $this->serviceKey;
        return $this->request();
    }

    /**
     * サービスキーとパックIDからパックメニューの情報を取得
     * @return bool
     */
    public function getPackInfo()
    {
        $this->initialize();
        $this->requestUrl = $this->baseUrl . '/pack/info/' . $this->serviceKey . '/' . $this->packId;
        return $this->request();
    }

    /**
     * サービスキーとパックIDからパックメニューの占断結果を取得
     * @return bool
     */
    public function getPackResult()
    {
        $this->initialize();
        $this->requestUrl = $this->baseUrl . '/pack/result/' . $this->serviceKey . '/' . $this->packId;
        return $this->request();
    }

    /**
     * サービスキーとメニューIDからメニューの情報を取得
     * @return bool
     */
    public function getMenuInfo()
    {
        $this->initialize();
        $this->requestUrl = $this->baseUrl . '/menu/info/' . $this->serviceKey . '/' . $this->menuId;
        return $this->request();
    }

    /**
     * サービスキーとメニューIDからメニューの情報を取得
     * @return bool
     */
    public function getMenuResult()
    {
        $this->initialize();
        $this->requestUrl = $this->baseUrl . '/menu/result/' . $this->serviceKey . '/' . $this->menuId;
        return $this->request();
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
     * 自分の名前が使用可能かを確認する
     * @param string $lastName 姓
     * @param string $firstName 名
     * @return array
     */
    public function isMyNameAvailable($lastName, $firstName)
    {
        $this->initialize();
        $this->requestUrl = $this->baseUrl . '/seimei/check/' . $this->serviceKey . '/all';
        $this->setParameter('last_name', $lastName);
        $this->setParameter('first_name', $firstName);
        $this->request();
        $result = $this->getResult();
        if (!$result) {
            return [];
        }
        $checkResult = [];
        // 自分の名前の結果だけを取得する
        foreach ($result->seimei->check[0] as $name => $value) {
            $checkResult[$name] = json_decode(json_encode($value), true);
        }
        return $checkResult;
    }

    /**
     * 占断パラメータのセット
     * @param string $key ラベル
     * @param string $value 値
     * @return void
     */
    public function setParameter($key, $value)
    {
        $this->params[$key] = $value;
    }


    /**
     * デフォルト占断パラメータのセット
     * @return void
     */
    public function setDefaultParameter()
    {
        $this->setParameter('nickname', $this->params['nickname'] ?? $this->userInfo->name ?? '');
        $this->setParameter('birthday', $this->params['birthday'] ?? $this->userInfo->birthday ?? '');

        $birthTime = $this->params['birthtime'] ?? $this->userInfo->birthtime ?? '';
//        if ($birthTime == 9999) {
//            $birthTime = 1200;
//        }
        $this->setParameter('birthtime', $birthTime);
        $this->setParameter('blood', $this->params['blood'] ?? $this->userInfo->blood ?? '');
        $this->setParameter('gender', $this->params['gender'] ?? $this->userInfo->gender ?? '');

        $fromPref = $this->params['from_pref'] ?? $this->userInfo->from_pref ?? '兵庫県';
        if ($fromPref === '不明') {
            $fromPref = '兵庫県';
        }
        $this->setParameter('from_pref', $fromPref ?? '');

        $this->setParameter('last_name', $this->params['last_name'] ?? $this->userInfo->last_name ?? '');
        $this->setParameter('first_name', $this->params['first_name'] ?? $this->userInfo->first_name ?? '');
        $this->setParameter('last_name_kana', $this->params['last_name_kana'] ?? $this->userInfo->last_name_kana ?? '');
        $this->setParameter('first_name_kana', $this->params['first_name_kana'] ?? $this->userInfo->first_name_kana ?? '');
        $this->setParameter('maiden_name', $this->params['maiden_name'] ?? $this->userInfo->maiden_name ?? '');
        $this->setParameter('love_stat1', $this->params['love_stat1'] ?? $this->userInfo->love_stat1 ?? '');
        $this->setParameter('love_stat2', $this->params['love_stat2'] ?? $this->userInfo->love_stat2 ?? '');
        $this->setParameter('birthorder', $this->params['birthorder'] ?? $this->userInfo->birthorder ?? '');

        if (isset($this->friendInfo)) {
            $this->setParameter('target_nickname', $this->params['target_nickname'] ?? $this->friendInfo->name ?? '');
            $this->setParameter('target_birthday', $this->params['target_birthday'] ?? $this->friendInfo->birthday ?? '');
            $birthTime = $this->params['target_birthtime'] ?? $this->friendInfo->birthtime ?? '';
//            if ($birthTime == 9999) {
//                $birthTime = 1200;
//            }
            $this->setParameter('target_birthtime', $birthTime);
            $this->setParameter('target_blood', $this->params['target_blood'] ?? $this->friendInfo->blood ?? '');
            $this->setParameter('target_gender', $this->params['target_gender'] ?? $this->friendInfo->gender ?? '');

            $fromPref = $this->params['target_from_pref'] ?? $this->friendInfo->from_pref ?? '兵庫県';
            if ($fromPref === '不明') {
                $fromPref = '兵庫県';
            }
            $this->setParameter('target_from_pref', $fromPref);

            $this->setParameter('target_last_name', $this->params['target_last_name'] ?? $this->friendInfo->last_name ?? '');
            $this->setParameter('target_first_name', $this->params['target_first_name'] ?? $this->friendInfo->first_name ?? '');
            $this->setParameter('target_last_name_kana', $this->params['target_last_name_kana'] ?? $this->friendInfo->last_name_kana ?? '');
            $this->setParameter('target_first_name_kana', $this->params['target_first_name_kana'] ?? $this->friendInfo->first_name_kana ?? '');
            $this->setParameter('target_maiden_name', $this->params['target_maiden_name'] ?? $this->friendInfo->maiden_name ?? '');
            $this->setParameter('target_love_stat1', $this->params['target_love_stat1'] ?? $this->friendInfo->love_stat1 ?? '');
            $this->setParameter('target_love_stat2', $this->params['target_love_stat2'] ?? $this->friendInfo->love_stat2 ?? '');
            $this->setParameter('target_birthorder', $this->params['target_birthorder'] ?? $this->friendInfo->birthorder ?? '');
        }
    }


    /**
     * オプション占断パラメータのセット
     * @return void
     */
    public function setOptionParameter()
    {
        foreach ($this->option as $key => $val) {
            $this->setParameter($key, $val);
        }
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
     * リクエスト実行
     * @return bool
     */
    private function request()
    {
        unset($this->result);
        $this->setDefaultParameter();
        $this->setOptionParameter();
        $params = $this->getRequestParam();
        logger("logic_url -> " . $this->requestUrl . '?' . $params);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->requestUrl . '?' . $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_USERPWD, $this->auth_id . ":" . $this->password);
        $buf = curl_exec($ch);
        curl_close($ch);
        $ret = json_decode($buf);
        if (isset($ret->error_code) && $ret->error_code == $this->LOGIC_SUCCESS_CODE) {
            // 情報取得 or 占断結果取得 or 姓名チェック
            $this->result = $ret->info ?? $ret->result ?? $ret;
            $this->status = true;
        } elseif (isset($ret->error_code)) {
            logger(sprintf("[ERROR] LogicBase : %s %s \n", date("Y-m-d H:i:s"), sprintf("%d: %s", $ret->error_code, $ret->error_msg)));
        } else {
            // logger(sprintf("[ERROR] LogicBase : %s %s \n", date("Y-m-d H:i:s"), sprintf("%d: %s %s %s", $ret->status, $ret->error, $ret->message, $ret->path)));
        }
        return $this->status;
    }

    /**
     * ロジック実行結果取得
     * @return JSON
     */
    public function getResult()
    {
        // return $this->result;
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
