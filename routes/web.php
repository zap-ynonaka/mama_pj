<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});
*/
Route::get('/', 'IndexController@index')->name('test');


// ユーザー認証系
Route::prefix('user')->namespace('User')->group(function() {

    // 会員登録 (input -> mailsend -> 受信メール内リンク -> 認証完了)
    Route::get('regist_input',     'UserController@regist_input')->name('user.regist_input');
    Route::get('regist_mailsend',  'UserController@regist_mailsend')->name('user.regist_mailsend');
    Route::post('regist_mailsend', 'UserController@regist_mailsend')->name('user.regist_mailsend');
    Route::get('regist_complete',  'UserController@regist_complete')->name('user.regist_complete');

    // sns認証
    Route::get('twitter_register',          'UserController@twitterRegister')->name('user.twitterRegister');
    Route::get('twitter_callback',          'UserController@twitterCallback')->name('user.twitterCallback');
    Route::get('twitter_login',             'UserController@twitterLogin')->name('user.twitterLogin');
    Route::get('twitter_login_callback',    'UserController@twitterLoginCallback')->name('user.twitterLoginCallback');
    Route::get('yahoo_register',            'UserController@yahooRegister')->name('user.yahooRegister');
    Route::get('yahoo_login',               'UserController@yahooLogin')->name('user.yahooLogin');

    // ログイン
    Route::get('login',     'UserController@login')->name('user.login');
    Route::post('login',    'UserController@login')->name('user.login');

    // ログアウト
    Route::get('logout',    'UserController@logout')->name('user.logout');
    Route::post('logout',   'UserController@logout')->name('user.logout');

    // アカウント管理
    Route::get('account',   'UserController@account')->name('user.account');

    // メールアドレス変更
    Route::get('change_email',                          'UserController@change_email')->name('user.change_email');
    Route::post('change_email',                         'UserController@change_email')->name('user.change_email');
    Route::get('change_email_complete/{reissue_key}',   'UserController@change_email_complete')->where(['reissue_key' => '[a-zA-Z0-9]+'])->name('user.change_email_complete');

    // パスワード変更
    Route::get('change_password',   'UserController@change_password')->name('user.change_password');
    Route::post('change_password',  'UserController@change_password')->name('user.change_password');

    // 退会
    Route::get('unregist',     'UserController@unregist')->name('user.unregist');
    Route::post('unregist',    'UserController@unregist')->name('user.unregist');

    // プロフ系

    // プロフィール(自分)
    Route::get('my_profile',     'UserProfileController@myProfile')->name('user.my_profile');
    Route::post('my_profile',     'UserProfileController@myProfile')->name('user.my_profile');

    // プロフィール(相手)
    Route::get('partner_profile',     'UserProfileController@partnerProfile')->name('user.partner_profile');
    Route::post('partner_profile',     'UserProfileController@partnerProfile')->name('user.partner_profile');

    // プロフィール(子供)
    Route::get('children_profile',     'UserProfileController@childrenProfile')->name('user.children_profile');
    Route::post('children_profile',     'UserProfileController@childrenProfile')->name('user.children_profile');
    Route::get('children_image',     'UserProfileController@childrenImage')->name('user.children_image');
    Route::post('children_image',     'UserProfileController@childrenImage')->name('user.children_image');

    // プロフィール(実母)
    Route::get('my_mother_profile',     'UserProfileController@MyMotherProfile')->name('user.my_mother_profile');
    Route::post('my_mother_profile',     'UserProfileController@MyMotherProfile')->name('user.my_mother_profile');

    // プロフィール(義母)
    Route::get('partner_mother_profile',     'UserProfileController@partnerMotherProfile')->name('user.partner_mother_profile');
    Route::post('partner_mother_profile',     'UserProfileController@partnerMotherProfile')->name('user.partner_mother_profile');

    // マイページ
    Route::get('mypage',     'UserProfileController@mypage')->name('user.mypage');

    // お気に入り
    Route::get('favorite_list',     'UserController@favorite_list')->name('user.favorite_list');
});

// ヘルプサポート系
Route::prefix('help')->namespace('Help')->group(function() {

    // 利用規約
    Route::get('terms', 'HelpController@terms');

    // プライバシーポリシー
    Route::get('privacy', 'HelpController@privacy');
});

// 管理ツール系
Route::prefix('admin')->namespace('Admin')->group(function() {

    // ユーザー検索
    Route::get('users',     'AdminController@users')->name('admin.users');

    // 管理ツール系
    Route::prefix('data')->namespace('Data')->group(function() {
        // DBデータ取得、反映
        Route::get('/',     'AdminDataController@index')->name('admin.data.index');
        Route::post('/',    'AdminDataController@index')->name('admin.data.index');
    });
});

// コンテンツ系
Route::prefix('contents')->namespace('Contents')->group(function() {

    // TOP
    Route::get('/',     'ContentsController@index')->name('contents.index');
    Route::post('/',     'ContentsController@index')->name('contents.index');
    // 一覧
    Route::get('/list/{corners_id}',     'ContentsController@list')->where(['corners_id' => '[0-9]+'])->name('contents.list');
    // 結果
    Route::get('/result/{menus_id}',     'ContentsController@result')->where(['menus_id' => '[0-9]+'])->name('contents.result');

});

// ユーザー認証系
Route::prefix('user')->namespace('User')->group(function() {

});



