
{{ csrf_field() }}

@foreach($params as $param)



  @if ($param == 'id')
  <div class="form-item form-item__id">
    <input type="text" value="" name="userid">
  </div>
  @endif




  @if ($param == 'img')
  <input type="text" value="" name="imgfile">
  <div class="form-item__imgFix js-child_01">

  </div>
  <div class="form-item__img">
    <div class="js-active ">
      <label>
        <img src="/images/icon_kids/baby-boy.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" checked="checked" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/baby-girl.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/boy.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/kids-boy.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/kids-girl.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" />
      </label>
    </div>
    <div>
      <label>
        <img src="/images/icon_kids/kids.png" alt="" />
        <img src="https://placehold.jp/f3f3f3/cccccc/100x100.png" alt="">
        <input type="radio" name="form-img" />
      </label>
    </div>
    <button type="button" class="js-img__submit">決定</button>
  </div><br><br>
  @endif


  @if ($param == 'nickname')
  <div class="form-item form-item__nickName">
    <span>ニックネーム</span><br>
    <input type="text" name="nickname" value="" />
  </div><br><br>
  @endif



  @if ($param == 'name')
  <div class="form-item form-item__nickName">
    <span>姓名（漢字）</span><br>
    <input type="text" name="last_name" value="">
    <input type="text" name="first_name" value="">
  </div><br><br>

  <div class="form-item form-item__nickName">
    <span>姓名（かな）</span><br>
    <input type="text" name="last_name_kana" value="">
    <input type="text" name="first_name_kana" value="">
  </div><br><br>
  @endif



  @if ($param == 'gender')
  <div class="form-item form-item__gender">
    <span>性別</span><br>
    <label>女の子
    <input type="radio" class="form-gender__f" name="gender" value="f" /></label>
    <label>男の子
    <input type="radio" class="form-gender__m" name="gender" value="m" checked="checked" /></label>
  </div><br><br>
  @endif




  @if ($param == 'blood')
  <div class="form-item form-item__gender">
    <span>血液型</span><br>
    <select name="blood">
      <option value="0" checked="checked">不明</option>
      <option value="1">A</option>
      <option value="2">B</option>
      <option value="3">O</option>
      <option value="4">AB</option>
    </select>
  </div><br><br>
  @endif




  @if ($param == 'birthOrder')
  <div class="form-item form-item__birthOrder">
    <span>生まれ順</span><br>
    <select name="birthorder">
      <option value="1">一番上</option>
      <option value="2" selected="selected">真ん中</option>
      <option value="3">末っ子</option>
      <option value="4">一人っ子</option>
      <!-- <option value="5">一番下</option> -->
    </select>
  </div><br><br>
  @endif




  @if ($param == 'birth')
  <div class="form-item form-item__birth">
    <span>生年月日</span><br>
    <select class="form-birthDay__year" name="birthday_y">
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
      
    <select class="form-birthDay__month" name="birthday_m">
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

    <select  class="form-birthDay__day" name="birthday_d">
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
  </div><br><br>
  @endif




  @if ($param == 'birthTime')
  <div class="form-item form-item__birthTime">
    <span>出生時間</span><br>
    <select class="form-birthTime__hour">
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

    <select class="form-birthTime__minute">
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
  <input type="text" name="birthtime" value="9999">
  @endif




  @if ($param == 'birthPlace')
  <div class="form-item form-item__birthPlace">
    <span>出生地</span>
    <select name="from_pref">
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

    </select>
  </div><br><br>
  @endif






























@if ($param == 'nickname')
  <div class="form-item form-item__nickName">
    <span>ニックネーム</span><br>
    <input type="text" name="nickname" value="" />
  </div><br><br>
  @endif



  @if ($param == 'name')
  <div class="form-item form-item__nickName">
    <span>姓名（漢字）</span><br>
    <input type="text" name="last_name" value="">
    <input type="text" name="first_name" value="">
  </div><br><br>

  <div class="form-item form-item__nickName">
    <span>姓名（かな）</span><br>
    <input type="text" name="last_name_kana" value="">
    <input type="text" name="first_name_kana" value="">
  </div><br><br>
  @endif



  @if ($param == 'gender')
  <div class="form-item form-item__gender">
    <span>性別</span><br>
    <label>女の子
    <input type="radio" class="form-gender__f" name="gender" value="f" /></label>
    <label>男の子
    <input type="radio" class="form-gender__m" name="gender" value="m" checked="checked" /></label>
  </div><br><br>
  @endif




  @if ($param == 'blood')
  <div class="form-item form-item__gender">
    <span>血液型</span><br>
    <select name="blood">
      <option value="0" checked="checked">不明</option>
      <option value="1">A</option>
      <option value="2">B</option>
      <option value="3">O</option>
      <option value="4">AB</option>
    </select>
  </div><br><br>
  @endif




  @if ($param == 'birthOrder')
  <div class="form-item form-item__birthOrder">
    <span>生まれ順</span><br>
    <select name="birthorder">
      <option value="1">一番上</option>
      <option value="2" selected="selected">真ん中</option>
      <option value="3">末っ子</option>
      <option value="4">一人っ子</option>
      <!-- <option value="5">一番下</option> -->
    </select>
  </div><br><br>
  @endif




  @if ($param == 'birth')
  <div class="form-item form-item__birth">
    <span>生年月日</span><br>
    <select class="form-birthDay__year" name="birthday_y">
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
      
    <select class="form-birthDay__month" name="birthday_m">
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

    <select  class="form-birthDay__day" name="birthday_d">
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
  </div><br><br>
  @endif




  @if ($param == 'birthTime')
  <div class="form-item form-item__birthTime">
    <span>出生時間</span><br>
    <select class="form-birthTime__hour">
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

    <select class="form-birthTime__minute">
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
  <input type="text" name="birthtime" value="9999">
  @endif




  @if ($param == 'birthPlace')
  <div class="form-item form-item__birthPlace">
    <span>出生地</span>
    <select name="from_pref">
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

    </select>
  </div><br><br>
  @endif

  
@endforeach

