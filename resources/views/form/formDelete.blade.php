{{ csrf_field() }}
<input type="hidden" name="id" value="{{@$value['id']}}"><!-- 対象子供ID -->

<div class="button-submit__delete">
  <input type="submit" name="btn_delete" value="削除する" />
</div>
