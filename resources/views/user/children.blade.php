@extends('layout.app.master')
@section('content')

<h1 class="title-second__main">子どものプロフィール追加・確認・変更</h1>


<div class="form-main">
<div class="form-check__massage">まだプロフィールが登録されていません。</div>
  <h2 class="title-second__sub">子供の情報</h2>
  <dl>

    <dt class="form-title" style="display: flex;">
      <div style="width: 80px;"><img src="https://placehold.jp/50/e0e0e0/e88888/100x100.png?text=%E3%81%8B" alt=""></div>
      <div style="flex: 1;"><span>かりんちゃん</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">
        <form action="#">

          <div class="form-item__id">
            <input type="text" value="" name="userid"></div>

          <div style="width: 80px;margin: auto;">
            <input type="radio" name="form-img" />
            <input type="radio" name="form-img" />
            <input type="radio" name="form-img" /></div><br><br>

          <div class="form-item form-item__nickName">
            <span>ニックネーム</span><br>
            <input type="text" name="nickname" value="" /></div><br><br>

          <div class="form-item form-item__gender">
            <span>性別</span>
            <label>女の子
            <input type="radio" class="form-gender__f" name="gender" value="f" /></label>
            <label>男の子
            <input type="radio" class="form-gender__m" name="gender" value="m" checked="checked" /></label></div><br><br>

          <div class="form-item form-item__birthOrder">
            <span>生まれ順</span><br>
            <select>
              <option value="1">てっぺん</option>
              <option value="2" selected="selected">の次</option>
              <option value="3">の次の次</option>
              <option value="4">下から２番目</option>
              <option value="5">一番下</option>
            </select></div><br><br>

          <div class="form-item form-item__birth">
            <span>生年月日</span><br>
            <select class="form-birthDay__year">
              <option value="">--</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
              <option value="2013">2013</option>
              <option value="2012">2012</option>
              <option value="2011">2011</option>
              <option value="2010">2010</option>
              <option value="2009">2009</option>
              <option value="2008">2008</option>
              <option value="2007">2007</option>
              <option value="2006">2006</option>
              <option value="2005">2005</option>
              <option value="2004">2004</option>
              <option value="2003">2003</option>
              <option value="2002">2002</option>
              <option value="2001">2001</option>
              <option value="2000">2000</option>
              <option value="1999">1999</option>
              <option value="1998">1998</option>
              <option value="1997">1997</option>
              <option value="1996">1996</option>
              <option value="1995">1995</option>
              <option value="1994">1994</option>
              <option value="1993">1993</option>
              <option value="1992">1992</option>
              <option value="1991">1991</option>
              <option value="1990">1990</option>
              <option value="1989">1989</option>
              <option value="1988">1988</option>
              <option value="1987">1987</option>
              <option value="1986">1986</option>
              <option value="1985">1985</option>
              <option value="1984">1984</option>
              <option value="1983">1983</option>
              <option value="1982">1982</option>
              <option value="1981">1981</option>
              <option value="1980">1980</option>
              <option value="1979" selected="selected">1979</option>
              <option value="1978">1978</option>
              <option value="1977">1977</option>
              <option value="1976">1976</option>
              <option value="1975">1975</option>
              <option value="1974">1974</option>
              <option value="1973">1973</option>
              <option value="1972">1972</option>
              <option value="1971">1971</option>
              <option value="1970">1970</option>
              <option value="1969">1969</option>
              <option value="1968">1968</option>
              <option value="1967">1967</option>
              <option value="1966">1966</option>
              <option value="1965">1965</option>
              <option value="1964">1964</option>
              <option value="1963">1963</option>
              <option value="1962">1962</option>
              <option value="1961">1961</option>
              <option value="1960">1960</option>
              <option value="1959">1959</option>
              <option value="1958">1958</option>
              <option value="1957">1957</option>
              <option value="1956">1956</option>
              <option value="1955">1955</option>
              <option value="1954">1954</option>
              <option value="1953">1953</option>
              <option value="1952">1952</option>
              <option value="1951">1951</option>
              <option value="1950">1950</option>
              <option value="1949">1949</option>
              <option value="1948">1948</option>
              <option value="1947">1947</option>
              <option value="1946">1946</option>
              <option value="1945">1945</option>
              <option value="1944">1944</option>
              <option value="1943">1943</option>
              <option value="1942">1942</option>
              <option value="1941">1941</option>
              <option value="1940">1940</option>
            </select>年
              
            <select class="form-birthDay__month" >
              <option value="">--</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected="selected">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>月

            <select  class="form-birthDay__day" >
              <option value="">--</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28" selected="selected">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>日
            <br><br>

          <div class="form-item form-item__birthTime">
            <span>出生時間</span><br>
            <select class="form-birthTime__hour" >
              <option value="-1" selected="selected">不明</option>
              <option value="0">00</option>
              <option value="1">01</option>
              <option value="2">02</option>
              <option value="3">03</option>
              <option value="4">04</option>
              <option value="5">05</option>
              <option value="6">06</option>
              <option value="7">07</option>
              <option value="8">08</option>
              <option value="9">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
            </select>時

            <select class="form-birthTime__minute" >
              <option value="-1" selected="selected">不明</option>
              <option value="0">01</option>
              <option value="1">01</option>
              <option value="2">02</option>
              <option value="3">03</option>
              <option value="4">04</option>
              <option value="5">05</option>
              <option value="6">06</option>
              <option value="7">07</option>
              <option value="8">08</option>
              <option value="9">09</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
              <option value="32">32</option>
              <option value="33">33</option>
              <option value="34">34</option>
              <option value="35">35</option>
              <option value="36">36</option>
              <option value="37">37</option>
              <option value="38">38</option>
              <option value="39">39</option>
              <option value="40">40</option>
              <option value="41">41</option>
              <option value="42">42</option>
              <option value="43">43</option>
              <option value="44">44</option>
              <option value="45">45</option>
              <option value="46">46</option>
              <option value="47">47</option>
              <option value="48">48</option>
              <option value="49">49</option>
              <option value="50">50</option>
              <option value="51">51</option>
              <option value="52">52</option>
              <option value="53">53</option>
              <option value="54">54</option>
              <option value="55">55</option>
              <option value="56">56</option>
              <option value="57">57</option>
              <option value="58">58</option>
              <option value="59">59</option>
            </select>分
          </div><br><br>

          <div class="form-item form-item__birthPlace">
            <span>出生地</span>
            <select>
              <option value="614">北海道</option>
              <option value="611">青森県</option>
              <option value="608">岩手県</option>
              <option value="606">秋田県</option>
              <option value="605">山形県</option>
              <option value="602">宮城県</option>
              <option value="600">福島県</option>

              <option value="524">茨城県</option>
              <option value="520">栃木県</option>
              <option value="518">群馬県</option>
              <option value="517">埼玉県</option>
              <option value="511">千葉県</option>
              <option value="507" selected="selected">東京都</option>
              <option value="503">神奈川県</option>

              <option value="415">山梨県</option>
              <option value="414">新潟県</option>
              <option value="412">長野県</option>
              <option value="410">富山県</option>
              <option value="408">石川県</option>
              <option value="407">福井県</option>
              <option value="404">静岡県</option>
              <option value="402">愛知県</option>
              <option value="400">岐阜県</option>

              <option value="310">京都府</option>
              <option value="308">奈良県</option>
              <option value="306">和歌山県</option>
              <option value="305">三重県</option>
              <option value="304">滋賀県</option>
              <option value="302">大阪府</option>
              <option value="300">兵庫県</option>

              <option value="210">岡山県</option>
              <option value="209">鳥取県</option>
              <option value="208">広島県</option>
              <option value="207">島根県</option>
              <option value="205">山口県</option>
              <option value="204">香川県</option>
              <option value="203">徳島県</option>
              <option value="201">愛媛県</option>
              <option value="200">高知県</option>

              <option value="114">福岡県</option>
              <option value="113">佐賀県</option>
              <option value="112">長崎県</option>
              <option value="110">大分県</option>
              <option value="107">熊本県</option>
              <option value="106">宮崎県</option>
              <option value="104">鹿児島県</option>
              <option value="102">沖縄県</option>
              <option value="000">その他</option>

            </select></div><br><br>

        </form>

        <div>
          <button id="js-form__checkBtn" type="button">確認する</button>
          <button type="button">登録情報を削除する</button>
        </div>

      </div>
    </dd>

    <dt class="form-title" style="display: flex;">
      <div style="width: 80px;"><img src="https://placehold.jp/50/e0e0e0/e88888/100x100.png?text=%E3%81%8B" alt=""></div>
      <div style="flex: 1;"><span>かりんちゃん</span></div>
    </dt>
    <dd class="form-content">
      <div class="mypage-form">
        <form action="#">
          <div style="width: 80px;margin: auto;">
          <input type="radio" name="form-img" /><input type="radio" name="form-img" id="form-img" /><input type="radio" name="form-img" id="form-img" /></div><br><br>

          <div class="form-item form-item__nickName">
            <span>ニックネーム</span><br>
            <input type="text" name="nickname" value="" /></div><br><br>

          <div class="form-item form-item__gender">
            <span>性別</span>
            <label>女の子
            <input type="radio" class="form-gender__f" name="gender" /></label>
            <label>男の子
            <input type="radio" class="form-gender__m" name="gender" checked="checked" /></label></div><br><br>

          <div class="form-item form-item__birthOrder">
            <span>生まれ順</span><br>
            <select>
              <option value="1">てっぺん</option>
              <option value="2" selected="selected">の次</option>
              <option value="3">の次の次</option>
              <option value="4">下から２番目</option>
              <option value="5">一番下</option>
            </select></div><br><br>

          <div class="form-item form-item__birth">
            <span>生年月日</span><br>
            <select class="form-birthDay__year">
              <option value="">--</option>
              <option value="2018">2018</option>
              <option value="2017">2017</option>
              <option value="2016">2016</option>
              <option value="2015">2015</option>
              <option value="2014">2014</option>
              <option value="2013">2013</option>
              <option value="2012">2012</option>
              <option value="2011">2011</option>
              <option value="2010">2010</option>
              <option value="2009">2009</option>
              <option value="2008">2008</option>
              <option value="2007">2007</option>
              <option value="2006">2006</option>
              <option value="2005">2005</option>
              <option value="2004">2004</option>
              <option value="2003">2003</option>
              <option value="2002">2002</option>
              <option value="2001">2001</option>
              <option value="2000">2000</option>
              <option value="1999">1999</option>
              <option value="1998">1998</option>
              <option value="1997">1997</option>
              <option value="1996">1996</option>
              <option value="1995">1995</option>
              <option value="1994">1994</option>
              <option value="1993">1993</option>
              <option value="1992">1992</option>
              <option value="1991">1991</option>
              <option value="1990">1990</option>
              <option value="1989">1989</option>
              <option value="1988">1988</option>
              <option value="1987">1987</option>
              <option value="1986">1986</option>
              <option value="1985">1985</option>
              <option value="1984">1984</option>
              <option value="1983">1983</option>
              <option value="1982">1982</option>
              <option value="1981">1981</option>
              <option value="1980">1980</option>
              <option value="1979" selected="selected">1979</option>
              <option value="1978">1978</option>
              <option value="1977">1977</option>
              <option value="1976">1976</option>
              <option value="1975">1975</option>
              <option value="1974">1974</option>
              <option value="1973">1973</option>
              <option value="1972">1972</option>
              <option value="1971">1971</option>
              <option value="1970">1970</option>
              <option value="1969">1969</option>
              <option value="1968">1968</option>
              <option value="1967">1967</option>
              <option value="1966">1966</option>
              <option value="1965">1965</option>
              <option value="1964">1964</option>
              <option value="1963">1963</option>
              <option value="1962">1962</option>
              <option value="1961">1961</option>
              <option value="1960">1960</option>
              <option value="1959">1959</option>
              <option value="1958">1958</option>
              <option value="1957">1957</option>
              <option value="1956">1956</option>
              <option value="1955">1955</option>
              <option value="1954">1954</option>
              <option value="1953">1953</option>
              <option value="1952">1952</option>
              <option value="1951">1951</option>
              <option value="1950">1950</option>
              <option value="1949">1949</option>
              <option value="1948">1948</option>
              <option value="1947">1947</option>
              <option value="1946">1946</option>
              <option value="1945">1945</option>
              <option value="1944">1944</option>
              <option value="1943">1943</option>
              <option value="1942">1942</option>
              <option value="1941">1941</option>
              <option value="1940">1940</option>
            </select>
              
            <select class="form-birthDay__month" >
              <option value="">--</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3" selected="selected">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
            </select>

            <select  class="form-birthDay__day" >
              <option value="">--</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
              <option value="11">11</option>
              <option value="12">12</option>
              <option value="13">13</option>
              <option value="14">14</option>
              <option value="15">15</option>
              <option value="16">16</option>
              <option value="17">17</option>
              <option value="18">18</option>
              <option value="19">19</option>
              <option value="20">20</option>
              <option value="21">21</option>
              <option value="22">22</option>
              <option value="23">23</option>
              <option value="24">24</option>
              <option value="25">25</option>
              <option value="26">26</option>
              <option value="27">27</option>
              <option value="28" selected="selected">28</option>
              <option value="29">29</option>
              <option value="30">30</option>
              <option value="31">31</option>
            </select>
            <br><br>

          <div class="form-item form-item__birthTime">
            <span>出生時間</span>
            <input type="text" class="form-birthTime__hour" value="13" />時
            <input type="text" class="form-birthTime__minute" value="00" />分</div><br><br>

          <div class="form-item form-item__birthPlace">
            <span>出生地</span>
            <select>
              <option value="614">北海道</option>
              <option value="611">青森県</option>
              <option value="608">岩手県</option>
              <option value="606">秋田県</option>
              <option value="605">山形県</option>
              <option value="602">宮城県</option>
              <option value="600">福島県</option>

              <option value="524">茨城県</option>
              <option value="520">栃木県</option>
              <option value="518">群馬県</option>
              <option value="517">埼玉県</option>
              <option value="511">千葉県</option>
              <option value="507" selected="selected">東京都</option>
              <option value="503">神奈川県</option>

              <option value="415">山梨県</option>
              <option value="414">新潟県</option>
              <option value="412">長野県</option>
              <option value="410">富山県</option>
              <option value="408">石川県</option>
              <option value="407">福井県</option>
              <option value="404">静岡県</option>
              <option value="402">愛知県</option>
              <option value="400">岐阜県</option>

              <option value="310">京都府</option>
              <option value="308">奈良県</option>
              <option value="306">和歌山県</option>
              <option value="305">三重県</option>
              <option value="304">滋賀県</option>
              <option value="302">大阪府</option>
              <option value="300">兵庫県</option>

              <option value="210">岡山県</option>
              <option value="209">鳥取県</option>
              <option value="208">広島県</option>
              <option value="207">島根県</option>
              <option value="205">山口県</option>
              <option value="204">香川県</option>
              <option value="203">徳島県</option>
              <option value="201">愛媛県</option>
              <option value="200">高知県</option>

              <option value="114">福岡県</option>
              <option value="113">佐賀県</option>
              <option value="112">長崎県</option>
              <option value="110">大分県</option>
              <option value="107">熊本県</option>
              <option value="106">宮崎県</option>
              <option value="104">鹿児島県</option>
              <option value="102">沖縄県</option>
              <option value="000">その他</option>

            </select></div><br><br>

        </form>

        <div>
          <button id="js-form__checkBtn" type="button">確認する</button>
          <button type="button">登録情報を削除する</button>
        </div>

      </div>
    </dd>



  </dl>
</div>

<button id="ajax">ajax</button>

<div id="json"></div><br><br><br><br><br><br><br>
<script type="text/javascript">

$(function(){
  $('.form-main dl dt').on('click',function(){
    $('.form-main dl dd').removeClass('js-form__open');
    $(this).next().addClass('js-form__open');

    $.ajax({
      url:'/api/children/list',
      type:'GET',
      dataType: 'json',
      success: function(json){

        // id
        $('dl:nth-of-type(1) form input[name=userid]').val(json[0].id);

        //　ニックネーム
        $('dl:nth-of-type(1) form input[name=nickname]').val(json[0].nickname);
        $('#json').append(json[0].nickname + '　');
        var jsonId = json[0].id;

        // 性別
        if ( json[0].gender === 'f' ) {
          $('dl:nth-of-type(1) form input.form-gender__f').prop('checked',true);
        } else {
          $('dl:nth-of-type(1) form input.form-gender__m').prop('checked',true);
        }
        $('#json').append(json[0].gender + '　');

        //　生まれ順
        switch ( json[0].birthorder ){
          case '1':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(1)').prop('selected',true);
            break;
          case '2':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(2)').prop('selected',true);
            break;
          case '3':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(3)').prop('selected',true);
            break;
          case '4':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(4)').prop('selected',true);
            break;
          case '5':
            $('dl:nth-of-type(1) form .form-item__birthOrder option:nth-of-type(5)').prop('selected',true);
            break;
          default:
            console.log("動いてないよー！");
            break;
        }
        $('#json').append(json[0].birthorder + '　');

        // 誕生日
        var birthDayY = Number( json[0].birthday.slice(0, 4) ),
            birthDayM = Number( json[0].birthday.slice(5, 7) ),
            birthDayD = Number( json[0].birthday.slice(8, 10) );

        for(var i = 0;i <= $('.form-birthDay__year option').length; i++) {
          var dYval = $('.form-birthDay__year option:nth-of-type('+i+')');
          if( birthDayY == $(dYval).val() ) {
            $(dYval).prop('selected',true);
          }
        }
        for(var i = 0;i <= $('.form-birthDay__month option').length; i++) {
          var dMval = $('.form-birthDay__month option:nth-of-type('+i+')');
          if( birthDayM == $(dMval).val() ) {
            $(dMval).prop('selected',true);
          }
        }
        for(var i = 0;i <= $('.form-birthDay__day option').length; i++) {
          var dDval = $('.form-birthDay__day option:nth-of-type('+i+')');
          if( birthDayD == $(dDval).val() ) {
            $(dDval).prop('selected',true);
          }
        }
        $('#json').append(json[0].birthday + '　');

        //　出生時間
        var birthTimeH = Number( json[0].birthtime.slice(0, 2) ),
            birthTimeM = Number( json[0].birthtime.slice(3, 5) );
            console.log(birthTimeH, birthTimeM);
        if( $('dl:nth-of-type(1) form input[name=birthtime_unknown]') == 1) {
          $('.form-birthTime__hour option:nth-of-type(1)').prop('selected',true);
          $('.form-birthTime__minute option:nth-of-type(1)').prop('selected',true);
        } else {
          for(var i = 0;i <= $('.form-birthTime__hour option').length; i++) {
            var tHval = $('.form-birthTime__hour option:nth-of-type('+i+')');
            if( birthTimeH == $(tHval).val() ) {
              $(tHval).prop('selected',true);
            }
          }

          for(var i = 0;i <= $('.form-birthTime__minute option').length; i++) {
            var tMval = $('.form-birthTime__minute option:nth-of-type('+i+')');
            if( birthTimeM == $(tMval).val() ) {
              $(tMval).prop('selected',true);
            }
          }
        }
        $('#json').append(json[0].birthtime_unknown + '　');

        //　出生地
        for(var i = 0;i <= $('.form-item__birthPlace option').length; i++) {
          var place = $('.form-item__birthPlace option:nth-of-type('+i+')');
          if( json[0].from_pref == $(place).val() ) {
            $(place).prop('selected',true);
          }
        }
        $('#json').append(json[0].from_pref + '　');

      }
    });
  });
});


$('#js-form__checkBtn').on('click',function(){
  var JSONdata = {
    "id": $('input[name=userid]').val(),
    "nickname": $('dl:nth-of-type(1) form input[name=nickname]').val(),
    "birthorder": $('dl:nth-of-type(1) form input[name=nickname]').val(),
    "nickname": $('dl:nth-of-type(1) form input[name=nickname]').val(),
    "nickname": $('dl:nth-of-type(1) form input[name=nickname]').val(),
    "nickname": $('dl:nth-of-type(1) form input[name=nickname]').val(),
  }
  console.log(JSONdata);
  $.ajax({
    url:'/api/children/edit',
    data : JSON.stringify(JSONdata),
    type:'POST',
    contentType: 'application/json',
    dataType: 'json',
    success: function(json) {
      console.log('success');
    }
  })
});
</script>
<p>
接続: get<br>
入力: users_id (ユーザーID)<br>
URL: <br>
http://macomo.ajapa.jp/api/children/list<br>
https://macomo.me/api/children/list<br>

※環境で当然URL変化します<br>
出力:色々。下記を実行して確認してください。形式はjsonです<br>
http://macomo.ajapa.jp/api/children/list<br>


・子供作成<br>
URL: /api/children/insert<br>
(開発:http://macomo.ajapa.jp/api/children/insert 本番:https://macomo.me/api/children/insert)<br>
接続: POST<br>
入力: <br>
子供ID         id (idだけ必須、他任意)<br>
アイコン画像    icon_imgfile<br>
アイコン背景色    icon_backcolor<br>
入力パラメータ(ニックネーム)    nickname<br>
入力パラメータ(苗字)    last_name<br>
入力パラメータ(苗字かな)    last_name_kana<br>
入力パラメータ(名前)    first_name<br>
入力パラメータ(名前かな)    first_name_kana<br>
入力パラメータ(生年月日)    birthday<br>
入力パラメータ(出生時間)    birthtime<br>
入力パラメータ(出生時間不明フラグ)    birthtime_unknown<br>
入力パラメータ(生まれ順)    birthorder<br>
入力パラメータ(血液型)    blood<br>
入力パラメータ(性別)    gender<br>
入力パラメータ(出生地)    from_pref<br>
<br>

出力: 'response' => 'OK'<br><br><br><br>

・子供編集<br>
/api/children/edit<br>
接続: POST<br>
入力:<br>
子供ID         id (idだけ必須、他任意)<br>
アイコン画像    icon_imgfile<br>
アイコン背景色    icon_backcolor<br>
入力パラメータ(ニックネーム)    nickname<br>
入力パラメータ(苗字)    last_name<br>
入力パラメータ(苗字かな)    last_name_kana<br>
入力パラメータ(名前)    first_name<br>
入力パラメータ(名前かな)    first_name_kana<br>
入力パラメータ(生年月日)    birthday<br>
入力パラメータ(出生時間)    birthtime<br>
入力パラメータ(出生時間不明フラグ)    birthtime_unknown<br>
入力パラメータ(生まれ順)    birthorder<br>
入力パラメータ(血液型)    blood<br>
入力パラメータ(性別)    gender<br>
入力パラメータ(出生地)    from_pref<br>
<br>
出力: 'response' => 'OK'<br><br><br><br>

・子供削除<br>
/api/children/delete<br>
接続: POST<br>
入力: id (子供ID 必須)<br>
出力: 'response' => 'OK'<br>
</p>




@endsection