<?php
namespace App;

class Consts
{
    const CONTENT_TITLE = 'ママ占い';            // サイトタイトル
    const SSL_CRYPT_KEY = 'password12345678';   // パスワード暗号化キー

    // SNS認証系 ID群
    const FACEBOOK_ID       = '432823510470422';
    const FACEBOOK_VER      = 'v2.12';
//    const GOOGLE_CLIENT_ID  = '693909655648-lh44a15o1jivg8vienorol5qmp4g9mub.apps.googleusercontent.com';
    const GOOGLE_CLIENT_ID  = '442536207498-kdapisf1mb8fq945fmal6e6ivl79vkqk.apps.googleusercontent.com';
//    const YAHOO_ID          = 'dj0zaiZpPWlLbmx3T1ZTcmdqbiZzPWNvbnN1bWVyc2VjcmV0Jng9Nzk-';
//    const YAHOO_SECRET      = 'b6a1dc47071fe7bb5ac4b7f54248bb8d338ae05f';
    const YAHOO_ID          = 'dj0zaiZpPW1KeU0yVnNNUUJPNCZzPWNvbnN1bWVyc2VjcmV0Jng9OGI';
    const YAHOO_SECRET      = '26b297980522a79acaaae48f4c0ec8209c54327c';
    const TWITTER_KEY       = '6zJyKVCD45s0gvRv8OD19jiOi';
    const TWITTER_SECRET    = 'yM1d4CmQp4dciYTY6dMnCh6FfTHXuESlpmCIQP9mpNbSFSxtY5';

    // SNS認証系 sns定義
    const SNS_NONE          = 'none';   // メール認証
    const SNS_GOOGLE_PLUS   = 'google';
    const SNS_YAHOO         = 'yahoo';
    const SNS_FACEBOOK      = 'facebook';
    const SNS_TWITTER       = 'twitter';



    // .env('APP_ENV')定義
    const ENV_PRO = 'production';
    const ENV_STG = 'staging';
    const ENV_DEV = 'dev';
    const ENV_LCL = 'local';

    // ロジックサーバーURL
    const LOGIC_API_URL = array(
        Consts::ENV_PRO => 'https://fort-api.zappallas.com',
        Consts::ENV_STG => 'https://fort-api-stg.zappallas.com',
        Consts::ENV_DEV => 'https://fort-api-stg.zappallas.com',
        Consts::ENV_LCL => 'https://fort-api-dev.zappallas.com'
    );



}
