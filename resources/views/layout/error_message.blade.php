@if (isset($error_message))
<div class="alert" data-color="error">
  <h5 class="alert__title">
    <!-- <i class="material-icons">&#xE000;</i> -->
    <span>{{$error_title ?? ''}}</span>
  </h5>
  @if (isset($error_code) && $error_code)
  <p class="errorCode">
    <small>エラーコード</small>：{{$error_code ?? ''}}
  </p>
  @endif
  <p>{!! $error_message ?? '' !!}</p>
  {{-- 問い合わせリンクは 0:workshop,3:対面鑑定は除外 --}}
  @if (isset($show_inquiry) && $show_inquiry)
    <p>それでも解決しない場合は「お問い合わせ」からご連絡をお願いいたします。</p>
  @endif
  <a href="/help/inquiry" class="btn"
    data-size="xs"
    data-color="danger"
    data-stroke="true"
  >お問い合わせはこちら</a>
</div>
@endif
