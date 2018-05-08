/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, {
/******/ 				configurable: false,
/******/ 				enumerable: true,
/******/ 				get: getter
/******/ 			});
/******/ 		}
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ([
/* 0 */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(1);
module.exports = __webpack_require__(2);


/***/ }),
/* 1 */
/***/ (function(module, exports) {

//////
///// gender instance
/////////////////////
function gender(e) {
  var gender = e + 'input[name=gender]',
      genderI = e + 'input[name=input-gender]',
      genderC = e + 'input[name=input-gender]:checked',
      genderF = e + 'input.form-gender__f',
      genderM = e + 'input.form-gender__m';
  // dtクリックしたinput genderの内容を切り替え
  if ($(gender).val() === 'f') {
    $(genderF).prop('checked', true);
  } else {
    $(genderM).prop('checked', true);
  }

  // 男女のラジオ切り替えでinput gender　更新
  $(genderI).on('change', function () {
    if ($(genderC).val() === 'f') {
      $(gender).val('f');
    } else {
      $(gender).val('m');
    }
  });
}

//////
///// blood instance
/////////////////////
function blood(e) {

  var blood = e + 'input[name=blood]',
      bloodI = e + 'select[name=input-blood]',
      bloodO = e + 'select[name=input-blood] option';

  // dtクリックしたinput bloodの内容を切り替え
  for (var i = 0; i < $(bloodO).length; i++) {
    if ($(blood).val() == i) {
      var bloodN = e + 'select[name=input-blood] option:nth-of-type(' + Number(i + 1) + ')';
      $(bloodN).prop('selected', true);
    }
  }

  // 血液型のselect切り替えでinput blood　更新
  $(bloodI).on('change', function () {
    $(blood).val($(this).val());
  });
}

//////
///// birthOrder instance
/////////////////////
function birthOrder(e) {
  var birthOrder = e + 'input[name=birthorder]',
      birthOrderI = e + 'select[name=input-birthorder]',
      birthOrderO = e + 'select[name=input-birthorder] option';
  // dtクリックしたinput birthOrderの内容を切り替え
  for (var i = 0; i < $(birthOrderO).length; i++) {
    if ($(birthOrder).val() == i) {
      var birthOrderN = e + 'select[name=input-birthorder] option:nth-of-type(' + Number(i) + ')';
      $(birthOrderN).prop('selected', true);
    }
  }

  // 血液型のselect切り替えでinput birthOrder　更新
  $(birthOrderI).on('change', function () {
    $(birthOrder).val($(this).val());
  });
}

//////
///// birthday instance
/////////////////////
function birthDay(e) {
  var birthDay = e + 'input[name=birthday]',
      birthDayY = Number($(birthDay).val().slice(0, 4)),
      birthDayM = Number($(birthDay).val().slice(5, 7)),
      birthDayD = Number($(birthDay).val().slice(8, 10)),
      birthDayYO = e + '.form-birthDay__year option',
      birthDayMO = e + '.form-birthDay__month option',
      birthDayDO = e + '.form-birthDay__day option';

  for (var i = 0; i <= $(birthDayYO).length; i++) {
    var dYval = e + '.form-birthDay__year option:nth-of-type(' + i + ')';
    if (birthDayY == $(dYval).val()) {
      $(dYval).prop('selected', true);
    }
  }
  for (var i = 0; i <= $(birthDayMO).length; i++) {
    var dMval = e + '.form-birthDay__month option:nth-of-type(' + i + ')';
    if (birthDayM == $(dMval).val()) {
      $(dMval).prop('selected', true);
    }
  }
  for (var i = 0; i <= $(birthDayDO).length; i++) {
    var dDval = e + '.form-birthDay__day option:nth-of-type(' + i + ')';
    if (birthDayD == $(dDval).val()) {
      $(dDval).prop('selected', true);
    }
  }
}

//////
///// birthtime instance
/////////////////////
function birthTime(e) {
  var birthTime = e + 'input[name=birthtime]',
      birthTimeH = Number($(birthTime).val().slice(0, 2)),
      birthTimeM = Number($(birthTime).val().slice(3, 5)),
      birthTimeHS = e + 'select[name=input-birthtime_h]',
      birthTimeHO = e + 'select[name=input-birthtime_h] option',
      birthTimeMS = e + 'select[name=input-birthtime_m]',
      birthTimeMO = e + 'select[name=input-birthtime_m] option';

  for (var i = 0; i <= $(birthTimeHO).length; i++) {
    var tH = e + 'select[name=input-birthtime_h] option:nth-of-type(' + i + ')';
    if (birthTimeH == $(tH).val()) {
      $(tH).prop('selected', true);
    }
  }

  $(birthTimeHS).on('change', function () {
    var tHval = $(this).val(),
        tMval = $(birthTimeMS).val();
    if (tHval == -1) {
      $(birthTime).val('9999');
    } else if (tHval >= 0 && tHval < 10) {
      if (tMval == -1) {
        $(birthTime).val('0' + tHval + '00');
      } else if (tMval >= 0 && tMval < 10) {
        $(birthTime).val('0' + tHval + '0' + tMval);
      } else {
        $(birthTime).val('0' + tHval + tMval);
      }
    } else {
      if (tMval == -1) {
        $(birthTime).val(tHval + '00');
      } else if (tMval >= 0 && tMval < 10) {
        $(birthTime).val(tHval + '0' + tMval);
      } else {
        $(birthTime).val(tHval + tMval);
      }
    }
  });

  $(birthTimeMS).on('change', function () {
    var tMval = $(this).val(),
        tHval = $(birthTimeHS).val();
    if (tMval == -1) {
      if (tHval == -1) {
        $(birthTime).val('9999');
      } else if (tHval >= 0 && tHval < 10) {
        $(birthTime).val('0' + tHval + '00');
      } else {
        $(birthTime).val(tHval + '00');
      }
    } else if (tMval >= 0 && tMval < 10) {
      if (tHval == -1) {
        $(birthTime).val('9999');
      } else if (tHval >= 0 && tHval < 10) {
        $(birthTime).val('0' + tHval + '0' + tMval);
      } else {
        $(birthTime).val(tHval + '0' + tMval);
      }
    } else {
      if (tHval == -1) {
        $(birthTime).val('9999');
      } else if (tHval >= 0 && tHval < 10) {
        $(birthTime).val('0' + tHval + tMval);
      } else {
        $(birthTime).val(tHval + tMval);
      }
    }
  });
}

//////
///// from_pref instance
/////////////////////
function pref(e) {
  var pref = e + 'input[name=from_pref]',
      prefI = e + 'select[name=input-from_pref]',
      prefO = e + 'select[name=input-from_pref] option';

  for (var i = 0; i < $(prefO).length; i++) {
    var prefN = e + 'select[name=input-from_pref] option:nth-of-type(' + Number(i + 1) + ')';
    if ($(prefN).val() == $(pref).val()) {
      $(prefN).prop('selected', true);
    }
  }

  $(prefI).on('change', function () {
    $(pref).val($(this).val());
  });
}

//////
///// child_img instance
/////////////////////
function childImg(e) {
  var imgfile = e + 'input[name=icon_imgfile]',
      imgFix = e + '.form-item__imgFix',
      imgImg = e + '.form-item__img',
      imgTarget = e + '.form-item__img > div',
      imgSubmit = e + '.js-img__submit';

  $(imgFix).removeClass('js-child_01 js-child_02 js-child_03 js-child_04 js-child_05 js-child_06');
  $(imgFix).addClass('js-child_0' + $(imgfile).val());

  // clickしたら〜のイベントここから
  $(imgSubmit).on('click', function () {
    $(imgFix).css('display', 'block');
    $(imgImg).css('display', 'none');
  });
  $(imgFix).on('click', function () {
    $(imgFix).css('display', 'none');
    $(imgImg).css('display', 'flex');
  });

  $(imgTarget).on('click', function () {
    $(imgTarget).removeClass('js-active');
    $(this).addClass('js-active');
    $(imgfile).val($(e + '.form-item__img .js-active input').val());
    $(imgFix).removeClass('js-child_01 js-child_02 js-child_03 js-child_04 js-child_05 js-child_06');
    $(imgFix).addClass('js-child_0' + $(e + '.form-item__img .js-active input').val());
  });
}

/***/ }),
/* 2 */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ })
/******/ ]);