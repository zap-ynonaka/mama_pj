<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;    // コントローラー
use Illuminate\Http\Request;            // リクエスト
use Log;                                // ログ出力
use DB;                                 // DB接続
use App\Consts;                         // 定数
use App\Http\Controllers\LogicTrait;    // ロジック
use App\Models\Users;                   // DB ユーザー
use Redirect;                           // エラー時リダイレクト
use Session;                            // セッション

// ユーザー管理
class AdminController extends Controller
{

    protected $hash;        // 画面出力内容
    protected $user;        // ユーザー情報

    // 前処理
    protected function _pre($request, $member=0)
    {
        // 全て取得
        $this->hash = $request->all();

        return '';
    }

    // ユーザー情報取得
    public function users(Request $request)
    {
        $this->_pre($request);

        // ユーザー一覧取得
        $this->hash['users'] = Users::where([])->orderBy('id')->get();
/*
        $tmp = array();
        foreach ($this->hash['favorite'] as $f) {

            $f->result_text = json_decode($f->result_text, true) ?? '';
            if(isset($f->result_text['summary'])) $f->summary = $f->result_text['summary'];
        }
*/

        $this->_FlashMssage2ErrorMessage(); // エラー出力

        return view('admin.users')->with($this->hash);
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
