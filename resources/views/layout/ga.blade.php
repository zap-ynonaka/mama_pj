<!-- Global Site Tag (gtag.js) - Google Analytics -->

<script async src="https://www.googletagmanager.com/gtag/js?id=UA-106774424-1"></script>
<script type="text/javascript" src="/js/fingerprint.js"></script>
<script>
window.Laravel = window.Laravel || {}
/**
 * @return { Boolean } - ログインステータス
 */
Laravel.loginStatus = function() {
  if (!window.localStorage) return false;
  if (!window.localStorage.vuex) return false;
  var store = JSON.parse(window.localStorage.vuex)
  return store.auth.isLoggedIn;
}


/**
 * @return { String } - ユーザーのCPNO(無い場合は空の文字列)
 */
Laravel.userCpno = function() {
  if (!Laravel.loginStatus()) return '';
  var store = JSON.parse(window.localStorage.vuex)
  return store.auth.user.cpno || '';
}

var fingerprint = new Fingerprint({canvas: true}).get();
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments)};
gtag('js', new Date());
gtag('config', 'UA-118367051-1', {
  'custom_map': {
    'dimension1': 'member',
    'dimension2': 'fingerprint',
    'dimension3': 'cpno'
  },
  'member':  (Laravel.loginStatus() == true) ? '1' : '0',             {{-- 会員フラグ --}}
  'fingerprint': fingerprint,                                         {{-- fingerprint_id --}}
  'cpno': @if($cpno ?? '')'{{$cpno}}'@else Laravel.userCpno() @endif  {{-- 流入元  --}}
});

// 画面読み込み後にfingerprint_idタグがあれば値を設定
(window.onload = function() {
  var fingerprint_id = document.getElementById('fingerprint_id');
  if (fingerprint_id) { fingerprint_id.value = fingerprint; }
})();
</script>



