<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    // リクエスト
use DB;                         // DB接続
use App\Mail\CommonMail;        // メール用意
use Mail;                       // メール送信
//use App\Utils;
//use App\Consts;
//use App\Models\Item;
//use App\Models\ItemMenu;
//use App\Models\Counselor;
use Log;

class TestController extends Controller
{
    protected $hash;   // 画面出力内容
    use LogicTrait;    // ロジック接続関連

    // 前処理
    public function __construct()
    {
    }

    // ママ占いトップ
    public function index(Request $request)
    {

        // DB接続 (オンプレサーバーだとgrant権限もらえないので、サービスアカウント作成をサービス名添えてインフラ依頼をしないとダメ)
        $users = DB::select('SELECT * FROM users ORDER BY id LIMIT 1');
        if(isset($users)) $this->hash['db_res'] = $users[0]->nickname ?? '';


        // メール
        $options = [
            'to'        => 'h_ooki@zappallas.com',
            'subject'   => 'メールタイトル',
            'from'      => env('MAIL_FROM_ADDRESS'),
//            'from_name' => Consts::EMAIL_FROM,
            'from_name' => env('MAIL_FROM_NAME'),
            'template'  => 'emails.sendTest',   // resources/views/emails/sendTest.blade.php
        ];
        $data = ['mailres' => 'メール内変数置換'];
//        Mail::to($options['to'])->send(new CommonMail($options, $data));
        $this->hash['res_mail'] = $options['to'];


        // ロジック接続 (IP穴あけ等の接続確認(社内は設定済、本番のみ対応必要、疎通に明確なメニュー指定が事前に必要))
        $logic_res = $this->_getLogicInformation(2021);
        $this->hash['res_logic'] = $logic_res[0];

        return view('test')->with($this->hash);
    }
}
