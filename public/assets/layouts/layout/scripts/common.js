(function( $ ){
    // Get select option
    $.fn.getAllSelectOptionUsers = function(target) {
        var url = '/users/get_all_user_select_option';
        $.get(url, function (data) {
            target.html(data);
        });
        return this;
    };
    // Get select option
    $.fn.getAllSelectOptionClass = function(target) {
        var url = '/classroom/get_all_class_select_option';
        $.get(url, function (data) {
            target.html(data);
        });
        return this;
    };



    //Normal create function
    $.fn.createForm = function(route_index) {
        App.blockUI({
            animate: !0
        });
        var url = this.attr('action');
        formData = new FormData(this[0]);
        formData.append('action', 'ADD');
        formData.append('param', 0);
        formData.append('secondParam', 0);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            cache:false,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
        })
            .done(function(res) {
                if (!res.error) {
                    toastr.success('Tạo mới thành công!');
                    setTimeout(function() {
                        window.location.href = route_index;
                    }, 500);
                }else{
                    toastr.error('Tạo mới thất bại. Vui lòng thử lại!');
                    App.unblockUI();
                }
            })
            .fail(function(xhr, ajaxOptions, thrownError) {
                var errors = xhr.responseJSON;
                $.each( errors, function( key, value ) {
                    error = value[0];
                });
                toastr.error(error);
                App.unblockUI();
            });
        return this;
    };

    //Normal edit function
    $.fn.editForm = function(token,route_index) {
        App.blockUI({
            animate: !0
        });
        var url = this.attr('action');
        formData = new FormData(this[0]);
        formData.append('_method', 'PUT');
        formData.append('_token', token );
        formData.append('action', 'ADD');
        formData.append('param', 0);
        formData.append('secondParam', 0);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            cache:false,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
        })
            .done(function(res) {
                if (!res.error) {
                    toastr.success('Cập nhật thành công!');
                    setTimeout(function() {
                        window.location.href = route_index;
                    }, 500);
                }else{
                    toastr.error('Cập nhật thất bại. Vui lòng thử lại!');
                    App.unblockUI();
                }
            })
            .fail(function(xhr, ajaxOptions, thrownError) {
                var errors = xhr.responseJSON;
                $.each( errors, function( key, value ) {
                    error = value[0];
                });
                toastr.error(error);
                App.unblockUI();
            });
        return this;
    };

    //Normal delete function
    $.fn.deleteObjectTable = function(e,token,route_delete) {
        swal({
                title: "Bạn có chắc muốn xóa?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                cancelButtonText: "Không. Bỏ qua",
                confirmButtonText: "Có. Tôi đồng ý",
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: "POST",
                        url: route_delete,
                        data: { _method: 'DELETE', _token :token },
                        context: $(this),
                        success: function(res)
                        {
                            if(!res.error) {
                                toastr.success('Xóa thành công!');
                                $(e.target).closest('#dataTableBuilder tbody tr').remove();
                            }else{
                                toastr.error('Xóa thất bại. Vui lòng thử lại!');
                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            toastr.error(thrownError);
                        }
                    });
                }
            });
        return this;
    };

    //get district form city id function
    $.fn.getDistricts = function(city_id,district_target,ward_target) {
        var url = '/core/get_district/'+ city_id;
        $.get(url, function (data) {
            district_target.html(data);
            ward_target.html('<option value="">Vui lòng chọn</option>');
        });
        return this;
    };

    //get wards form city id function
    $.fn.getWards = function(district_id,ward_target) {
        var url = '/core/get_ward/'+ district_id;
        $.get(url, function (data) {
            ward_target.html(data);
        });
        return this;
    };

    //get room name by room type
    $.fn.getRoomNames = function(room_type_id,room_name_target) {
        var url = '/core/get_room_name/'+ room_type_id;
        $.get(url, function (data) {
            room_name_target.html(data);
        });
        return this;
    };

    //valid phone number
    $.fn.validPhone = function(input,utilsScript) {
        var form_group = input.closest('.form-group');
        form = input.closest("form");
        input.intlTelInput({
            nationalMode: true,
            preferredCountries: [ "vn","us","gb"],
            utilsScript: utilsScript // just for formatting/placeholders etc
        });

        var reset = function() {
            input.removeClass("error");
            form_group.removeClass('has-success has-error')
        };

        // on blur: validate
        input.blur(function() {
            reset();
            if ($.trim(input.val())) {
                if (input.intlTelInput("isValidNumber")) {
                    form_group.addClass('has-success');
                    if (form_group.hasClass('has-error')){
                        form_group.removeClass('has-error');
                    }
                } else {
                    form_group.addClass('has-error');
                    if (form_group.hasClass('has-success')){
                        form_group.removeClass('has-success');
                    }
                }
            }
        });

        // on keyup / change flag: reset
        input.on("keyup change", reset);
        return this;
    };

    //Create function customize FormData
    $.fn.createFormCustom = function(formData) {
        App.blockUI({
            animate: !0
        });
        var url = this.attr('action');
        // formData = new FormData(this[0]);

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            cache:false,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
        })
            .done(function(res) {
                if (!res.error) {
                    toastr.success('Tạo mới thành công!');
                    setTimeout(function() {
                        window.location.href = res.route_index;
                    }, 500);
                }else{
                    toastr.error('Tạo mới thất bại. Vui lòng thử lại!');
                    App.unblockUI();
                }
            })
            .fail(function(xhr, ajaxOptions, thrownError) {
                var errors = xhr.responseJSON;
                $.each( errors, function( key, value ) {
                    error = value[0];
                });
                toastr.error(error);
                App.unblockUI();
            });
        return this;
    };

    //Create function with ajax append view blade
    $.fn.createFormAppendBlade = function(formData,objParent) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: formData,
            cache:false,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
        })
            .done(function(res) {
                if (!res.error) {
                    toastr.success('Tạo mới thành công!');
                    console.log(res.view);
                    objParent.append(res.view);
                }else{
                    toastr.error('Tạo mới thất bại. Vui lòng thử lại!');
                }
            })
            .fail(function(xhr, ajaxOptions, thrownError) {
                var errors = xhr.responseJSON;
                $.each( errors, function( key, value ) {
                    error = value[0];
                });
                toastr.error(error);
            });
        return this;
    };

})( jQuery );