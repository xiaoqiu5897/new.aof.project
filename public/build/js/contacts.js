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
/******/ 	return __webpack_require__(__webpack_require__.s = 12);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/contacts.js":
/*!*****************************************!*\
  !*** ./resources/assets/js/contacts.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  $(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });
  $(document).on("submit", "#frm-create", function (e) {
    e.preventDefault();
    var formData = $('#frm-create').serialize();
    $.ajax({
      url: app_url + "contact-store",
      type: 'POST',
      data: {
        'data': formData
      },
      success: function success(res) {
        if (res.err != true) {
          toastr.success(res.msg);
          setTimeout(function () {
            window.location.href = app_url + "contacts";
          }, 2000);
        }
      }
    });
  });
  $(document).on("submit", "#frm-edit", function (e) {
    e.preventDefault();
    var formData = $('#frm-edit').serialize();
    $.ajax({
      url: app_url + "contact-update",
      type: 'POST',
      data: {
        'data': formData
      },
      success: function success(res) {
        // console.log(res);
        if (res.err != true) {
          toastr.success(res.msg);
          setTimeout(function () {
            window.location.href = app_url + "contacts";
          }, 2000);
        }
      }
    });
  });
  $(document).on("click", "#btn-delete", function (e) {
    e.preventDefault();
    var id = $(this).attr("value");
    swal({
      title: 'Bạn có muốn xóa?',
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#dd6b55',
      cancelButtonColor: '#999',
      confirmButtonText: 'Có',
      cancelButtonText: 'Không',
      closeOnConfirm: true
    }, function () {
      $.ajax({
        url: app_url + "delete-update",
        type: 'POST',
        data: {
          id: id
        },
        success: function success(res) {
          if (res.err != true) {
            toastr.success(res.msg);
            setTimeout(function () {
              window.location.href = app_url + "contacts";
            }, 2000);
          }
        }
      });
    });
  });
});

/***/ }),

/***/ 12:
/*!***********************************************!*\
  !*** multi ./resources/assets/js/contacts.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\new.aof.project\resources\assets\js\contacts.js */"./resources/assets/js/contacts.js");


/***/ })

/******/ });