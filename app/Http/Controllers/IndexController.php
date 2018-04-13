<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;    // リクエスト
use DB;                         // DB接続
use App\Mail\CommonMail;        // メール用意
use Mail;                       // メール送信
use Log;

class IndexController extends Controller
{
    protected $hash;   // 画面出力内容

    // 前処理
    public function __construct()
    {
    }

    // ママ占いトップ
    public function index(Request $request)
    {
        return view('index')->with($this->hash);
    }
}
