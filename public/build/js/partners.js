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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/partners.js":
/*!*****************************************!*\
  !*** ./resources/assets/js/partners.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  CKEDITOR.replace('add_partner_introduction');
  CKEDITOR.replace('edit_partner_introduction');
  var partnerTable = $('#partner-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [],
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: app_url + 'partner-getlist',
    columns: [{
      data: 'DT_Row_Index',
      name: 'id',
      'class': 'text-center'
    }, {
      data: 'partner_name',
      name: 'partner_name'
    }, {
      data: 'address',
      name: 'address'
    }, {
      data: 'hr_name',
      name: 'hr_name'
    }, {
      data: 'hr_mobile',
      name: 'hr_mobile'
    }, {
      data: 'hr_email',
      name: 'hr_email'
    }, {
      data: 'logo',
      name: 'logo',
      'class': 'text-center'
    }, {
      data: 'action',
      name: 'action',
      orderable: false,
      searchable: false,
      'class': 'text-center'
    }]
  });
  $(document).on('click', '#btn-add-partner', function () {
    $('#create-partner-modal').modal('show');
    $('#partner_name_validate').text('');
    $('#address_validate').text('');
    $('#hr_name_validate').text('');
    $('#hr_mobile_validate').text('');
    $('#hr_email_validate').text('');
    $('#introduction_validate').text('');
    $('#logo_validate').text('');
    $('#add_partner_name').val('');
    $('#add_address').val('');
    $('#add_hr_name').val('');
    $('#add_hr_mobile').val('');
    $('#add_hr_email').val('');
    CKEDITOR.instances.add_partner_introduction.setData('', function () {
      this.updateElement();
    });
    $('#thumbnail').val('');
  });
  $(document).on("click", "#btn-create-submit", function (e) {
    e.preventDefault(); // alert(app_url + "partners");

    $.ajax({
      url: app_url + "partners",
      type: 'POST',
      data: {
        'partner_name': $('#add_partner_name').val(),
        'slug': $('#add_partner_name').val(),
        'address': $('#add_address').val(),
        'hr_name': $('#add_hr_name').val(),
        'hr_mobile': $('#add_hr_mobile').val(),
        'hr_email': $('#add_hr_email').val(),
        'logo': $('#thumbnail').val(),
        'introduction': CKEDITOR.instances.add_partner_introduction.getData()
      },
      success: function success(res) {
        if (res.err != true) {
          // console.log(res);
          partnerTable.ajax.reload();
          $('#create-partner-modal').modal('hide');
          toastr.success('Đã tạo mới đối tác');
        }
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        if (jqXHR.responseJSON.errors.partner_name !== undefined) {
          $('#partner_name_validate').text(jqXHR.responseJSON.errors.partner_name[0]);
        }

        if (jqXHR.responseJSON.errors.address !== undefined) {
          $('#address_validate').text(jqXHR.responseJSON.errors.address[0]);
        }

        if (jqXHR.responseJSON.errors.hr_name !== undefined) {
          $('#hr_name_validate').text(jqXHR.responseJSON.errors.hr_name[0]);
        }

        if (jqXHR.responseJSON.errors.hr_mobile !== undefined) {
          $('#hr_mobile_validate').text(jqXHR.responseJSON.errors.hr_mobile[0]);
        }

        if (jqXHR.responseJSON.errors.hr_email !== undefined) {
          $('#hr_email_validate').text(jqXHR.responseJSON.errors.hr_email[0]);
        }

        if (jqXHR.responseJSON.errors.introduction !== undefined) {
          $('#introduction_validate').text(jqXHR.responseJSON.errors.introduction[0]);
        }

        if (jqXHR.responseJSON.errors.logo !== undefined) {
          $('#logo_validate').text(jqXHR.responseJSON.errors.logo[0]);
        }
      }
    });
  });
  $(document).on('click', '.btn-edit', function () {
    $('#edit-partner-modal').modal('show');
    $('#partner_name_edit_validate').text('');
    $('#address_edit_validate').text('');
    $('#hr_name_edit_validate').text('');
    $('#hr_mobile_edit_validate').text('');
    $('#hr_email_edit_validate').text('');
    $('#introduction_edit_validate').text('');
    $('#logo_edit_validate').text('');
    var id = $(this).attr('data-id');
    $.ajax({
      url: app_url + "partners/" + id + "/edit",
      type: 'get',
      success: function success(res) {
        // console.log(res);
        if (res.err != true) {
          // console.log(res);
          $('#edit_partner_name').val(res.partner.partner_name);
          $('#edit_address').val(res.partner.address);
          $('#edit_hr_name').val(res.partner.hr_name);
          $('#edit_hr_mobile').val(res.partner.hr_mobile);
          $('#edit_hr_email').val(res.partner.hr_email);
          CKEDITOR.instances.edit_partner_introduction.setData(res.partner.introduction);
          $('#edit_thumbnail').val(res.partner.logo);
          $('#btn-update-submit').attr('data-id', res.partner.id);
          $('#edit_previewimg').attr('src', app_url + res.partner.logo);
        }
      }
    });
  });
  $(document).on("click", "#btn-update-submit", function (e) {
    e.preventDefault(); // alert(app_url + "partners");

    var id = $(this).attr('data-id');
    $.ajax({
      url: app_url + "partners/" + id,
      type: 'put',
      data: {
        'partner_name': $('#edit_partner_name').val(),
        'slug': $('#edit_partner_name').val(),
        'address': $('#edit_address').val(),
        'hr_name': $('#edit_hr_name').val(),
        'hr_mobile': $('#edit_hr_mobile').val(),
        'hr_email': $('#edit_hr_email').val(),
        'logo': $('#edit_thumbnail').val(),
        'introduction': CKEDITOR.instances.edit_partner_introduction.getData()
      },
      success: function success(res) {
        if (res.err != true) {
          console.log(res);
          partnerTable.ajax.reload();
          $('#edit-partner-modal').modal('hide');
          toastr.warning('Đã sửa thông tin đối tác');
        }
      },
      error: function error(jqXHR, textStatus, errorThrown) {
        if (jqXHR.responseJSON.errors.partner_name !== undefined) {
          $('#partner_name_edit_validate').text(jqXHR.responseJSON.errors.partner_name[0]);
        }

        if (jqXHR.responseJSON.errors.address !== undefined) {
          $('#address_edit_validate').text(jqXHR.responseJSON.errors.address[0]);
        }

        if (jqXHR.responseJSON.errors.hr_name !== undefined) {
          $('#hr_name_edit_validate').text(jqXHR.responseJSON.errors.hr_name[0]);
        }

        if (jqXHR.responseJSON.errors.hr_mobile !== undefined) {
          $('#hr_mobile_edit_validate').text(jqXHR.responseJSON.errors.hr_mobile[0]);
        }

        if (jqXHR.responseJSON.errors.hr_email !== undefined) {
          $('#hr_email_edit_validate').text(jqXHR.responseJSON.errors.hr_email[0]);
        }

        if (jqXHR.responseJSON.errors.introduction !== undefined) {
          $('#introduction_edit_validate').text(jqXHR.responseJSON.errors.introduction[0]);
        }

        if (jqXHR.responseJSON.errors.logo !== undefined) {
          $('#logo_edit_validate').text(jqXHR.responseJSON.errors.logo[0]);
        }
      }
    });
  }); // $(document).on("submit", "#frm-edit", function(e) {
  //   e.preventDefault();
  //   var formData  = $('#frm-edit').serialize();
  //   $.ajax({
  //     url: app_url + "contact-update",
  //     type: 'POST',
  //     data: {
  //       'data': formData
  //     },
  //     success: function(res){
  //       // console.log(res);
  //       if (res.err != true) {
  //         toastr.success(res.msg);
  //         setTimeout(function() {
  //           window.location.href = app_url + "contacts";
  //         }, 2000);
  //       }
  //     }
  //   });
  // });

  $(document).on("click", ".btn-delete", function (e) {
    e.preventDefault();
    var id = $(this).attr("data-id");
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
          url: app_url + "partners/" + id,
          type: 'delete',
          success: function success(res) {
            if (res.err != true) {
              partnerTable.ajax.reload();
              toastr.error('Đã xoá đối tác');
            }
          }
        });
      }
    });
  });
  $(document).on('click', '.btn-view', function () {
    var id = $(this).attr('data-id'); // alert(id);

    $.ajax({
      url: app_url + "partners/" + id,
      type: 'get',
      success: function success(res) {
        // console.log(res);
        if (res.err != true) {
          $('#show-partner-modal').modal('show');
          $('#show_logo').html('<img class="img-responsive img-rounded" src="' + app_url + res.partner.logo + '" alt="">');
          $('#show_partner_name').text(res.partner.partner_name);
          $('#show_partner_address').html('<span>Address: </span>' + res.partner.address);
          $('#show_hr_name').html('<span>HR Name: </span>' + res.partner.hr_name);
          $('#show_hr_email').html('<span>HR Email: </span>' + res.partner.hr_email);
          $('#show_hr_mobile').html('<span>HR Mobile: </span>' + res.partner.hr_mobile);
          $('#show_partner_introduction').html(res.partner.introduction);
        }
      }
    });
  });
});

/***/ }),

/***/ 10:
/*!***********************************************!*\
  !*** multi ./resources/assets/js/partners.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\new.aof.project\resources\assets\js\partners.js */"./resources/assets/js/partners.js");


/***/ })

/******/ });