<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;    // コントローラー
use Illuminate\Http\Request;            // リクエスト
use Log;                                // ログ出力
use DB;                                 // DB接続
use App\Utils;                          // パスワード暗号化など
use App\Consts;                         // 定数
use App\Mail\CommonMail;                // メール用意
use Mail;                               // メール送信
use App\Http\Controllers\LogicTrait;    // ロジック
use App\Models\Users;                   // DB ユーザー
use App\Models\ChangeStatusReissueKeys; // DB ユーザー情報変更
use App\Models\Favorites;               // DB お気に入り
use Redirect;                           // エラー時リダイレクト
use Session;                            // セッション

// ユーザー管理
class UserController extends Controller
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

            // 戻り遷移時必要パラメータ定義
            $inputparam = array('cpno');
            $tmp = array();
            foreach ($inputparam as $key) {
                if(isset($request[$key])) $tmp[$key] = $request[$key];
            }
            $this->URLParam = http_build_query($tmp);          // 画面共通項目 url query用  (モジュール内で使用)


            $this->hash['googleplusClientId']   = Consts::GOOGLE_CLIENT_ID;                         // google認証用clientID
            $this->hash['g_cookiepolicy']       = url('/');                                         // google cookie保存対象url
            $this->hash['facebookAppId']        = Consts::FACEBOOK_ID;                              // facebook認証用ID
            $this->hash['facebookAppVersion']   = Consts::FACEBOOK_VER;                             // facebook認証用ver
            $this->hash['yahooAppId']           = Consts::YAHOO_ID;                                 // yahoo認証用ID
            $this->hash['yahooRegisterUrl']     = rawurlencode(url('/').'/user/yahoo_register'.$this->getURLParam()); // yahoo認証用URL 登録
            $this->hash['yahooLoginUrl']        = rawurlencode(url('/').'/user/yahoo_login'.$this->getURLParam());    // yahoo認証用URL ログイン
            $this->hash['yahooChangeUrl']       = rawurlencode(url('/').'/user/change'.$this->getURLParam());         // yahoo認証用URL 変更 !!!


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

    // 会員登録:入力
    public function regist_input(Request $request)
    {
        $this->_pre($request);  // 前処理

        // sns認証指定
        $sns    = $this->hash['sns'] ?? 'none';
        $sns_id = $this->hash[$sns.'_id'] ?? '';
        if ($sns_id) {
            // sns認証ユーザー該当あり -> ログインを促す
            $users = Users::where([['sns_type', $sns],['sns_userid', $sns_id],['status', 1]])->first();
            if($users) {
                $this->hash['error_title']      = '既にアカウント登録されています。';
                $this->hash['error_message']    = '該当の'.ucfirst($sns).'アカウントはすでに登録されています。ログインをしてください';
                $this->hash[$sns] = 'none';     // sns 初期化
                $this->hash[$sns.'_id'] = '';   // sns_id初期化
            }
            
            // 問題なければ $this->hash[$sns.'_id'] を出力する
        }

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.regist_input')->with($this->hash);
    }

    // 会員登録:入力sns
    public function regist_input_sns(Request $request)
    {
        $this->_pre($request);
        return view('user.regist_input_sns')->with($this->hash);
    }

    // 会員登録:メール送信
    public function regist_mailsend(Request $request)
    {
        $this->_pre($request);  // 前処理

        // sns認証系
        $sns    = $this->hash['sns'] ?? 'none';
        $sns_id = $this->hash[$sns.'_id'] ?? '';

        if($this->hash['email']) {

            // メアド重複チェック
            $users = Users::where([['email', $this->hash['email']],['status', 1]])->first();
            if ($users) {
                session(['_flash_message' => 'E1001']);
                Redirect::to('/user/regist_input'.$this->getURLParam())->send();
                return '';
            }

            // ユーザー仮登録
            try{
                $users = Users::where([['email', $this->hash['email']],['status', 0]])->first();
                // 退会済 or 仮登録状態の同emailユーザー
                if ($users) {
                    $users->password        = bcrypt($this->hash['password']);
                    $users->mail_magazine   = $this->hash['mail_mag'] ?? 0;
                    if($this->hash['cpno'] ?? '') $users->cpno = $this->hash['cpno'];
                    $users->sns_type                = $sns;
                    if($sns_id) $users->sns_userid  = $sns_id;
                    $users->save();

                // 新規
                } else {
                    $users = new Users();
                    $users->email       = $this->hash['email'];
                    $users->password        = bcrypt($this->hash['password']);
                    $users->mail_magazine   = $this->hash['mail_mag'] ?? 0;
                    if($this->hash['cpno'] ?? '') $users->cpno = $this->hash['cpno'];
                    $users->sns_type                = $sns;
                    if($sns_id) $users->sns_userid  = $sns_id;
                    $users->save();
                }
            } catch(Exception $e) {
                Log::error($e); // システムエラー出力
                session(['_flash_message' => 'E1002']);
                Redirect::to('/user/regist_input'.$this->getURLParam())->send();
                return '';
            }

            // 認証URL作成
            $domain = config('app.ServerScheme.'.env('APP_ENV')).'://'.config('app.MyDomain.'.env('APP_ENV'));
            $registApiParam = [
                'email' => $this->hash['email'],
                'p'     => rawurlencode(Utils::getCryptString($this->hash['password'], 1)),
            ];
            // ressu使用しないと..現状pは未使用
            $this->hash['url'] = $domain . "/user/regist_complete?" . http_build_query($registApiParam);

            // 送信メール設定
            $options = [
                'from'      => env('MAIL_FROM_ADDRESS'),
                'from_name' => Consts::CONTENT_TITLE,
                'to'        => $this->hash['email'],
                'subject'   => Consts::CONTENT_TITLE.' 登録確認メール',
                'template'  => 'emails.userAuth',
            ];

            // 送信メール本文設定
            $data = [
                'content_title'     => Consts::CONTENT_TITLE,
                'content_url'       => $domain,
                'user_regist_url'   => $this->hash['url'],
            ];
            $res = Mail::to($options['to'])->send(new CommonMail($options, $data));

            // メール送信が問題なければ
            $hash['title'] = '認証メール送信完了';
            $hash['email'] = $this->hash['email'];
        }

        return view('user.regist_mailsend')->with($this->hash);
    }

    // 会員登録:登録完了
    public function regist_complete(Request $request)
    {
        $this->_pre($request);  // 前処理

        try {
            // 既に会員のユーザーの場合はアクセストークンを取得
            $access_token = '';
            if(isset($params['reissue_key']) && $params['reissue_key'] !='') {
                $access_token = $this->get_DBtoken($params['reissue_key']);
            }

            // 該当メールアドレスで登録済
            $users = Users::where([['email', $this->hash['email']],['status', 1]])->first();
            if ($users) {
                session(['_flash_message' => 'E1003']);

                // ログインを促す
                Redirect::to('/user/login'.$this->getURLParam())->send();
                return '';

            // 該当メールアドレスで未登録 -> 会員登録
            } else {

                // トークン生成
                $access_token = sha1(uniqid(rand(), true));

                // ユーザーDB本登録
                $users = Users::where([['email', $this->hash['email']],['status', 0]])->first();
                $users->access_token = $access_token;
                $users->status = 1;
                $users->save();

                // ログインセッション生成
                session(['_access_token' => $access_token]);
            }
        } catch(\Exception $e) {
            Log::error($e); // システムエラー出力
            session(['_flash_message' => 'E1003']);
            Redirect::to('/user/regist_input'.$this->getURLParam())->send();
            return '';
        }

        $hash['email'] = $this->hash['email'];

        return view('user.regist_complete')->with($this->hash);
    }

    // 退会
    public function unregist(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // POST退会処理時
        if($_SERVER["REQUEST_METHOD"] == 'POST') {
echo date("Y-m-d H:i:s");
            // ユーザー退会処理
            $this->user->sns_type = '';                     // snsタイプ消去
            $this->user->sns_userid = '';                   // snsID消去
            $this->user->access_token = '';                 // トークン消去
            $this->user->status = 0;                        // 退会フラグ
            $this->user->deleted_at = date("Y-m-d H:i:s");  // 退会日時
            $this->user->save();

            // ログインセッション 破棄
            Session::forget('_access_token');

            $this->hash['method_type'] = 'post';    // 画面出し分け用:退会完了画面表示
        }

        return view('user.unregist')->with($this->hash);
    }

    // お気に入り一覧
    public function favorite_list(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 会員限定

        // お気に入り一覧取得
        $this->hash['favorite'] = Favorites::where([['users_id', $this->user->id]])->get();

        $tmp = array();
        foreach ($this->hash['favorite'] as $f) {

            $f->result_text = json_decode($f->result_text, true) ?? '';
            if(isset($f->result_text['summary'])) $f->summary = $f->result_text['summary'];
        }

        // menusとの紐付け、結果textの編集が残り!!!

        return view('user.favorite_list')->with($this->hash);
    }



    // ログイン
    public function login(Request $request)
    {
        $this->_pre($request);  // 前処理

        // POSTログイン処理時
        if($_SERVER["REQUEST_METHOD"] == 'POST' || @$this->hash['yahoo_token'] || @$this->hash['twitter_id']) {

            // ユーザー検索
            $users = $this->_findUser();

            // 認証成功
            if($users) {
                // トークン生成
                $access_token = sha1(uniqid(rand(), true));

                // ユーザーDB アクセストークン再発行
                $users->access_token = $access_token;
                $users->save();

                // ログインセッション 生成
                session(['_access_token' => $access_token]);

                // リダイレクト (指定先か topへ) クエリーパラメータも保持して渡す
                $callback_url = Session::get('SESSION_KEY_CALLBACK');
                Session::forget('SESSION_KEY_CALLBACK');
                Redirect::to(($callback_url ?? '/'))->send();
                return '';
            }
        }

        // クエリーパラメータ取得
        session(['SESSION_KEY_CALLBACK' => @$this->hash['callback_url']]);

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.login')->with($this->hash);
    }


    // ユーザー検索
    protected function _findUser()
    {

        switch ($this->hash['sns']) {
            case Consts::SNS_NONE:
                return $this->_findUserByEmail();
            case Consts::SNS_FACEBOOK:
                return $this->_findUserByFacebook();
            case Consts::SNS_GOOGLE_PLUS:
                return $this->_findUserByGooglePlus();
            case Consts::SNS_YAHOO:
                return $this->_findUserByYahoo();
            case Consts::SNS_TWITTER:
                return $this->_findUserByTwitter();
        }
        return false;
    }

    // emailログイン
    protected function _findUserByEmail()
    {
        // 必要情報が無い
        if (!$this->hash['email'] || !$this->hash['password']) {
            session(['_flash_message' => 'E1004']);
            return false;
        }

        // 該当ユーザー無し
        $users = Users::where([['email', $this->hash['email']],['status', 1]])->first();
        if (!$users) {
            session(['_flash_message' => 'E1004']);
            return false;
        }

        // パスワード不一致
        if(!password_verify($this->hash['password'], $users->password)) {
            session(['_flash_message' => 'E1004']);
            return false;
        }

        return $users;
    }

    // curlget接続
    protected function _CurlGetRequest($url='')
    {
        if(!$url) return false;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        
        if(!$response) return false;

        return json_decode($response, true);
    }

    // facebookログイン
    protected function _findUserByFacebook()
    {
        // 必要情報が無い
        if (!$this->hash['user_id'] || !$this->hash['access_token']) {
            session(['_flash_message' => 'E1012']); // facebook認証に失敗
            return false;
        }

        // Facebookログインによって取得したUserIDとAccessTokenからEmailを取得
        $url = 'https://graph.facebook.com/v2.7/' . $this->hash['user_id'] . '?access_token=' . $this->hash['access_token'] . '&fields=id,email';
        $result = $this->_CurlGetRequest($url);
        if (!$result) {
            session(['_flash_message' => 'E1012']); // facebook認証に失敗
            return false;
        }

        if (!$result['email']) {
            session(['_flash_message' => 'E1012']); // facebook認証に失敗
//            $this->_setErrorMessage(0, '認証に失敗しました。',  'Facebookアカウントからメールアドレスを取得できませんでした。Facebookアカウントが認証されていない可能性があります。');
            return false;
        }

        // 該当ユーザー検索
        $users = Users::where([['sns_type', Consts::SNS_FACEBOOK],['sns_userid', $result['id']],['status', 1]])->first();

        if (!$users) {
            session(['_flash_message' => 'E1012']); // facebook認証に失敗
//            $this->_setErrorMessage(1, '認証に失敗しました。',  'ソーシャルアカウント認証できませんでした。メールアドレスとパスワードでログインをしてソーシャルアカウント連携の設定をご確認ください。');
            return false;
        }

        return $users;
    }

    // googleログイン
    protected function _findUserByGooglePlus()
    {
        // 必要情報が無い
        if (!$this->hash['user_id'] || !$this->hash['access_token']) {
            session(['_flash_message' => 'E1013']); // google認証に失敗
            return false;
        }

        // Googleログインによって取得したUserIDとAccessTokenからIDを取得
        $url = 'https://www.googleapis.com/plus/v1/people/' .$this->hash['user_id']. '?access_token=' . $this->hash['access_token'] . "&scope=email";
        $result = $this->_CurlGetRequest($url);
        if (!$result) {
            session(['_flash_message' => 'E1013']); // google認証に失敗
            return false;
        }

        // 該当ユーザー検索
        $users = Users::where([['sns_type', Consts::SNS_GOOGLE_PLUS],['sns_userid', $result['id']],['status', 1]])->first();
        if (!$users) {
            session(['_flash_message' => 'E1013']); // google認証に失敗
//            $this->_setErrorMessage(1, '認証に失敗しました。',  'ソーシャルアカウント認証できませんでした。メールアドレスとパスワードでログインをしてソーシャルアカウント連携の設定をご確認ください。');
            return false;
        }

        return $users;
    }

    // yahooログイン
    protected function _findUserByYahoo()
    {
        // 必要情報が無い
        if (!$this->hash['yahoo_token']) {
            session(['_flash_message' => 'E1011']); // yahoo認証に失敗
            return false;
        }

        $userInfo = $this->_getYahooProfile($this->hash['yahoo_token']);
        if (!$userInfo) {
            session(['_flash_message' => 'E1011']); // yahoo認証に失敗
            return false;
        }

        // 該当ユーザー検索
        $users = Users::where([['sns_type', Consts::SNS_YAHOO],['sns_userid', $userInfo['user_id']],['status', 1]])->first();
        if (!$users) {
            session(['_flash_message' => 'E1011']); // yahoo認証に失敗
//            $this->_setErrorMessage(1, '認証に失敗しました。',  'ソーシャルアカウント認証できませんでした。メールアドレスとパスワードでログインをしてソーシャルアカウント連携の設定をご確認ください。');
            return false;
        }

        return $users;
    }

    protected function _findUserByTwitter()
    {
        // ユーザー検索
        if ($users = Users::where([['sns_type', Consts::SNS_TWITTER],['sns_userid', $this->hash['twitter_id']]])->first()) {
            return $users;
        }
        session(['_flash_message' => 'E1010']); // twuitter認証に失敗
        return false;
    }

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

            case 'E1002':
                $this->hash['error_title']      = 'ユーザー仮登録エラー';
                $this->hash['error_message']    = 'ユーザーの仮登録に失敗しました。お手数ですが再登録してください。';
                break;

            case 'E1003':
                $this->hash['error_title']      = 'ユーザー本登録エラー';
                $this->hash['error_message']    = '既に該当メールアドレスは登録済です。ログインしてください。';
                break;

            case 'E1004':
                $this->hash['error_title']      = 'メールアドレスまたはパスワードが違います。';
                $this->hash['error_message']    = 'ご入力いただいたアドレスやパスワードに間違いや空白が無いかご確認ください。ご登録が未だの場合は会員登録をお願いいたします。';
                break;

            case 'E1005':
                $this->hash['error_title']      = 'メールアドレスの指定がありません';
                $this->hash['error_message']    = 'ご入力をお願いいたします。';
                break;

            case 'E1006':
                $this->hash['error_title']      = '情報変更用認証キーが一致しません';
                $this->hash['error_message']    = '情報を変更する場合、再度ご対応願います。';
                break;

            case 'E1007':
                $this->hash['error_title']      = '入力されていないパスワードがあります';
                $this->hash['error_message']    = 'パスワードをご入力ください';
                break;

            case 'E1008':
                $this->hash['error_title']      = '入力した現在のパスワードが一致しません';
                $this->hash['error_message']    = 'ご入力いただいたパスワードに間違いが無いかご確認ください。';
                break;

            case 'E1009':
                $this->hash['error_title']      = '入力した新パスワードが一致しません';
                $this->hash['error_message']    = 'ご入力いただいたパスワードに間違いが無いかご確認ください。';
                break;

            case 'E1010':
                $this->hash['error_title']      = 'Twitterでの認証に失敗しました。';
                $this->hash['error_message']    = 'ご入力いただいたアカウントに間違いが無いかご確認ください。';
                break;

            case 'E1011':
                $this->hash['error_title']      = 'Yahooでの認証に失敗しました。';
                $this->hash['error_message']    = 'ご入力いただいたアカウントに間違いが無いかご確認ください。';
                break;

            case 'E1012':
                $this->hash['error_title']      = 'Facebookでの認証に失敗しました。';
                $this->hash['error_message']    = 'ご入力いただいたアカウントに間違いが無いかご確認ください。';
                break;

            case 'E1013':
                $this->hash['error_title']      = 'googleでの認証に失敗しました。';
                $this->hash['error_message']    = 'ご入力いただいたアカウントに間違いが無いかご確認ください。';
                break;

            case 'E1014':
                $this->hash['error_title']      = 'ログインが必要です';
                $this->hash['error_message']    = 'ID、パスワードをご入力いただきログインしてください。';
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

    // ログアウト
    public function logout(Request $request)
    {
        $this->_pre($request);  // 前処理

        // ログインセッション 破棄
        Session::forget('_access_token');

        return view('user.logout')->with($this->hash);
    }


    // メールアドレス変更(入力・メール送信)
    public function change_email(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 :会員専用

        // POSTログイン処理時
        if($_SERVER["REQUEST_METHOD"] == 'POST') {

            // メルマガ受信指定 更新
            if($this->hash['change_mail_magazine'] ?? '') {
                $this->user->mail_magazine = $this->hash['mail_magazine'];
                $this->user->save();

                Redirect::to('/user/change_email'.$this->getURLParam())->send();
                return '';
            }

            // SNS登録・解除
            if ($this->hash['change_mail_magazine'] === 'change_sns') {
/*
                if ($snsMember = $this->_changeSns($snsMemberAttributes)) {

                    // sns変更内容をセッションのログイン情報へ反映
                    $this->_setSessionLoginComplete($snsMember);

                    // 完了画面へ遷移
                    HTTP_Session2::set(Consts::SESSION_KEY_CHANGE_SNS_COMPLETE, $_POST['action_detail']);
                    $this->redirect('/user/change_sns_complete'.$this->getURLParam());
                    Redirect::to('/user/change_email'.$this->getURLParam())->send();
                }
*/
            }

            // メールアドレス未入力の場合
            if(!$this->hash['email'] || !$this->hash['new_email']) {
                session(['_flash_message' => 'E1005']);
                Redirect::to('/user/change_email'.$this->getURLParam())->send();
                return '';
            }

            // email変更時認証用キー発行
            $reissue_key = hash('sha256', uniqid() . $this->hash['new_email']);

            // メールアドレス: change_type=1 で認証キーレコード参照
            $reissue = ChangeStatusReissueKeys::select()->where('user_id', $this->user->id)->where('change_type', 1)->first();
            if ($reissue) {
                $reissue->reissue_key = $reissue_key;
                $reissue->access_token = Session::get('_access_token');
                $reissue->change_param = $this->hash['new_email'];
                $reissue->save();
            } else {
                ChangeStatusReissueKeys::insert(
                    ['change_type' => 1, 'user_id' => $this->user->id, 'reissue_key' => $reissue_key, 'access_token' => Session::get('_access_token'), 'change_param' => $this->hash['new_email']]
                );
            }

            // メール送信パラメータ
            $options = [
                'from'      => env('MAIL_FROM_ADDRESS'),
                'from_name' => Consts::CONTENT_TITLE,
                'to'        => $this->hash['new_email'],
                'subject'   => Consts::CONTENT_TITLE.' 変更確認メール',
                'template'  => 'emails.changeEmail',
            ];

            // メールテンプレート置換パラメータ
            $data = [
                'serviceName' => Consts::CONTENT_TITLE,
                'url' => url('/').'/user/change_email_complete/'.$reissue_key,
                'contents_url' => url('/'),
            ];

            // メール送信
            Mail::to($options['to'])->send(new CommonMail($options, $data));

            $this->hash['method_type'] = 'post';    // 画面出し分け用

            return view('user.change_email')->with($this->hash);
        }

        // 画面出力
        $this->hash['email'] = $this->user->email;
        $this->hash['mail_magazine'] = $this->user->mail_magazine;

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.change_email')->with($this->hash);
    }


    // メールアドレス変更(更新完了)
    public function change_email_complete(Request $request, $reissue_key = '')
    {
        $this->_pre($request);  // 前処理

        // メール: change_type=1 で認証キーレコード参照
        $reissue = ChangeStatusReissueKeys::select()->where('reissue_key', $reissue_key)->where('change_type', 1)->first();
        if ($reissue) {

            // 変更後email画面表示
            $this->hash['new_email'] = $reissue->change_param;

            // ユーザーのemail更新, トークン削除
            $users = Users::where([['access_token', $reissue->access_token],['status', 1]])->first();
            $users->email = $this->hash['new_email'];
            $users->access_token = '';
            $users->save();

            // 変更情報保存DB 削除
            $reissue->delete();

            // ログインセッション 破棄
            Session::forget('_access_token');

        } else {
            session(['_flash_message' => 'E1006']);   // 認証キー無し
            Redirect::to('/user/change_email'.$this->getURLParam())->send();
            return '';
        }

        return view('user.change_email_complete')->with($this->hash);
    }

    // パスワード変更(入力)
    public function change_password(Request $request)
    {
        $this->_pre($request, 1);  // 前処理 :会員専用

        // POSTログイン処理時
        if($_SERVER["REQUEST_METHOD"] == 'POST') {

            // パスワード未入力の場合
            if(!$this->hash['password'] || !$this->hash['new_password'] || !$this->hash['re_new_password']) {
                session(['_flash_message' => 'E1007']);
                Redirect::to('/user/change_password'.$this->getURLParam())->send();
                return '';
            }

            // ログインセッションと入力した現パスワード不一致の場合
            if(!password_verify($this->hash['password'], $this->user->password)) {
                session(['_flash_message' => 'E1008']);
                Redirect::to('/user/change_password'.$this->getURLParam())->send();
                return '';
            }

            // パスワード不一致の場合
            if($this->hash['new_password'] != $this->hash['re_new_password']) {
                session(['_flash_message' => 'E1009']);
                Redirect::to('/user/change_password'.$this->getURLParam())->send();
                return '';
            }

            // ユーザーのパスワード更新, トークン削除
            $this->user->password = bcrypt($this->hash['new_password']);
//            $this->user->access_token = '';
            $this->user->save();

            $this->hash['method_type'] = 'post';    // 画面出し分け用

            // ログインセッション 破棄 !!!
//            Session::forget('_access_token');
        }

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('user.change_password')->with($this->hash);
    }

    // デフォルトURLパラメータを出力
    protected function getURLParam($param = '')
    {
        return ($this->URLParam) ? '?'.($param ? $param.'&' : '').$this->URLParam : ($param ? '?'.$param : '');
    }
//////////////////////////////////

    // twitter認証
    public function twitterRegister()
    {
        // twitter認証用リダイレクト
        $tokens = $this->_getTwitterRequestToken();
        if ($tokens) {
            session(['SESSION_KEY_TWITTER_REQUEST_TOKEN' => $tokens]);
            Redirect::to('https://api.twitter.com/oauth/authenticate?oauth_token=' . $tokens['oauth_token'])->send();
            return '';
        }

        session(['_flash_message' => 'E1010']); // Twitterでの認証に失敗しました。
        Redirect::to('/user/regist_input'.$this->getURLParam())->send();
        return '';
    }

    // twitter認証トークン取得
    protected function _getTwitterRequestToken($type = 'register')
    {
        $action = ['register' => 'twitter_callback','changer' => 'change','login' => 'twitter_login_callback'];

        $params = array(
            'oauth_callback'            => url('/').'/user/'.$action[$type].$this->getURLParam(),
            'oauth_consumer_key'        => Consts::TWITTER_KEY,
            'oauth_nonce'               => microtime(),
            'oauth_signature_method'    => 'HMAC-SHA1',
            'oauth_timestamp'           => time(),
            'oauth_version'             => '1.0',
        );

        foreach ($params as $key => $value) {
            if ($key == 'oauth_callback') {
                continue;
            }
            $params[$key] = rawurlencode($value);
        }

        $request_url = 'https://api.twitter.com/oauth/request_token';

        $request_params = rawurlencode(str_replace( array( '+', '%7E' ), array( '%20', '~' ), http_build_query($params, '', '&')));
        $hash = hash_hmac('sha1', rawurlencode('POST').'&'.rawurlencode($request_url).'&'.$request_params, rawurlencode(Consts::TWITTER_SECRET).'&', TRUE);
        $params['oauth_signature'] = base64_encode($hash);
        ksort($params);

        $header_params = http_build_query($params, '', ',');
        $context = array(
            'http' => array(
                'method' => 'POST' ,
                'header' => array(
                    'Authorization: OAuth ' . $header_params,
                ),
            ),
        );

        // HttpUtilsだと401になる為、curlで
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,             $request_url);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,   $context['http']['method']);
        curl_setopt($curl, CURLINFO_HEADER_OUT,     true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,  false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,  false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,  true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,      $context['http']['header']);
        curl_setopt($curl, CURLOPT_FAILONERROR,     true);
        curl_setopt($curl, CURLOPT_TIMEOUT,         5);
        $response = curl_exec($curl);
        curl_close($curl);

        $tokens = array();
        $response = explode('&', $response);
        foreach ($response as $key => $value) {
            $value = explode('=', $value);
            $tokens[$value[0]] = $value[1];
        }
        return $tokens;
    }

    // twitter アクセストークン取得
    protected function _getTwitterAccessToken($request)
    {
        // 全て取得
        $this->hash = $request->all();

        $params = array(
            'oauth_consumer_key'        => Consts::TWITTER_KEY,
            'oauth_nonce'               => md5(uniqid(rand(), true)),
            'oauth_token'               => $this->hash['oauth_token'],
            'oauth_verifier'            => $this->hash['oauth_verifier'],
            'oauth_signature_method'    => 'HMAC-SHA1',
            'oauth_timestamp'           => time(),
            'oauth_version'             => '1.0',
        );

        foreach ($params as $key => $value) {
            $params[$key] = rawurlencode($value);
        }

        $request_url = 'https://api.twitter.com/oauth/access_token';

        $request_params = rawurlencode(str_replace( array( '+', '%7E' ), array( '%20', '~' ), http_build_query($params, '', '&')));
        $signature_data = rawurlencode('POST') . '&' . rawurlencode($request_url) . '&' . $request_params;

        // セッションに保存したトークン
        $requestToken = Session::get('SESSION_KEY_TWITTER_REQUEST_TOKEN');

        // consumerSecret だけでなく、リダイレクト前に取得した token_secret を後ろに繋げる
        $signature_key = rawurlencode(Consts::TWITTER_SECRET) . '&' . rawurlencode($requestToken['oauth_token_secret']);

        $hash = hash_hmac('sha1', $signature_data, $signature_key, TRUE);

        $params['oauth_signature'] = base64_encode($hash);
        ksort($params);

        $header_params = http_build_query($params, '', ',');
        $context = array(
            'http' => array(
                'method' => 'POST' ,
                'header' => array(
                    'Authorization: OAuth ' . $header_params,
                ),
            ),
        );

        // HttpUtilsだと401になる為、curlで
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL,             $request_url);
        curl_setopt($curl, CURLINFO_HEADER_OUT,     true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST,   $context['http']['method']);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,  false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,  false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,  true);
        curl_setopt($curl, CURLOPT_FAILONERROR,     true);
        curl_setopt($curl, CURLINFO_HEADER_OUT,     true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,      $context['http']['header']);
        curl_setopt($curl, CURLOPT_TIMEOUT,         5);
        $response = curl_exec($curl);

        curl_close($curl);
        if ($response === false) {
            session(['_flash_message' => 'E1010']); // Twitterでの認証に失敗しました。
            return false;
        }
        $tokens = array();
        $response = explode('&', $response);
        foreach ($response as $key => $value) {
            $value = explode('=', $value);
            $tokens[$value[0]] = $value[1];
        }
        return $tokens;
    }

    
    public function twitterCallback(Request $request)
    {
        // 全て取得
        $this->hash = $request->all();

        $tokens = $this->_getTwitterAccessToken($request);
        if ($tokens) {
            session(['SESSION_KEY_TWITTER_ACCESS_TOKEN' => $tokens]);
            Redirect::to('/user/regist_input'.$this->getURLParam('sns='.Consts::SNS_TWITTER.'&twitter_id='.$tokens['user_id']))->send();
            return '';
        }
        session(['_flash_message' => 'E1010']); // Twitterでの認証に失敗しました。
        Redirect::to('/user/regist_input'.$this->getURLParam())->send();
    }

    public function twitterLogin()
    {
        // twitter認証用リダイレクト
        $tokens = $this->_getTwitterRequestToken('login');
        if ($tokens) {
            session(['SESSION_KEY_TWITTER_REQUEST_TOKEN' => $tokens]); // Twitterでの認証に失敗しました。
            Redirect::to('https://api.twitter.com/oauth/authenticate?oauth_token=' . $tokens['oauth_token'])->send();
            return '';
        }
        session(['_flash_message' => 'E1010']); // Twitterでの認証に失敗しました。
        Redirect::to('/user/login'.$this->getURLParam())->send();
    }

    public function twitterLoginCallback(Request $request)
    {
        $tokens = $this->_getTwitterAccessToken($request);
        if ($tokens) {
            session(['SESSION_KEY_TWITTER_ACCESS_TOKEN' => $tokens]); // Twitterでの認証に失敗しました。
            Redirect::to('/user/login'.$this->getURLParam('sns=' . Consts::SNS_TWITTER . '&twitter_id=' . $tokens['user_id']))->send();
            return '';
        }
        session(['_flash_message' => 'E1010']); // Twitterでの認証に失敗しました。
        Redirect::to('/user/login'.$this->getURLParam())->send();
    }

    public function twitterChanger()
    {
        $tokens = $this->_getTwitterRequestToken('changer');
        if ($tokens) {
            HTTP_Session2::set(Consts::SESSION_KEY_TWITTER_REQUEST_TOKEN, $tokens);
            Redirect::to('https://api.twitter.com/oauth/authenticate?oauth_token=' . $tokens['oauth_token'])->send();
            return '';
        }
        session(['_flash_message' => 'E1010']); // Twitterでの認証に失敗しました。
        Redirect::to('/user/change_email'.$this->getURLParam())->send();
        return '';
    }


    public function yahooRegister(Request $request)
    {
        if ($request->code) {
            if ($token = $this->_getYahooRequestToken($request)) {
                if ($userInfo = $this->_getYahooProfile($token['access_token'])) {
                    Redirect::to('/user/regist_input'.$this->getURLParam('yahoo_id='.$userInfo['user_id'].'&sns='.Consts::SNS_YAHOO))->send();
                    return '';
                }
            }
        }
        session(['_flash_message' => 'E1011']); // Yahooでの認証に失敗しました。
        Redirect::to('/user/regist_input'.$this->getURLParam())->send();
        return '';
    }

    public function yahooLogin(Request $request)
    {
        if ($request->code) {
            if($token = $this->_getYahooRequestToken($request, 'login')){
                Redirect::to('/user/login'.$this->getURLParam('yahoo_token='.$token['access_token']))->send();
                return '';
            }
        }
        session(['_flash_message' => 'E1011']); // Yahooでの認証に失敗しました。
        Redirect::to('/user/login'.$this->getURLParam())->send();
        return '';
    }

    protected function _getYahooRequestToken(Request $request, $type = 'register')
    {
        $action = ['register' => 'yahoo_register','changer' => 'change','login' => 'yahoo_login'];
        $params = array(
            'grant_type'    => 'authorization_code',
            'code'          => $request->code,
            'redirect_uri'  => rawurlencode(url('/').'/user/'.$action[$type].$this->getURLParam()),
        );

        $header = array(
          "Authorization" => "Basic ". base64_encode(Consts::YAHOO_ID . ':' . Consts::YAHOO_SECRET),
        );
        $response = HTTPUtils::postWithoutProxy("https://auth.login.yahoo.co.jp/yconnect/v1/token", $params, $header);
        if ($response->getStatus() !== 200) {
            return false;
        }
        return json_decode($response->getBody(), true);
    }

    protected function _getYahooProfile($token)
    {
        $params = array('schema' => 'openid');
        $userinfoUrl = "https://userinfo.yahooapis.jp/yconnect/v1/attribute?".http_build_query($params);

        $response = HTTPUtils::postWithoutProxy($userinfoUrl, $params, array('Authorization' => 'Bearer '.$token));
        if ($response->getStatus() !== 200) {
            return false;
        }
        return json_decode($response->getBody(), true);
    }



/*

    protected function _changeSns($snsMemberAttributes)
    {

        $snsMemberDao = new SnsMemberDao();
        $snsMember = $snsMemberDao->findById($snsMemberAttributes['id']);
        if ($_POST['action_detail'] === 'attach') {
            // SNS連携
            switch ($_POST['sns']) {
                case Consts::SNS_GOOGLE_PLUS:
                    return $this->_attachGoogle($snsMember);
                case Consts::SNS_YAHOO:
                    return $this->_attachYahoo($snsMember);
                case Consts::SNS_FACEBOOK:
                    return $this->_attachFacebook($snsMember);
                case Consts::SNS_TWITTER:
                    return $this->_attachTwitter($snsMember);
                case Consts::SNS_LINE:
                    break;
            }
        } else if ($_POST['action_detail'] === 'detach') {
            // SNS解除
            $SnsMemberSnsMapDao = new SnsMemberSnsMapDao();
            $SnsMemberSnsMapDao->deleteMap($snsMember->id);
            $snsMember->sns = Consts::SNS_NONE;
            $snsMember->save();
            return $snsMember;
        }
    }

    protected function _attachFacebook($snsMember)
    {
        $userId = $_POST['user_id'];
        $accessToken = $_POST['access_token'];

        $SnsMemberSnsMapDao = new SnsMemberSnsMapDao();
        if ($SnsMemberSnsMap = $SnsMemberSnsMapDao->findBySnsMemberId($snsMember->id) && $SnsMemberSnsMap->sns == Consts::SNS_FACEBOOK) {
            $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のFacebookアカウントはすでに登録されています。ログインをしてください。');
            return false;
        }

        if (empty($userId) || empty($accessToken)) {
            $this->_setSystemError('EA1021');
            return false;
        }

        // Facebook APIからemailを取得
        $response = HTTPUtils::getWithoutProxy('https://graph.facebook.com/v2.7/'.$userId.'?access_token='.$accessToken.'&fields=id,email');
        if ($response->getStatus() !== 200) {
            $this->_setSystemError('EA1022');
            return false;
        }

        // emailの確認
        $result = json_decode($response->getBody(), true);
        $snsMemberDao = new SnsMemberDao();
        if ($snsMemberDao->findByServiceCodeAndSnsAndSnsUserId($this->serviceCode, Consts::SNS_FACEBOOK, $result['id'])) {
            $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のFacebookアカウントはすでに登録されています。別のFacebookアカウントで登録をお願いいたします。');
            return false;
        }

        // sns連携 DB更新
        $this->_attachSNS($snsMember, Consts::SNS_FACEBOOK, $result['id']);

        return $snsMember;
    }

    protected function _attachGoogle($snsMember)
    {

        $SnsMemberSnsMapDao = new SnsMemberSnsMapDao();
        if ($SnsMemberSnsMap = $SnsMemberSnsMapDao->findBySnsMemberId($snsMember->id) && $SnsMemberSnsMap->sns == Consts::SNS_GOOGLE_PLUS) {
            $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のGoogleアカウントはすでに登録されています。ログインをしてください。');
            return false;
        }

        $accessToken = $_POST['access_token'];
        if (empty($accessToken)) {
            $this->_setSystemError('EA1024');
            return false;
        }

        $response = HTTPUtils::getWithoutProxy('https://www.googleapis.com/plus/v1/people/me?access_token='.$accessToken.'&scope=email');
        if ($response->getStatus() !== 200) {
            $this->_setSystemError('EA1025');
            return false;
        }
        $result = json_decode($response->getBody(), true);

        $snsMemberDao = new SnsMemberDao();
        if ($snsMemberDao->findByServiceCodeAndSnsAndSnsUserId($this->serviceCode, Consts::SNS_GOOGLE_PLUS, $result['id'])) {
            $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のGoogleアカウントはすでに登録されています。別のGoogleアカウントで登録をお願いいたします。');
             return false;
        }

        // sns連携 DB更新
        $this->_attachSNS($snsMember, Consts::SNS_GOOGLE_PLUS, $result['id']);

        return $snsMember;
    }

    protected function _attachYahoo($snsMember)
    {

        $SnsMemberSnsMapDao = new SnsMemberSnsMapDao();
        if ($SnsMemberSnsMap = $SnsMemberSnsMapDao->findBySnsMemberId($snsMember->id) && $SnsMemberSnsMap->sns == Consts::SNS_YAHOO) {
            $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のYahooアカウントはすでに登録されています。ログインをしてください。');
            return false;
        }

        $code = $_GET['code'];
        if (empty($code)) {
            $this->_setSystemError('EA1027');
            return false;
        }
        if($token = $this->_getYahooRequestToken('changer')){
            if ($userInfo = $this->_getYahooProfile($token['access_token'])) {
                $snsMemberDao = new SnsMemberDao();
                if ($snsMemberDao->findByServiceCodeAndSnsAndSnsUserId($this->serviceCode, Consts::SNS_YAHOO, $userInfo['user_id'])) {

                    $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のYahooアカウントはすでに登録されています。別のYahooアカウントで登録をお願いいたします。');
                    return false;
                }

                // sns連携 DB更新
                $this->_attachSNS($snsMember, Consts::SNS_YAHOO, $userInfo['user_id']);

                return $snsMember;
            }
        }
        $this->_setSystemError('EA1029');
        return false;
    }

    protected function _attachTwitter($snsMember)
    {
        $SnsMemberSnsMapDao = new SnsMemberSnsMapDao();
        if ($SnsMemberSnsMap = $SnsMemberSnsMapDao->findBySnsMemberId($snsMember->id) && $SnsMemberSnsMap->sns == Consts::SNS_TWITTER) {
            $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のtwitterアカウントはすでに登録されています。ログインをしてください。');
            return false;
        }

        $tokens = $this->_getTwitterAccessToken();
        if (!$tokens) {
            $this->_setErrorMessage(1, '認証に失敗しました。', 'ソーシャルアカウント認証できませんでした。メールアドレスとパスワードでログインをしてソーシャルアカウント連携の設定をご確認ください。');
            return false;
        }

        $snsMemberDao = new SnsMemberDao();
        if ($snsMemberDao->findByServiceCodeAndSnsAndSnsUserId($this->serviceCode, Consts::SNS_TWITTER, $tokens['user_id'])) {
            $this->_setErrorMessage(0, '既にアカウント登録されています。', '該当のtwitterアカウントはすでに登録されています。別のtwitterアカウントで登録をお願いいたします。');
            return false;
        }

        // sns連携 DB更新
        $this->_attachSNS($snsMember, Consts::SNS_TWITTER, $tokens['user_id']);

        return $snsMember;
    }


*/

}
