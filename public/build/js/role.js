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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/assets/js/role.js":
/*!*************************************!*\
  !*** ./resources/assets/js/role.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var table = $('#roles-table').DataTable({
    processing: true,
    serverSide: true,
    ordering: false,
    order: [],
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    ajax: app_url + 'list-role',
    columns: [{
      data: 'DT_Row_Index',
      name: 'id',
      'class': 'dt-center'
    }, {
      data: 'display_name',
      name: 'display_name'
    }, {
      data: 'name',
      name: 'name'
    }, {
      data: 'description',
      name: 'description'
    }, {
      data: 'created_at',
      name: 'created_at',
      'class': 'dt-center'
    }, {
      data: 'action',
      name: 'action',
      orderable: false,
      searchable: false,
      'class': 'dt-center'
    }]
  }); //edit role

  $(document).on('click', '.btn-edit', function () {
    $('#editRoleModal').modal('show');
    var id = $(this).data('id');
    $.ajax({
      type: "GET",
      url: app_url + "roles/" + id,
      success: function success(res) {
        $('#edit_name').val(res.data.name);
        $('#edit_id').val(res.data.id);
        $('#edit_name').focus();
        $('#edit_display_name').val(res.data.display_name);
        $('#edit_display_name').focus();
        $('#edit_description').val(res.data.description);
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });
  $(document).on('submit', '#edit-role', function (e) {
    e.preventDefault();
    var id = $('#edit_id').val();
    var form = $('#edit-role');
    var formData = form.serialize();
    if (!form.valid()) return false;
    $.ajax({
      type: 'PUT',
      url: app_url + 'roles/' + id,
      data: formData,
      success: function success(data) {
        if (!data.error) {
          toastr.success("Cập nhật thành công");
          $('#editRoleModal').modal('hide');
          table.ajax.reload(null, false);
        } else {
          if (data.message.display_name == undefined && data.message.name == undefined) {
            toastr.error(data.message);
          } else {
            if (data.message.display_name != undefined) {
              toastr.error(data.message.display_name);
            }

            if (data.message.name != undefined) {
              toastr.error(data.message.name);
            }
          }
        }
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  }); //delete role

  $(document).on('click', '.btn-delete', function () {
    var role_id = $(this).data('id');
    swal({
      title: "Bạn có chắc muốn xóa?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      cancelButtonText: "Không",
      confirmButtonText: "Có"
    }, function (isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: "DELETE",
          url: app_url + "roles/" + role_id,
          success: function success(res) {
            console.log(res.error);

            if (res.error == false) {
              toastr.success('Xóa thành công!');
              table.ajax.reload(null, false);
            }

            if (res.error == true) {
              console.log('123123132');
              toastr.error('Xóa thất bại do vai trò này đang được sử dụng!');
              table.ajax.reload(null, false);
            }
          },
          error: function error(xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }
    });
  }); //show popup add role

  $(document).on('click', '.btn-add-role', function () {
    $('#createRoleModal').modal('show');
    $('#name').val('');
    $('#display_name').val('');
    $('#description').val('');
  });
  $(document).on('submit', '#add-role', function (e) {
    e.preventDefault();
    var form = $('#add-role');
    var formData = form.serialize();
    if (!form.valid()) return false;
    $.ajax({
      type: 'POST',
      url: app_url + 'roles',
      data: formData,
      success: function success(data) {
        if (!data.error) {
          toastr.success("Thành công");
          $('#createRoleModal').modal('hide');
          table.ajax.reload(null, false);
        } else {
          if (data.message.display_name == undefined && data.message.name == undefined) {
            toastr.error(data.message);
          } else {
            if (data.message.display_name != undefined) {
              toastr.error(data.message.display_name);
            }

            if (data.message.name != undefined) {
              toastr.error(data.message.name);
            }
          }
        }
      },
      error: function error(xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);
      }
    });
  });
});

/***/ }),

/***/ 9:
/*!*******************************************!*\
  !*** multi ./resources/assets/js/role.js ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\aof.project\resources\assets\js\role.js */"./resources/assets/js/role.js");


/***/ })

/******/ });