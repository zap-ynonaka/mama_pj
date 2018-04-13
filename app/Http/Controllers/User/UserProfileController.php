<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;    // コントローラー
use Illuminate\Http\Request;            // リクエスト
use Log;                                // ログ出力
use DB;                                 // DB接続
use App\Consts;                         // 定数
use App\Http\Controllers\LogicTrait;    // ロジック
use App\Models\Users;                   // DB ユーザー
use App\Models\PartnerProfiles;         // DB プロフィール相手
use App\Models\ChildrenProfile;         // DB プロフィール子供
use App\Models\MyMotherProfiles;        // DB プロフィール実母
use App\Models\PartnerMotherProfiles;   // DB プロフィール義母
use Redirect;                           // エラー時リダイレクト
use Session;                            // セッション

// ユーザー管理
class UserProfileController extends Controller
{

    protected $hash;        // 画面出力内容
    protected $user;        // ユーザー情報
    protected $URLParam;    // 画面共通項目 url query用
    use LogicTrait;    // ロジック接続関連

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
            $this->hash['prfile_area']  = Consts::PROFILE_AREA;     // プロフィール用地域

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

    // 前処理
    protected function _pre($request, $member=0)
    {
        // 会員専用でセッション無し( or 期限切れ) or トークン該当ユーザー無し -> ログイン画面へ
        if($member && !$this->user) {
            session(['_flash_message' => 'E1014']);
            Redirect::to('/user/login'.'?callback_url='.urlencode($_SERVER['REQUEST_URI']))->send();
        }
        return '';
    }

    // ユーザープロフィール設定
    public function myProfile(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // 確認
        if(@$this->hash['btn_check']) {

        // 完了
        } elseif(@$this->hash['btn_complete']) {

            // ユーザー情報更新
            $this->user->nickname           = $this->hash['nickname'] ?? '';
            $this->user->maiden_name        = $this->hash['maiden_name'] ?? '';
            $this->user->last_name          = $this->hash['last_name'] ?? '';
            $this->user->last_name_kana     = $this->hash['last_name_kana'] ?? '';
            $this->user->first_name         = $this->hash['first_name'] ?? '';
            $this->user->first_name_kana    = $this->hash['first_name_kana'] ?? '';
//            $this->user->birthday           = $this->hash['birthday'] ?? '';  // フロントが生年月日をどうするかによる
            $this->user->birthday           = @$this->hash['birthday_y'].'-'.@$this->hash['birthday_m'].'-'.@$this->hash['birthday_d'];

            // 出生時間不明でない
            if(@$this->hash['birthtime_unknown']) {
                $this->user->birthtime          = '120000'; // ロジックにおける不明を表現する値 12:00 を設定
                $this->user->birthtime_unknown  = 1;

            // 出生時間不明
            } else {
                $this->user->birthtime          = $this->hash['birthtime'];
                $this->user->birthtime_unknown  = 0;
            }
            $this->user->birthorder         = $this->hash['birthorder'] ?? '';
            $this->user->blood              = $this->hash['blood'] ?? '';
            $this->user->gender             = $this->hash['gender'] ?? '';
            $this->user->from_pref          = $this->hash['from_pref'] ?? '';
            $this->user->save();
        // 入力
        } else {

            // 該当レコードあればデフォルト表示
            $param = ['nickname', 'maiden_name', 'last_name', 'last_name_kana', 'first_name', 'first_name_kana', 'birthday', 'birthtime', 'birthtime_unknown', 'birthorder', 'blood', 'gender', 'from_pref'];
            foreach ($param as $key) {
                if(isset($this->user->$key)) $this->hash[$key] = $this->hash[$key] ?? $this->user->$key;
            }
        }

        // 生年月日表示 !!!フロント実装によっては不要かも
        if(@$this->hash['birthday']) {
            $tmp = explode('-', $this->hash['birthday']);
            $this->hash['birthday_y'] = $this->hash['birthday_y'] ?? @$tmp[0];
            $this->hash['birthday_m'] = $this->hash['birthday_m'] ?? @$tmp[1];
            $this->hash['birthday_d'] = $this->hash['birthday_d'] ?? @$tmp[2];
        }

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.my_profile')->with($this->hash);
    }

    // パートナープロフィール設定
    public function partnerProfile(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // 確認
        if(@$this->hash['btn_check']) {

        // 完了
        } elseif(@$this->hash['btn_complete']) {

            // パートナー更新(ユーザーとは1対1)
            $Partner = PartnerProfiles::where([['users_id', $this->user->id]])->first();    // 該当レコードあれば(status=0でも)対象を使用する
            if(!$Partner) $Partner = new PartnerProfiles();                                 // なければ新規
            $Partner->status = 1;

            // ユーザー情報更新
            $Partner->users_id           = $this->user->id;
            $Partner->nickname           = $this->hash['nickname'] ?? '';
            $Partner->last_name          = $this->hash['last_name'] ?? '';
            $Partner->last_name_kana     = $this->hash['last_name_kana'] ?? '';
            $Partner->first_name         = $this->hash['first_name'] ?? '';
            $Partner->first_name_kana    = $this->hash['first_name_kana'] ?? '';
//            $Partner->birthday           = $this->hash['birthday'] ?? '';  // フロントが生年月日をどうするかによる
            $Partner->birthday           = @$this->hash['birthday_y'].'-'.@$this->hash['birthday_m'].'-'.@$this->hash['birthday_d'];

            // 出生時間不明でない
            if(@$this->hash['birthtime_unknown']) {
                $Partner->birthtime          = '120000'; // ロジックにおける不明を表現する値 12:00 を設定
                $Partner->birthtime_unknown  = 1;

            // 出生時間不明
            } else {
                $Partner->birthtime          = $this->hash['birthtime'];
                $Partner->birthtime_unknown  = 0;
            }
            $Partner->birthorder         = $this->hash['birthorder'] ?? '';
            $Partner->blood              = $this->hash['blood'] ?? '';
            $Partner->gender             = $this->hash['gender'] ?? '';
            $Partner->from_pref          = $this->hash['from_pref'] ?? '';
            $Partner->save();

        // 入力
        } else {

            // 該当レコードあればデフォルト表示
            $Partner = PartnerProfiles::where([['users_id', $this->user->id],['status', 1]])->first();
            $param = ['nickname', 'last_name', 'last_name_kana', 'first_name', 'first_name_kana', 'birthday', 'birthtime', 'birthtime_unknown', 'birthorder', 'blood', 'gender', 'from_pref'];
            foreach ($param as $key) {
                if(isset($Partner->$key)) $this->hash[$key] = $this->hash[$key] ?? $Partner->$key;
            }
        }

        // 生年月日表示 !!!フロント実装によっては不要かも
        if(@$this->hash['birthday']) {
            $tmp = explode('-', $this->hash['birthday']);
            $this->hash['birthday_y'] = $this->hash['birthday_y'] ?? @$tmp[0];
            $this->hash['birthday_m'] = $this->hash['birthday_m'] ?? @$tmp[1];
            $this->hash['birthday_d'] = $this->hash['birthday_d'] ?? @$tmp[2];
        }


        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.partner_profile')->with($this->hash);
    }

    // 子供プロフィール設定
    public function childrenProfile(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // 確認
        if(@$this->hash['btn_check']) {

        // 完了
        } elseif(@$this->hash['btn_complete']) {

            // 子供更新(ユーザーとは1対n)
            if(@$this->hash['cid']) {
                $Children = ChildrenProfile::where([['users_id', $this->user->id],['id', $this->hash['cid']]])->first();
            } else {
                $Children = new ChildrenProfile();
            }
            $Children->status = 1;

            // ユーザー情報更新
            $Children->users_id           = $this->user->id;
            $Children->nickname           = $this->hash['nickname'] ?? '';
            $Children->last_name          = $this->hash['last_name'] ?? '';
            $Children->last_name_kana     = $this->hash['last_name_kana'] ?? '';
            $Children->first_name         = $this->hash['first_name'] ?? '';
            $Children->first_name_kana    = $this->hash['first_name_kana'] ?? '';
//            $Children->birthday           = $this->hash['birthday'] ?? '';  // フロントが生年月日をどうするかによる
            $Children->birthday           = @$this->hash['birthday_y'].'-'.@$this->hash['birthday_m'].'-'.@$this->hash['birthday_d'];

            // 出生時間不明でない
            if(@$this->hash['birthtime_unknown']) {
                $Children->birthtime          = '120000'; // ロジックにおける不明を表現する値 12:00 を設定
                $Children->birthtime_unknown  = 1;

            // 出生時間不明
            } else {
                $Children->birthtime          = $this->hash['birthtime'];
                $Children->birthtime_unknown  = 0;
            }
            $Children->birthorder         = $this->hash['birthorder'] ?? '';
            $Children->blood              = $this->hash['blood'] ?? '';
            $Children->gender             = $this->hash['gender'] ?? '';
            $Children->from_pref          = $this->hash['from_pref'] ?? '';
            $Children->save();

        // 入力
        } elseif(@$this->hash['cid']) {

            $Children = ChildrenProfile::where([['users_id', $this->user->id],['id', $this->hash['cid']]])->first();
            $param = ['icon_imgfile', 'nickname', 'last_name', 'last_name_kana', 'first_name', 'first_name_kana', 'birthday', 'birthtime', 'birthtime_unknown', 'birthorder', 'blood', 'gender', 'from_pref'];
            foreach ($param as $key) {
                if(isset($Children->$key)) $this->hash[$key] = $this->hash[$key] ?? $Children->$key;
            }
            $this->hash['cid'] = $Children->id;

            // 生年月日表示 !!!フロント実装によっては不要かも
            if(@$this->hash['birthday']) {
                $tmp = explode('-', $this->hash['birthday']);
                $this->hash['birthday_y'] = $this->hash['birthday_y'] ?? @$tmp[0];
                $this->hash['birthday_m'] = $this->hash['birthday_m'] ?? @$tmp[1];
                $this->hash['birthday_d'] = $this->hash['birthday_d'] ?? @$tmp[2];
            }
        }

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.children_profile')->with($this->hash);
    }

    // 子供画像設定
    public function childrenImage(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // cid指定ありき
        if(@$this->hash['cid']) {
            $Children = ChildrenProfile::where([['users_id', $this->user->id],['id', $this->hash['cid']]])->first();
            $this->hash['icon_imgfile'] = $this->hash['icon_imgfile'] ?? $Children->icon_imgfile;
        } else {
            return view('user.children_image')->with($this->hash);
        }

        // アイコン更新
        if(@$this->hash['btn_choice']) {
            $Children->icon_imgfile = $this->hash['icon_imgfile'];
            $Children->save();
            Redirect::to('/user/children_profile')->send();
        }

        return view('user.children_image')->with($this->hash);
    }

    // マイページ
    public function mypage(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // ユーザー情報出力
        $param = ['nickname', 'birthday', 'birthtime', 'birthtime_unknown', 'blood', 'gender'];
        foreach ($param as $key) {
            if(isset($this->user->$key)) $this->hash[$key] = $this->user->$key;
        }
        // 年齢 算出
        if(@$this->hash['birthday']) $this->hash['age'] = floor((date("Ymd") - date('Ymd',strtotime($this->hash['birthday'])))/10000);


        // パートナー情報出力
        $Partner = PartnerProfiles::where([['users_id', $this->user->id],['status', 1]])->first();
        foreach ($param as $key) {
            if(isset($Partner->$key)) $this->hash['pt_'.$key] = $Partner->$key;
        }
        // 年齢 算出
        if(@$this->hash['pt_birthday']) $this->hash['pt_age'] = floor((date("Ymd") - date('Ymd',strtotime($this->hash['pt_birthday'])))/10000);

        // 子供情報出力(生まれ順(生年月日昇順))
        $this->hash['children'] = ChildrenProfile::where([['users_id', $this->user->id]])->orderBy('birthday')->get();

        // 実母情報出力
        $MMother = MyMotherProfiles::where([['users_id', $this->user->id],['status', 1]])->first();
        foreach ($param as $key) {
            if(isset($MMother->$key)) $this->hash['mym_'.$key] = $MMother->$key;
        }
        // 年齢 算出
        if(@$this->hash['mym_birthday']) $this->hash['mym_age'] = floor((date("Ymd") - date('Ymd',strtotime($this->hash['mym_birthday'])))/10000);

        // 義母情報出力
        $PMother = PartnerMotherProfiles::where([['users_id', $this->user->id],['status', 1]])->first();
        foreach ($param as $key) {
            if(isset($PMother->$key)) $this->hash['ptm_'.$key] = $PMother->$key;
        }
        // 年齢 算出
        if(@$this->hash['ptm_birthday']) $this->hash['ptm_age'] = floor((date("Ymd") - date('Ymd',strtotime($this->hash['ptm_birthday'])))/10000);

        return view('user.mypage')->with($this->hash);
    }

    // 実母プロフィール設定
    public function MyMotherProfile(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // 確認
        if(@$this->hash['btn_check']) {

        // 完了
        } elseif(@$this->hash['btn_complete']) {

            // 実母更新(ユーザーとは1対1)
            $Partner = MyMotherProfiles::where([['users_id', $this->user->id]])->first();    // 該当レコードあれば(status=0でも)対象を使用する
            if(!$Partner) $Partner = new MyMotherProfiles();                                 // なければ新規
            $Partner->status = 1;

            // ユーザー情報更新
            $Partner->users_id           = $this->user->id;
            $Partner->nickname           = $this->hash['nickname'] ?? '';
            $Partner->last_name          = $this->hash['last_name'] ?? '';
            $Partner->last_name_kana     = $this->hash['last_name_kana'] ?? '';
            $Partner->first_name         = $this->hash['first_name'] ?? '';
            $Partner->first_name_kana    = $this->hash['first_name_kana'] ?? '';
//            $Partner->birthday           = $this->hash['birthday'] ?? '';  // フロントが生年月日をどうするかによる
            $Partner->birthday           = @$this->hash['birthday_y'].'-'.@$this->hash['birthday_m'].'-'.@$this->hash['birthday_d'];

            // 出生時間不明でない
            if(@$this->hash['birthtime_unknown']) {
                $Partner->birthtime          = '120000'; // ロジックにおける不明を表現する値 12:00 を設定
                $Partner->birthtime_unknown  = 1;

            // 出生時間不明
            } else {
                $Partner->birthtime          = $this->hash['birthtime'];
                $Partner->birthtime_unknown  = 0;
            }
            $Partner->birthorder         = $this->hash['birthorder'] ?? '';
            $Partner->blood              = $this->hash['blood'] ?? '';
            $Partner->gender             = $this->hash['gender'] ?? '';
            $Partner->from_pref          = $this->hash['from_pref'] ?? '';
            $Partner->save();

        // 入力
        } else {

            // 該当レコードあればデフォルト表示
            $Partner = MyMotherProfiles::where([['users_id', $this->user->id],['status', 1]])->first();
            $param = ['nickname', 'last_name', 'last_name_kana', 'first_name', 'first_name_kana', 'birthday', 'birthtime', 'birthtime_unknown', 'birthorder', 'blood', 'gender', 'from_pref'];
            foreach ($param as $key) {
                if(isset($Partner->$key)) $this->hash[$key] = $this->hash[$key] ?? $Partner->$key;
            }
        }

        // 生年月日表示 !!!フロント実装によっては不要かも
        if(@$this->hash['birthday']) {
            $tmp = explode('-', $this->hash['birthday']);
            $this->hash['birthday_y'] = $this->hash['birthday_y'] ?? @$tmp[0];
            $this->hash['birthday_m'] = $this->hash['birthday_m'] ?? @$tmp[1];
            $this->hash['birthday_d'] = $this->hash['birthday_d'] ?? @$tmp[2];
        }

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.my_mother_profile')->with($this->hash);
    }

    // 義母プロフィール設定
    public function partnerMotherProfile(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // 確認
        if(@$this->hash['btn_check']) {

        // 完了
        } elseif(@$this->hash['btn_complete']) {

            // 義母更新(ユーザーとは1対1)
            $Partner = PartnerMotherProfiles::where([['users_id', $this->user->id]])->first();    // 該当レコードあれば(status=0でも)対象を使用する
            if(!$Partner) $Partner = new PartnerMotherProfiles();                                 // なければ新規
            $Partner->status = 1;

            // ユーザー情報更新
            $Partner->users_id           = $this->user->id;
            $Partner->nickname           = $this->hash['nickname'] ?? '';
            $Partner->last_name          = $this->hash['last_name'] ?? '';
            $Partner->last_name_kana     = $this->hash['last_name_kana'] ?? '';
            $Partner->first_name         = $this->hash['first_name'] ?? '';
            $Partner->first_name_kana    = $this->hash['first_name_kana'] ?? '';
//            $Partner->birthday           = $this->hash['birthday'] ?? '';  // フロントが生年月日をどうするかによる
            $Partner->birthday           = @$this->hash['birthday_y'].'-'.@$this->hash['birthday_m'].'-'.@$this->hash['birthday_d'];

            // 出生時間不明でない
            if(@$this->hash['birthtime_unknown']) {
                $Partner->birthtime          = '120000'; // ロジックにおける不明を表現する値 12:00 を設定
                $Partner->birthtime_unknown  = 1;

            // 出生時間不明
            } else {
                $Partner->birthtime          = $this->hash['birthtime'];
                $Partner->birthtime_unknown  = 0;
            }
            $Partner->birthorder         = $this->hash['birthorder'] ?? '';
            $Partner->blood              = $this->hash['blood'] ?? '';
            $Partner->gender             = $this->hash['gender'] ?? '';
            $Partner->from_pref          = $this->hash['from_pref'] ?? '';
            $Partner->save();

        // 入力
        } else {

            // 該当レコードあればデフォルト表示
            $Partner = PartnerMotherProfiles::where([['users_id', $this->user->id],['status', 1]])->first();
            $param = ['nickname', 'last_name', 'last_name_kana', 'first_name', 'first_name_kana', 'birthday', 'birthtime', 'birthtime_unknown', 'birthorder', 'blood', 'gender', 'from_pref'];
            foreach ($param as $key) {
                if(isset($Partner->$key)) $this->hash[$key] = $this->hash[$key] ?? $Partner->$key;
            }
        }

        // 生年月日表示 !!!フロント実装によっては不要かも
        if(@$this->hash['birthday']) {
            $tmp = explode('-', $this->hash['birthday']);
            $this->hash['birthday_y'] = $this->hash['birthday_y'] ?? @$tmp[0];
            $this->hash['birthday_m'] = $this->hash['birthday_m'] ?? @$tmp[1];
            $this->hash['birthday_d'] = $this->hash['birthday_d'] ?? @$tmp[2];
        }


        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.partner_mother_profile')->with($this->hash);
    }


    // エラー管理
    protected function _FlashMssage2ErrorMessage()
    {
        // エラー無し or 既にエラーメッセージ指定されている場合はスルー(無いと思うが...)
        if(isset($this->hash['error_message']) || !Session::has('_flash_message')) return '';
        $error_code = Session::get('_flash_message');

        switch ($error_code) {
            case 'E1001':
                $this->hash['error_title']      = 'メールアドレス重複エラー';
                $this->hash['error_message']    = 'すでに登録されているメールアドレスです。ログインしてください。';
                break;

            default:
                $this->hash['error_code']       = $error_code;
                $this->hash['error_title']      = 'システムにエラーがあります。';
                $this->hash['error_message']    = 'お手数ですが「エラーコード」を「お問い合わせ」からお知らせください。折り返しメールにてご返答さしあげます。';
                $this->hash['show_inquiry']     = 0;
        }
        Session::forget('_flash_message');

       return '';
    }
}
