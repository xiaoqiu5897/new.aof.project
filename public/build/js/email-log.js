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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/email-log.js":
/*!******************************************!*\
  !*** ./resources/assets/js/email-log.js ***!
  \******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  list_table = $('#list-table').DataTable({
    processing: true,
    serverSide: true,
    order: [],
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: app_url + "get-list-email",
    // deferRender: true,
    columns: [{
      data: 'DT_Row_Index',
      orderable: true,
      searchable: false
    }, {
      data: 'to',
      name: 'to'
    }, {
      data: 'subject',
      name: 'subject'
    }, {
      data: 'type',
      name: 'type',
      orderable: false,
      searchable: false
    }, {
      data: 'status',
      name: 'status',
      orderable: false,
      searchable: false
    }, {
      data: 'num_submissions',
      name: 'num_submissions'
    }, {
      data: 'updated_at',
      name: 'updated_at'
    }, {
      data: 'action',
      name: 'action',
      orderable: false,
      searchable: false
    }]
  });
  $(document).on('change', '.filter', function () {
    var type = $('#type_filter').val();
    var status = $('#status_filter').val();
    list_table = $('#list-table').dataTable().fnDestroy();
    list_table = $('#list-table').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: app_url + "get-list-email",
        data: {
          'status': status,
          'type': type
        }
      },
      order: [],
      pageLength: 30,
      lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
      deferRender: true,
      columns: [{
        data: 'DT_Row_Index',
        orderable: true,
        searchable: false
      }, {
        data: 'to',
        name: 'to'
      }, {
        data: 'subject',
        name: 'subject'
      }, {
        data: 'type',
        name: 'type',
        orderable: false,
        searchable: false
      }, {
        data: 'status',
        name: 'status',
        orderable: false,
        searchable: false
      }, {
        data: 'num_submissions',
        name: 'num_submissions'
      }, {
        data: 'updated_at',
        name: 'updated_at'
      }, {
        data: 'action',
        name: 'action',
        orderable: false,
        searchable: false
      }]
    });
  });
  $(document).on('click', '.btn-resend', function () {
    var id = $(this).data('id');
    $.ajax({
      url: app_url + 'send-email',
      type: 'POST',
      dataType: 'JSON',
      data: {
        id: id
      },
      success: function success(res) {
        if (!res.error) {
          toastr.success('Gửi thành công!');
          list_table.ajax.reload(null, false);
        }
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        toastr.error(xhr.responseJSON.message);
      }
    });
  });
  $(document).on('click', '.btn-view', function () {
    var id = $(this).data('id');
    $.ajax({
      url: app_url + 'view-email/' + id,
      type: 'GET',
      dataType: 'JSON',
      success: function success(res) {
        if (!res.error) {
          console.log(res.data.parameter.content);
          $('#view-email-modal').modal('show');
          $('#view-subject').text(res.data.subject);

          if (res.data.status == 0) {
            var status = 'gửi thành công';
          } else if (res.data.status == 1) {
            var status = 'gửi lỗi';
          } else {
            var status = 'chưa gửi';
          }

          $('#view-destination').html('<span style=" font-weight: bold;">To: </span>' + res.data.to + '<br><span style=" font-weight: bold;">Trạng thái</span>: ' + status + '&emsp; <span  style=" font-weight: bold;">Số lần gửi: </span>' + res.data.num_submissions);
          $('#view-parameter').html('<h3>Nội dung:</h3></br>' + res.data.parameter.content);
        }
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        toastr.error(xhr.responseJSON.message);
      }
    });
  });
  $(document).on('click', '#btn-truncate', function () {
    swal({
      title: "Bạn có chắc muốn xóa?",
      // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      cancelButtonText: "Không",
      confirmButtonText: "Có" // closeOnConfirm: false,

    }, function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: app_url + 'truncate-email',
          type: 'delete',
          dataType: 'JSON',
          success: function success(res) {
            if (!res.error) {
              toastr.success('Đã xoá toàn bộ email log!');
              list_table.ajax.reload(null, false);
            }
          },
          error: function error(xhr, ajaxOptions, thrownError) {
            toastr.error(xhr.responseJSON.message);
          }
        });
      }
    });
  });
  $(document).on('click', '#btn-truncate-30-day', function () {
    swal({
      title: "Bạn có chắc muốn xóa?",
      // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      cancelButtonText: "Không",
      confirmButtonText: "Có" // closeOnConfirm: false,

    }, function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          url: app_url + 'truncate-30-day-email',
          type: 'delete',
          dataType: 'JSON',
          success: function success(res) {
            if (!res.error) {
              if (res.leng == 0) {
                toastr.warning('Không có email nào cũ quá 30 ngày');
              } else {
                toastr.success('Đã xoá ' + res.leng + ' email log đã tạo quá 30 ngày!');
                list_table.ajax.reload(null, false);
              } // console.log(res);

            }
          },
          error: function error(xhr, ajaxOptions, thrownError) {
            toastr.error(xhr.responseJSON.message);
          }
        });
      }
    });
  });
});

/***/ }),

/***/ 5:
/*!************************************************!*\
  !*** multi ./resources/assets/js/email-log.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\new.aof.project\resources\assets\js\email-log.js */"./resources/assets/js/email-log.js");


/***/ })

/******/ });