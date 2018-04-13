<?php

namespace App\Http\Middleware;

use Closure;
use Session;                            // セッション
use App\Models\Users;                   // DB ユーザー
use Redirect;                           // エラー時リダイレクト
use Log;

class ZapAuth
{
    // 共通処理
    public function handle($request, Closure $next)
    {
        // ユーザー認証 (セッションあればユーザー情報取得)
        if(Session::has('_access_token')) {
            $request->user = Users::where([['access_token', Session::get('_access_token')],['status', 1]])->first();
        }

        // メニュー情報から会員専用画面かどうか判定し対応する？
/*
        // 会員専用でセッション無し( or 期限切れ) or トークン該当ユーザー無し -> ログイン画面へ
        if($member && !$request->user) {
            session(['_flash_message' => 'E1014']);
            Redirect::to('/user/login'.'?callback_url='.urlencode($_SERVER['REQUEST_URI']))->send();
            return '';
        }
*/
        return $next($request);
    }
}
