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
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
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
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/duplicate-classroom.js":
/*!****************************************************!*\
  !*** ./resources/assets/js/duplicate-classroom.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(document).ready(function () {
  var app_url = $('meta[name="website"]').attr('content');
  var today = new Date();
  var minDate = today.getFullYear() + '/' + (today.getMonth() + 1) + '/' + today.getDate();
  $('.datetimepicker').datetimepicker({
    format: "dd DD/MM/YYYY HH:mm",
    minDate: minDate,
    locale: 'vi',
    keepOpen: false
  });
  $('.duplicate-datepicker').datetimepicker({
    format: "dd DD/MM/YYYY",
    minDate: minDate,
    locale: 'vi',
    keepOpen: false
  });
  $('#duplicate_orientation_time').on('dp.change', function () {
    var minDate = $('#duplicate_orientation_time').data('DateTimePicker').viewDate()['_d'];
    minDate.setHours(0, 0, 0);
    $('#duplicate_first_unit').data('DateTimePicker').minDate(minDate);
    $('#duplicate_second_unit').data('DateTimePicker').minDate(minDate);
  });
  $('#duplicate_first_unit').on('dp.change', function () {
    var minDate = $('#duplicate_first_unit').data('DateTimePicker').viewDate()['_d'];
    minDate.setHours(0, 0, 0);
    $('#duplicate_second_unit').data('DateTimePicker').minDate(minDate);
  });

  window.duplicateClassroom = function (class_id) {
    $.ajax({
      type: 'GET',
      url: app_url + 'duplicate-classrooms/' + class_id,
      success: function success(res) {
        if (!res.error) {
          $('#units_count').text(res.units + ' buổi');
          $('#exercises_count').text(res.exercises + ' bài');
          $('#theories_count').text(res.theories + ' bài');
          $('.datetimepicker').data('DateTimePicker').clear();
          $('.duplicate-datepicker').data('DateTimePicker').clear();
          $('#duplicate-classroom-mdl').modal('show');
          $('#class_id').val(class_id);
        }
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  };

  $('#duplicate-frm').validate({
    onkeyup: false,
    rules: {
      duplicate_name: {
        required: true
      },
      duplicate_code: {
        required: true,
        remote: {
          url: app_url + 'duplicate-classrooms/check-exists-code',
          type: "post",
          data: {
            code: function code() {
              return $("#duplicate_code").val();
            }
          }
        }
      },
      duplicate_orientation_time: {
        required: true
      },
      duplicate_first_unit: {
        required: true
      },
      duplicate_second_unit: {
        required: true
      }
    },
    messages: {
      duplicate_name: {
        required: "Tên lớp mới không được bỏ trống"
      },
      duplicate_code: {
        required: 'Mã lớp không được bỏ trống"',
        remote: 'Mã lớp đã tồn tại'
      },
      duplicate_orientation_time: {
        required: 'Ngày khai giảng dự kiến không được bỏ trống"'
      },
      duplicate_first_unit: {
        required: 'Buổi học số 1 không được bỏ trống"'
      },
      duplicate_second_unit: {
        required: 'Buổi học số 2 không được bỏ trống'
      }
    }
  });
  $('#duplicate-btn').on('click', function () {
    var duplicate_orientation_time = formatDate($('#duplicate_orientation_time').data("DateTimePicker").viewDate()['_d']);
    var duplicate_first_unit = formatDate($('#duplicate_first_unit').data("DateTimePicker").viewDate()['_d']);
    var duplicate_second_unit = formatDate($('#duplicate_second_unit').data("DateTimePicker").viewDate()['_d']);

    if ($('#duplicate-frm').valid()) {
      $.ajax({
        type: 'POST',
        url: app_url + 'duplicate-classrooms/store',
        data: {
          'class_id': $('#class_id').val(),
          'class_name': $('#duplicate_name').val(),
          'code': $('#duplicate_code').val(),
          'orientation_time': duplicate_orientation_time,
          'first_unit': duplicate_first_unit,
          'second_unit': duplicate_second_unit
        },
        success: function success(res) {
          if (!res.error) {
            toastr.success(res.message);
            $('#duplicate-classroom-mdl').modal('hide');
            $('#duplicate-frm').trigger('reset');
            $('#class-table').DataTable().ajax.reload();
          } else if (res.error) {
            toastr.error(res.message);
          } else {
            toastr.warning(res.message);
          }
        },
        error: function error(xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
    }
  });

  window.formatDate = function (date) {
    var day = addZero(date.getDate());
    var month = addZero(date.getMonth() + 1);
    var year = addZero(date.getFullYear());
    var hours = addZero(date.getHours());
    var minutes = addZero(date.getMinutes());
    var seconds = addZero(date.getSeconds());
    return year + '-' + month + '-' + day + ' ' + hours + ':' + minutes + ':' + seconds;
  };

  window.addZero = function (time) {
    if (time < 10) {
      time = "0" + time;
    }

    return time;
  };
});

/***/ }),

/***/ 4:
/*!**********************************************************!*\
  !*** multi ./resources/assets/js/duplicate-classroom.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\new.aof.project\resources\assets\js\duplicate-classroom.js */"./resources/assets/js/duplicate-classroom.js");


/***/ })

/******/ });