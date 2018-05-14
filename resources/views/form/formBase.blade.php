
{{ csrf_field() }}

@foreach(['icon_imgfile', 'nickname', 'last_name', 'last_name_kana', 'first_name', 'first_name_kana', 'birthday', 'birthtime', 'birthtime_unknown', 'birthorder', 'blood', 'gender', 'from_pref', 'birthday_y', 'birthday_m', 'birthday_d','birthtime_h','birthtime_m'] as $key)
  @if (!@$value[$key])
    <?php @$value[$key] = ${$key}; ?>
  @endif
@endforeach
@foreach(['icon_imgfile', 'nickname', 'last_name', 'last_name_kana', 'first_name', 'first_name_kana', 'birthday', 'birthtime', 'birthtime_unknown', 'birthorder', 'blood', 'gender', 'from_pref', 'birthday_y', 'birthday_m', 'birthday_d','birthtime_h','birthtime_m'] as $key)
  @if (!@$value[$key.'2'])
    <?php @$value[$key.'2'] = ${$key.'2'}; ?>
  @endif
@endforeach


@foreach($params as $param)

  @if ($param == 'id')
  <div class="form-item form-item__id">
    <input type="text" value="{{@$value['id']}}" name="cid">
  </div>
  @endif




  @if ($param == 'img')
  <input type="text" value="{{@$value['icon_imgfile']}}" name="icon_imgfile">
  <div class="form-item__imgFix js-child_01">

  </div>
  <div class="form-item__img">
    <div class="js-active ">
      <label>
        <img src="/images/icon_kids/baby-boy.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" checked="checked" value="1" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/baby-girl.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" value="2" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/boy.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" value="3" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/kids-boy.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" value="4" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/kids-girl.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" value="5" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/kids.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" value="6" />
      </label>
    </div>
    <button type="button" class="js-img__submit">決定</button>
  </div>
  @endif


  @if ($param == 'nickname')
  <div class="form-item form-item__nickName">
    <span>ニックネーム</span>
    <div><input type="text" value="{{@$value['nickname']}}" name="nickname"></div>
  </div>
  @endif



  @if ($param == 'name')
  <div class="form-item form-item__name">
    <span>姓名（漢字）</span>
    <div><input type="text" name="last_name" value="{{@$value['last_name']}}"><input type="text" name="first_name" value="{{@$value['first_name']}}"></div>
  </div>

  <div class="form-item form-item__namekana">
    <span>姓名（かな）</span>
    <div><input type="text" name="last_name_kana" value="{{@$value['last_name_kana']}}"><input type="text" name="first_name_kana" value="{{@$value['first_name_kana']}}"></div>
  </div>
  @endif



  @if ($param == 'gender')
  <input type="text" value="{{@$value['gender']}}" name="gender">
  <div class="form-item form-item__gender">
    <span>性別</span>
    <div class="form-area">
      <div>
        <label>
        <input type="radio" class="form-gender__f" name="input-gender" value="f" /><b>女の子</b></label>
      </div>
      <div>
        <label>
        <input type="radio" class="form-gender__m" name="input-gender" value="m" checked="checked" /><b>男の子</b></label>
      </div>
    </div>
  </div>
  @endif




  @if ($param == 'blood')
  <input type="text" value="{{@$value['blood']}}" name="blood">
  <div class="form-item form-item__gender">
    <span>血液型</span>
    <div class="form-area">
      <select name="input-blood">
        <option value="0" selected="selected">不明</option>
        <option value="1">A</option>
        <option value="2">B</option>
        <option value="3">O</option>
        <option value="4">AB</option>
      </select>
    </div>
  </div>
  @endif




  @if ($param == 'birthOrder')
  <input type="text" value="{{@$value['birthorder']}}" name="birthorder">
  <div class="form-item form-item__birthOrder">
    <span>生まれ順</span>
    <div class="form-area">
      <select name="input-birthorder">
        <option value="1">一番上</option>
        <option value="2" selected="selected">真ん中</option>
        <option value="3">末っ子</option>
        <option value="4">一人っ子</option>
        <!-- <option value="5">一番下</option> -->
      </select>
    </div>
  </div>
  @endif



  @if ($param == 'birth')
  <input type="text" value="{{@$value['birthday']}}" name="birthday">
  <div class="form-item form-item__birth form-item__select">
    <span>生年月日</span>
    <div class="form-area">

      <div>
        <select class="form-birthDay__year" name="birthday_y">
          <option value="">--</option>
          @for ($i = 2018; $i >= 1940; $i--)
          <option value="{{ $i }}" @if(@$value['birthday_y'] == $i) selected="selected" @endif>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <span>年</span>
      <div>
        <select class="form-birthDay__month" name="birthday_m">
          <option value="">--</option>
          @for ($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" @if(@$value['birthday_m'] == $i) selected="selected" @endif>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <span>月</span>
      <div>
        <select  class="form-birthDay__day" name="birthday_d">
          <option value="">--</option>
          @for ($i = 1; $i <= 31; $i++)
          <option value="{{ $i }}" @if(@$value['birthday_d'] == $i) selected="selected" @endif>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <span>日</span>

    </div>
  </div>
  @endif




  @if ($param == 'birthTime')
  <input type="text" value="{{@$value['birthtime']}}" name="birthtime">
  <div class="form-item form-item__birthTime form-item__select">
    <span>出生時間</span>
    <div class="form-area">
      <div>
        <select class="form-birthTime__hour" name="input-birthtime_h">
          @if(@$birthtime_unknown) {{@$value['birthtime']=''}} @endif {{-- 不明の場合値消す--}}
          <option value="-1" @if(@$birthtime_unknown) selected="selected" @endif>不明</option>
          @for ($i = 0; $i <= 23; $i++)
          <option value="{{ $i }}" @if(@$value['birthtime_h'] == $i) selected="selected" @endif><?php echo sprintf('%02d',$i);  ?></option>
          @endfor
        </select>
      </div>
      <span>時</span>

      <div>
        <select class="form-birthTime__minute" name="input-birthtime_m">
          <option value="-1" selected="selected">不明</option>
          @for ($i = 0; $i <= 59; $i++)
          <option value="{{ $i }}" @if(@$value['birthtime_m'] == $i) selected="selected" @endif><?php echo sprintf('%02d',$i);  ?></option>
          @endfor
        </select>
      </div>
      <span>分</span>

    </div>
  </div>
  @endif




  @if ($param == 'birthPlace')
  <input type="text" value="{{@$value['from_pref']}}" name="from_pref">
  <div class="form-item form-item__birthPlace form-item__select">
    <span>出生地</span>
    <div class="form-area">
      <div>
        <select name="input-from_pref">
          @foreach($prfile_area as $key => $vale)
          <option value="{{$key}}" @if(@$value['from_pref'] == $key)selected="selected" @endif>{{$vale}}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  @endif


  @if ($param == 'nickname2')
  <div class="form-item form-item__nickName">
    <span>ニックネーム</span>
    <div><input type="text" value="{{@$nickname2}}" name="nickname2"></div>
  </div>
  @endif



  @if ($param == 'name2')
  <div class="form-item form-item__name">
    <span>姓名（漢字）</span>
    <div><input type="text" name="last_name2" value="{{@$last_name2}}"><input type="text" name="first_name2" value="{{@$first_name2}}"></div>
  </div>

  <div class="form-item form-item__namekana">
    <span>姓名（かな）</span>
    <div><input type="text" name="last_name_kana2" value="{{@$last_name_kana2}}"><input type="text" name="first_name_kana2" value="{{@$first_name_kana2}}"></div>
  </div>
  @endif



  @if ($param == 'gender2')
  <input type="text" value="{{@$gender2}}" name="gender2">
  <div class="form-item form-item__gender">
    <span>性別</span>
    <div class="form-area">
      <div>
        <label>
        <input type="radio" class="form-gender__f" name="input-gender" value="f" /><b>女の子</b></label>
      </div>
      <div>
        <label>
        <input type="radio" class="form-gender__m" name="input-gender" value="m" checked="checked" /><b>男の子</b></label>
      </div>
    </div>
  </div>
  @endif




  @if ($param == 'blood2')
  <input type="text" value="{{@$blood2}}" name="blood2">
  <div class="form-item form-item__gender">
    <span>血液型</span>
    <div class="form-area">
      <select name="input-blood">
        <option value="0" selected="selected">不明</option>
        <option value="1">A</option>
        <option value="2">B</option>
        <option value="3">O</option>
        <option value="4">AB</option>
      </select>
    </div>
  </div>
  @endif




  @if ($param == 'birthOrder2')
  <input type="text" value="{{@$birthorder2}}" name="birthorder2">
  <div class="form-item form-item__birthOrder">
    <span>生まれ順</span>
    <div class="form-area">
      <select name="input-birthorder">
        <option value="1">一番上</option>
        <option value="2" selected="selected">真ん中</option>
        <option value="3">末っ子</option>
        <option value="4">一人っ子</option>
        <!-- <option value="5">一番下</option> -->
      </select>
    </div>
  </div>
  @endif




  @if ($param == 'birth2')
  <input type="text" value="{{@$birthday2}}" name="birthday2">
  <div class="form-item form-item__birth form-item__select">
    <span>生年月日</span>
    <div class="form-area">

      <div>
        <select class="form-birthDay__year" name="birthday_y2">
          <option value="">--</option>
          @for ($i = 2018; $i >= 1940; $i--)
          <option value="{{ $i }}" @if(@$value['birthday_y2'] == $i) selected="selected" @endif>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <span>年</span>

      <div>
        <select class="form-birthDay__month" name="birthday_m2">
          <option value="">--</option>
          @for ($i = 1; $i <= 12; $i++)
          <option value="{{ $i }}" @if(@$value['birthday_m2'] == $i) selected="selected" @endif>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <span>月</span>

      <div>
        <select  class="form-birthDay__day" name="birthday_d2">
          <option value="">--</option>
          @for ($i = 1; $i <= 31; $i++)
          <option value="{{ $i }}" @if(@$value['birthday_d2'] == $i) selected="selected" @endif>{{ $i }}</option>
          @endfor
        </select>
      </div>
      <span>日</span>

    </div>
  </div>
  @endif




  @if ($param == 'birthTime2')
  <input type="text" value="{{@$birthtime2}}" name="birthtime2">
  <div class="form-item form-item__birthTime form-item__select">
    <span>出生時間</span>
    <div class="form-area">
      <div>
        <select class="form-birthTime__hour" name="input-birthtime_h">
          <option value="-1" selected="selected">不明</option>
          @for ($i = 0; $i <= 23; $i++)
          <option value="{{ $i }}" @if(@$value['birthtime_h2'] == $i) selected="selected" @endif><?php echo sprintf('%02d',$i);  ?></option>
          @endfor
        </select>
      </div>
      <span>時</span>

      <div>
        <select class="form-birthTime__minute" name="input-birthtime_m">
          <option value="-1" selected="selected">不明</option>
          @for ($i = 0; $i <= 59; $i++)
          <option value="{{ $i }}" @if(@$value['birthtime_m2'] == $i) selected="selected" @endif><?php echo sprintf('%02d',$i);  ?></option>
          @endfor
        </select>
      </div>
      <span>分</span>

    </div>
  </div>
  @endif




  @if ($param == 'birthPlace2')
  <input type="text" value="{{@$from_pref2}}" name="from_pref2">
  <div class="form-item form-item__birthPlace form-item__select">
    <span>出生地</span>
    <div class="form-area">
      <div>
        <select name="input-from_pref">
          @foreach($prfile_area as $key => $vale)
          <option value="{{$key}}" @if(@$value['from_pref2'] == $key)selected="selected" @endif>{{$vale}}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  @endif




  @if ($param == 'email')
  <div class="form-item form-item__nickName">
    <span>メールアドレス</span>
    <div><input type="text" name="email" value="" placehold="例）macomo@mamauranai.co.jp" /></div>
  </div>
  @endif






@endforeach

