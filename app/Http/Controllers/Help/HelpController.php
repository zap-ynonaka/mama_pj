<?php

namespace App\Http\Controllers\Help;

use App\Http\Controllers\Controller;    // コントローラー
use Illuminate\Http\Request;

class HelpController extends Controller
{
    /**
     * コンテンツについて
     */
    public function about(Request $request)
    {
        return view('help.about');
    }
    /**
     * ヘルプ
     */
    public function help(Request $request)
    {
        return view('help.help');
    }
    /**
     * プライバシーポリシー
     */
    public function privacy(Request $request)
    {
        return view('help.privacy');
    }
    /**
     * クッキー
     */
     public function cookie(Request $request)
     {
         return view('help.cookie');
     }
    /**
     * 利用規約
     */
    public function terms(Request $request)
    {
        return view('help.terms');
    }
    /**
     * 特定商取引法に基づく表示
     */
    public function legal(Request $request)
    {
        return view('help.legal');
    }
}
