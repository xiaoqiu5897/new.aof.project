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
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/social-post.js":
/*!********************************************!*\
  !*** ./resources/assets/js/social-post.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports) {

var data = $('#social-post-facebook').DataTable({
  processing: true,
  serverSide: true,
  ajax: app_url + 'json/social-post-facebook',
  pageLength: 30,
  lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
  columns: [{
    data: 'DT_Row_Index',
    orderable: false,
    searchable: false,
    "class": 'dt-center'
  }, {
    data: 'title',
    name: 'title'
  }, {
    data: 'link',
    name: 'link'
  }, {
    data: 'content',
    name: 'content',
    "class": 'td-content'
  }, {
    data: 'action',
    name: 'action'
  }]
});
var data_youTube = $('#social-post-youtube').DataTable({
  processing: true,
  serverSide: true,
  ajax: app_url + 'json/social-post-youtube',
  pageLength: 30,
  lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
  columns: [{
    data: 'DT_Row_Index',
    orderable: false,
    searchable: false,
    "class": 'dt-center'
  }, {
    data: 'title',
    name: 'title'
  }, {
    data: 'embed',
    name: 'embed',
    "class": 'td-embed'
  }, {
    data: 'link',
    name: 'link'
  }, {
    data: 'content',
    name: 'content',
    "class": 'td-yb-content'
  }, {
    data: 'action',
    name: 'action'
  }]
});
$(document).on('click', '.btn-danger', function () {
  // alert('ok')
  var id = $(this).data("id");
  swal({
    title: "Xóa trang web này?",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#ED3A3A",
    cancelButtonText: "Không",
    confirmButtonText: "Có"
  }, function (isConfirm) {
    if (isConfirm) {
      $.ajax({
        type: "DELETE",
        url: app_url + 'delete-social-post/' + id,
        success: function success(response) {
          data.ajax.reload();
          data_youTube.ajax.reload();
          toastr.success('Xóa thành công!');
        },
        error: function error(xhr, ajaxOptions, thrownError) {
          toastr.error(thrownError);
        }
      });
    }
  });
}); //AddBtn

$('#AddBtn').on('click', function (e) {
  $('#createModal').modal('show');
});
$(function () {
  $('#frmCreate').validate({
    errorElement: "span",
    rules: {
      link: {
        required: true
      }
    },
    messages: {
      link: {
        required: "Bạn vui lòng nhập link chi tiết bài viết"
      }
    }
  });
});
$('#frmCreate').on('submit', function (e) {
  e.preventDefault();
  check = $(this).valid();

  if (!check) {
    return;
  }

  $.ajax({
    type: "POST",
    url: app_url + 'store-social-post',
    data: {
      title: $('#title_social').val(),
      link: $('#link_social').val(),
      embed: $('#embed_social').val(),
      content: $('#content_social').val(),
      type: $('#type_social').val()
    },
    success: function success(res) {
      //console.log(res);
      data.ajax.reload();
      data_youTube.ajax.reload();
      toastr.success('Thêm thành công!');
      $('#createModal').modal('hide');
      $('#frmCreate')[0].reset();
    },
    error: function error(xhr, ajaxOptions, thrownError) {
      toastr.error(thrownError);
    }
  });
});
$(document).on('click', '.btn-edit', function () {
  // alert(id);
  var id = $(this).attr('data-id');
  console.log(app_url + 'getInfo/' + id);
  $.ajax({
    url: app_url + 'getInfo/' + id,
    type: 'get',
    dataType: '',
    success: function success(res) {
      // console.log(res);
      $('#u_id').val(res.data.id);
      $('#title').val(res.data.title);
      $('#content').val(res.data.content);
      $('#link').val(res.data.link);
      $('#embed').val(res.data.embed);
      $('#type').val(res.data.type);
    }
  });
  $('#editModal').modal('show');
});
$(function () {
  $('#frmCreate').validate({
    errorElement: "span",
    rules: {
      link: {
        required: true
      }
    },
    messages: {
      link: {
        required: "Bạn vui lòng nhập link chi tiết bài viết"
      }
    }
  });
});
$('#frmEdit').on('submit', function (e) {
  e.preventDefault();
  check = $(this).valid();

  if (!check) {
    return;
  }

  id = $('#u_id').val();
  $.ajax({
    type: "POST",
    url: app_url + 'update/' + id,
    data: {
      link: $('#link').val(),
      title: $('#title').val(),
      content: $('#content').val(),
      embed: $('#embed').val(),
      type: $('#type').val()
    },
    success: function success(res) {
      //console.log(res);
      data.ajax.reload();
      data_youTube.ajax.reload();
      toastr.success('Sửa thành công!');
      $('#editModal').modal('hide');
    },
    error: function error(xhr, ajaxOptions, thrownError) {
      toastr.error(thrownError);
    }
  });
});
$(document).ready(function () {
  $(document).ajaxStart(function () {
    $("#cover").show();
  }).ajaxStop(function () {
    $("#cover").hide();
  });
});

/***/ }),

/***/ 11:
/*!**************************************************!*\
  !*** multi ./resources/assets/js/social-post.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\new.aof.project\resources\assets\js\social-post.js */"./resources/assets/js/social-post.js");


/***/ })

/******/ });