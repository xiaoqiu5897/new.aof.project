

  var data = $('#social-post-facebook').DataTable({
    processing: true,
    serverSide: true,
    ajax: app_url+'json/social-post-facebook',
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    columns: [
      {data: 'DT_Row_Index', orderable: false, searchable: false, class: 'dt-center'},
      {data: 'title', name: 'title'},
      {data: 'link', name: 'link'},
      {data: 'content', name: 'content', class: 'td-content'},
      {data: 'action', name: 'action'},
    ],
  });



  var data_youTube = $('#social-post-youtube').DataTable({
    processing: true,
    serverSide: true,
    ajax: app_url+'json/social-post-youtube',
    pageLength: 30,
    lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
    columns: [
    {data: 'DT_Row_Index', orderable: false, searchable: false, class: 'dt-center'},
    {data: 'title', name: 'title'},
    {data: 'embed', name: 'embed', class: 'td-embed'},
    {data: 'link', name: 'link'},
    {data: 'content', name: 'content', class: 'td-yb-content'},
    {data: 'action', name: 'action'},
    ],
  });



  $(document).on('click','.btn-danger',function(){
    // alert('ok')
    var id = $(this).data("id");
    swal({
      title: "Xóa trang web này?",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#ED3A3A",
      cancelButtonText: "Không",
      confirmButtonText: "Có",
    },
    function(isConfirm) {
      if (isConfirm) {
        $.ajax({
          type: "DELETE",
          url: app_url+'delete-social-post/' + id,
          success: function(response)
          {
            data.ajax.reload();
            data_youTube.ajax.reload();
            toastr.success('Xóa thành công!');
          },
          error: function (xhr, ajaxOptions, thrownError) {
            toastr.error(thrownError);
          }
        });
      }
    });
  });


//AddBtn
$('#AddBtn').on('click', function(e) {
  $('#createModal').modal('show');
});

$(function(){
  $('#frmCreate').validate({
    errorElement: "span",
    rules: {
      link : {
        required: true,
      },
    },
    messages: {
      link : {
        required:"Bạn vui lòng nhập link chi tiết bài viết",
      },
    }
  });
})

$('#frmCreate').on('submit', function(e) {
  e.preventDefault();
  check = $(this).valid();
  if(!check) {
    return;
  }
  $.ajax({
    type: "POST",
    url: app_url+'store-social-post',
    data: {
      title : $('#title_social').val(),
      link : $('#link_social').val(),
      embed : $('#embed_social').val(),
      content : $('#content_social').val(),
      type : $('#type_social').val()
    },
    success: function(res)
    {
      //console.log(res);
      data.ajax.reload();
      data_youTube.ajax.reload();
      toastr.success('Thêm thành công!');
      $('#createModal').modal('hide');
      $('#frmCreate')[0].reset(); 
    },
    error: function (xhr, ajaxOptions, thrownError) {
      toastr.error(thrownError);

    }
  });
})


  $(document).on('click','.btn-edit',function(){
  // alert(id);
    var id= $(this).attr('data-id');
    console.log(app_url+'getInfo/'+id);
    $.ajax({
      url: app_url+'getInfo/'+id,
      type: 'get',
      dataType: '',
      success : function(res) {
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

  $(function(){
    $('#frmCreate').validate({
      errorElement: "span",
      rules: {
        link : {
          required: true,
        },
      },
      messages: {
        link : {
          required:"Bạn vui lòng nhập link chi tiết bài viết",
        },
      }
    });
  })

  $('#frmEdit').on('submit', function(e) {
    e.preventDefault();
    check = $(this).valid();
    if(!check) {
      return;
    }
    id = $('#u_id').val();
    $.ajax({
      type: "POST",
      url: app_url+'update/' + id,
      data: {
        link : $('#link').val(),
        title : $('#title').val(),
        content : $('#content').val(),
        embed : $('#embed').val(),
        type : $('#type').val(),
      },
      success: function(res)
      {
        //console.log(res);
        data.ajax.reload();
        data_youTube.ajax.reload();
        toastr.success('Sửa thành công!');
        $('#editModal').modal('hide');
      },
      error: function (xhr, ajaxOptions, thrownError) {
        toastr.error(thrownError);

      }
    });
  })

  $(document).ready(function () {
    $(document).ajaxStart(function () {
      $("#cover").show();
    }).ajaxStop(function () {
      $("#cover").hide();
    });
  });
