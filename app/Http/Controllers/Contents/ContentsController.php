<?php

namespace App\Http\Controllers\Contents;

use App\Http\Controllers\Controller;    // コントローラー
use Illuminate\Http\Request;
use App\Models\Menus;                   // DB メニュー
use App\Models\Corners;                 // DB コーナー
use App\Consts;                         // 定数

use Log;


class ContentsController extends Controller
{
    use \App\Http\Controllers\OldLogicTrait;    // ロジック

    protected $hash = [];

    public function __construct()
    {
        // 認証共通処理 app/Http/Middleware/ZapAuth.php
        $this->middleware('zap_auth');

        // 値をコントローラー内変数へ受け渡し
        $this->middleware(function ($request, $next) {

            $this->hash = $request->all();
            $this->user = $request->user;
            $this->hash['member'] = $request->user ? 1 : 0;  // 会員フラグ

            // デフォルト出力内容
            $this->hash['name']         = Consts::CONTENT_TITLE;    // コンテンツタイトル

            // 戻り遷移時必要パラメータ定義
            $inputparam = array('cpno');
            $tmp = array();
            foreach ($inputparam as $key) {
                if(isset($request[$key])) $tmp[$key] = $request[$key];
            }
            $this->URLParam = http_build_query($tmp);          // 画面共通項目 url query用  (モジュール内で使用)

            return $next($request);
        });
    }


    // サイトTOP
    public function index(Request $request)
    {
        // コーナー情報取得
        $corners = Corners::all();
        return view('contents.index', ['corners' => $corners]);
    }

    // メニュー一覧
    public function list(Request $request)
    {
        // コーナー情報取得
        $corners = Corners::find($request->corners_id);

//$query = ItemSchedule::with('item', 'itemMenu', 'category');
        $menus = Menus::with('corners','categories')->where('corners_id', $request->corners_id)->get();
/*
select * from `menus` join corners ON menus.corners_id = corners.id 
join categories ON menus.categories_id = categories.id 
join menus_tags ON menus.id = menus_tags.menus_id 
join tags ON menus_tags.tags_id = tags.id 
group by `menus`.`id`;
*/
        return view('contents.list', ['corners' => $corners, 'menus' => $menus]);
    }

    // メニュー結果
    public function result(Request $request)
    {
        $hash = $request->all();

        $menu = Menus::find(102);
        $hash['menu_name'] = $menu->menu_name;

        // ロジック必要情報設定
        $params['menu'] = $request->menus_id;

//$params['menu'] = 1;

        $tmp = explode(';', $menu->pkg_path);
        $params['logic'] = $tmp[0];
        $params['date'] = date("Ymd");
        $params['time'] = date("Hi");
        if($params['logic'] == 'HoroscopeDay002') {
            $params['type']  = '2,2';
            $params['planet']   = $tmp[1];
            $params['planet2']  = $tmp[2];
            $params['seq']  = 3;
//            $params['numbr']  = 1;
            // 日運
            if(101 <= $params['menu'] && $params['menu'] <= 199) {
                $params['time']  = '0000';
            // 週運
            } else {
                // 月曜日指定
                $params['date'] = date('Ymd', strtotime('-'.(date("w",strtotime(date("Ymd"))) - 1).' day', strtotime(date("Ymd"))));
                $params['time']  = '1200';
            }

        } elseif($params['logic'] == 'HoroscopeBasicSign001' || $params['logic'] == 'HoroscopeBasicElement001') {
            $params['houseSystem']  = $tmp[1].','.$tmp[2];
            $params['planet']       = $tmp[3];
            $params['genderFlag']   = $tmp[4];
        } elseif($params['logic'] == 'HoroscopeAishoElement001') {
            $params['planet']       = $tmp[1];
            $params['planet2']      = $tmp[2];
            $params['genderFlag']   = $tmp[3];
        } elseif($params['logic'] == 'NameAisho003') {
        } elseif($params['logic'] == 'HoroscopeBasicElement003') {
        }




        // 自分情報
        $user_param = [
//            'nickname',
//            'maiden_name',
//            'last_name',
//            'last_name_kana',
//            'first_name',
            'first_name_kana',
            'birthday',
            'birthtime',
            'from_pref',
            'birthtime_unknown',
//            'birthorder',
//            'blood',
            'gender'
        ];

        $user_logic_param = [
            'birthday'          => 'birth',
            'birthtime'         => 'btime',
            'from_pref'         => 'bArea',
            'gender'            => 'sex',
            'birthtime_unknown' => 'bTime_flg',
            'first_name_kana' => 'fname2',
        ];
        foreach ($user_param as $name) {
            $params[$user_logic_param[$name]] = @$this->user->$name;
        }
        $params['birth'] = date('Ymd', strtotime($params['birth']));
        $params['sex'] = $params['sex'] == 'm' ? 1 : 0;

/*
        // 相手情報
        $partner_logic_param = [
            'birthday'          => 'birth2',
            'birthtime'         => 'btime2',
            'from_pref'         => 'bArea2',
            'gender'            => 'sex2',
            'birthtime_unknown' => 'bTime_flg2',
            'first_name_kana' => 'fname2',
        ];
        foreach ($user_param as $name) {
            $params[$user_logic_param[$name]] = @$this->user->$name;
        }
        $params['birth2'] = date('Ymd', strtotime($params['birth2']));
        $params['sex2'] = $params['sex2'] == 'm' ? 1 : 0;

*/

        // 結果取得
        $hash['result'] = [];
        if($this->request($params)) {
            $xml = $this->getResult();
            foreach ($xml->content->explanation as $value) {
                $hash['result'] = array_merge($hash['result'],  [$value['id'][0].'' => $value[0].'']);
            }
        }
        return view('contents.result', $hash);
    }
}
