$(function(){

  CKEDITOR.replace( 'add_partner_introduction' );
  CKEDITOR.replace( 'edit_partner_introduction' );

  var partnerTable=$('#partner-table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        order: [],
        pageLength: 30,
        lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
        ajax: app_url + 'partner-getlist',
        columns: [
            {data: 'DT_Row_Index', name: 'id', 'class':'text-center'},
            {data: 'partner_name', name: 'partner_name'},
            {data: 'address', name: 'address'},
            {data: 'hr_name', name: 'hr_name'},
            {data: 'hr_mobile', name: 'hr_mobile'},
            {data: 'hr_email', name: 'hr_email'},
            {data: 'logo', name: 'logo', 'class':'text-center'},
            {data: 'action', name: 'action', orderable: false, searchable: false, 'class':'text-center'},
        ]
    });



  $(document).on('click','#btn-add-partner',function () {
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
    CKEDITOR.instances.add_partner_introduction.setData( '', function() { this.updateElement(); } );
    $('#thumbnail').val('');
  });

  $(document).on("click", "#btn-create-submit", function(e) {
    e.preventDefault();
    // alert(app_url + "partners");


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
        'introduction': CKEDITOR.instances.add_partner_introduction.getData(),
      },
      success: function(res){
        if (res.err != true) {
          // console.log(res);
          partnerTable.ajax.reload();
          $('#create-partner-modal').modal('hide');
          toastr.success('Đã tạo mới đối tác');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.responseJSON.errors.partner_name!==undefined) {
          $('#partner_name_validate').text(jqXHR.responseJSON.errors.partner_name[0]);
        }
        if (jqXHR.responseJSON.errors.address!==undefined) {
          $('#address_validate').text(jqXHR.responseJSON.errors.address[0]);
        }
        if (jqXHR.responseJSON.errors.hr_name!==undefined) {
          $('#hr_name_validate').text(jqXHR.responseJSON.errors.hr_name[0]);
        }
        if (jqXHR.responseJSON.errors.hr_mobile!==undefined) {
          $('#hr_mobile_validate').text(jqXHR.responseJSON.errors.hr_mobile[0]);
        }
        if (jqXHR.responseJSON.errors.hr_email!==undefined) {
          $('#hr_email_validate').text(jqXHR.responseJSON.errors.hr_email[0]);
        }
        if (jqXHR.responseJSON.errors.introduction!==undefined) {
          $('#introduction_validate').text(jqXHR.responseJSON.errors.introduction[0]);
        }
        if (jqXHR.responseJSON.errors.logo!==undefined) {
          $('#logo_validate').text(jqXHR.responseJSON.errors.logo[0]);
        }
      }
    });
  });

  $(document).on('click','.btn-edit',function () {
    $('#edit-partner-modal').modal('show');
    $('#partner_name_edit_validate').text('');
    $('#address_edit_validate').text('');
    $('#hr_name_edit_validate').text('');
    $('#hr_mobile_edit_validate').text('');
    $('#hr_email_edit_validate').text('');
    $('#introduction_edit_validate').text('');
    $('#logo_edit_validate').text('');

    var id=$(this).attr('data-id');
    $.ajax({
      url: app_url + "partners/"+id+"/edit",
      type: 'get',
      success: function(res){
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
        $('#btn-update-submit').attr('data-id',res.partner.id);
        $('#edit_previewimg').attr('src',app_url+res.partner.logo);
        }
      }
    });
  });


  $(document).on("click", "#btn-update-submit", function(e) {
    e.preventDefault();
    // alert(app_url + "partners");
    var id=$(this).attr('data-id');


    $.ajax({
      url: app_url + "partners/"+id,
      type: 'put',
      data: {
        'partner_name': $('#edit_partner_name').val(),
        'slug': $('#edit_partner_name').val(),
        'address': $('#edit_address').val(),
        'hr_name': $('#edit_hr_name').val(),
        'hr_mobile': $('#edit_hr_mobile').val(),
        'hr_email': $('#edit_hr_email').val(),
        'logo': $('#edit_thumbnail').val(),
        'introduction': CKEDITOR.instances.edit_partner_introduction.getData(),
      },
      success: function(res){
        if (res.err != true) {
          console.log(res);
          partnerTable.ajax.reload();
          $('#edit-partner-modal').modal('hide');
          toastr.warning('Đã sửa thông tin đối tác');
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        if (jqXHR.responseJSON.errors.partner_name!==undefined) {
          $('#partner_name_edit_validate').text(jqXHR.responseJSON.errors.partner_name[0]);
        }
        if (jqXHR.responseJSON.errors.address!==undefined) {
          $('#address_edit_validate').text(jqXHR.responseJSON.errors.address[0]);
        }
        if (jqXHR.responseJSON.errors.hr_name!==undefined) {
          $('#hr_name_edit_validate').text(jqXHR.responseJSON.errors.hr_name[0]);
        }
        if (jqXHR.responseJSON.errors.hr_mobile!==undefined) {
          $('#hr_mobile_edit_validate').text(jqXHR.responseJSON.errors.hr_mobile[0]);
        }
        if (jqXHR.responseJSON.errors.hr_email!==undefined) {
          $('#hr_email_edit_validate').text(jqXHR.responseJSON.errors.hr_email[0]);
        }
        if (jqXHR.responseJSON.errors.introduction!==undefined) {
          $('#introduction_edit_validate').text(jqXHR.responseJSON.errors.introduction[0]);
        }
        if (jqXHR.responseJSON.errors.logo!==undefined) {
          $('#logo_edit_validate').text(jqXHR.responseJSON.errors.logo[0]);
        }
      }
    });
  });

  // $(document).on("submit", "#frm-edit", function(e) {
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

  $(document).on("click", ".btn-delete", function(e) {
    e.preventDefault();

    var id = $(this).attr("data-id");

    swal({
    title: "Bạn có chắc muốn xóa?",
        // text: "Bạn sẽ không thể khôi phục lại bản ghi này!!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        cancelButtonText: "Không",
        confirmButtonText: "Có",
        
        // closeOnConfirm: false,
      },
      function(isConfirm) {
        if (isConfirm) { 

      $.ajax({
        url: app_url + "partners/"+id,
        type: 'delete',
        success: function(res){
          if (res.err != true) {
            partnerTable.ajax.reload();
            toastr.error('Đã xoá đối tác'); 
          }
        }
      });
        } 
      });

  })

  $(document).on('click','.btn-view',function () {

    var id=$(this).attr('data-id');
    // alert(id);
    $.ajax({
      url: app_url + "partners/"+id,
      type: 'get',
      success: function(res){
        // console.log(res);
        if (res.err != true) {
          $('#show-partner-modal').modal('show');
          $('#show_logo').html('<img class="img-responsive img-rounded" src="'+app_url+res.partner.logo+'" alt="">');
          $('#show_partner_name').text(res.partner.partner_name);
          $('#show_partner_address').html('<span>Address: </span>'+res.partner.address);
          $('#show_hr_name').html('<span>HR Name: </span>'+res.partner.hr_name);
          $('#show_hr_email').html('<span>HR Email: </span>'+res.partner.hr_email);
          $('#show_hr_mobile').html('<span>HR Mobile: </span>'+res.partner.hr_mobile);
          $('#show_partner_introduction').html(res.partner.introduction);
        }
      }
    });
  });
});
