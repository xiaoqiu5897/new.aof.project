$(document).ready(function() {
    $("body").tooltip({ selector: '[data-tooltip=tooltip]' });
});

//change to base64
function readImage(input) {
    if ( input.files && input.files[0] ) {
        var FR= new FileReader();
        FR.onload = function(e) {
        //e.target.result = base64 format picture
            $('#image_base64').val(e.target.result);
        };
        FR.readAsDataURL( input.files[0] );
    }
}
$("#image").change(function(){
    readImage( this );
});

window.viewDetail= function(id){
    $('#showPer').modal('show');
    $('#showPer').attr('style', 'overflow: auto !important');

    $.ajax({
        type: 'GET',
        url: 'permissions/'+id+'/edit',
        success: function(res){
            $('#showPer .modal-body').html(res.description);
        }  
    });
};

window.showEdit = function(id){
    $('#editPer').modal('show');
    $('#editPer').attr('style', 'overflow: auto !important');
    $('#btnEditPer').attr('data-id', '');

    $.ajax({
        type: 'GET',
        url: 'permissions/'+id+'/edit',
        success: function(res){
            $('#editPer #display_name').val(res.display_name);
            $('#editPer #name').val(res.name);
            if(res.description){
                tinyMCE.get("editDescription").setContent(res.description);
            }else{
                tinyMCE.get("editDescription").setContent('');
            }
            $('#editPer #edit_id').val(id);
        }  
    });
};

$('#btnEditPer').click(function(){
    var id = $('#editPer #edit_id').val();

    $.ajax({
        url: '/permissions/'+id,
        type: 'PUT',
        data: {
            display_name: $('#editPer #display_name').val(),
            name: $('#editPer #name').val(),
            description: tinyMCE.get('editDescription').getContent(),
        },success: function(res){
            if(!res.error){
                $('#editPer').modal('hide');
                toastr.success('Cập nhật thành công!');
                $('#permissions-table').DataTable().ajax.reload();
            }else{
                if(res.message.display_name){
                    toastr.error(res.message.display_name);
                }else if(res.message.name){
                    toastr.error(res.message.name);
                }else{
                    toastr.error(res.message);
                }
            }
        }
    });
});

$('.btnAdd').click(function(){
    $('#createPer').attr('style', 'overflow: auto !important');
    $('#createPer #display_name').val('');
    $('#createPer #name').val('');
    tinymce.get("description").setContent('');
});

$('#btnCreatePer').click(function(e){
    $.ajax({
        url: '/permissions',
        type: 'POST',
        data: {
            display_name: $('#createPer #display_name').val(),
            name: $('#createPer #name').val(),
            description: tinyMCE.get('description').getContent(),
        },success: function(res){
            if(!res.error){
                $('#createPer').modal('hide');
                toastr.success('Thêm thành công!');
                $('#permissions-table').DataTable().ajax.reload();
            }else{
                if(res.message.display_name){
                    toastr.error(res.message.display_name);
                }else if(res.message.name){
                    toastr.error(res.message.name);
                }else{
                    toastr.error(res.message);
                }
            }
        }
    })
});


// delete permission
// $(document).on('click', '.btn-delete', function () {

//     var path = "/permissions/" + $(this).data('id');

//     swal({
//         title: "Bạn có chắc muốn xóa?",
//         type: "warning",
//         showCancelButton: true,
//         confirmButtonColor: "#DD6B55",
//         cancelButtonText: "Không",
//         confirmButtonText: "Có",
//     },
//     function(isConfirm) {
//         if (isConfirm) {  

//             $.ajax({
//                   type: "DELETE",
//                   url: path,
//                   success: function(res)
//                   {
//                     if(!res.error) {
//                         toastr.warning('Xóa thành công!');
//                         $('#permissions-table').DataTable().ajax.reload();      
//                   }
//                   },
//                   error: function (xhr, ajaxOptions, thrownError) {
//                     toastr.error(thrownError);
//                   }
//             });
//         } 
//     });
// });


tinymce.init({
    selector: '#description',
    height: 350,
    theme: 'modern',
    menubar: false,
    autosave_ask_before_unload: false,
    plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern codesample"
    ],
    toolbar1: "newdocument | forecolor backcolor cut copy paste bullist numlist bold italic underline strikethrough| alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect  | searchreplace  | outdent indent | undo redo | link unlink anchor image media code | insertdatetime preview | table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | codesample",
    image_advtab: true,
    content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
    ],
    setup: function (ed) {
      ed.on('init', function (e) {
        ed.execCommand("fontName", false, "Tahoma");
      });
    },
    relative_urls: false,
    remove_script_host : false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = route_prefix + '?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Image manager',
        width : x * 0.9,
        height : y * 0.9,
        resizable : "yes",
        close_previous : "no"
      });
    }
  });


tinymce.init({
    selector: '#editDescription',
    height: 350,
    theme: 'modern',
    menubar: false,
    autosave_ask_before_unload: false,
    plugins: [
    "advlist autolink link image lists charmap print preview hr anchor pagebreak",
    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
    "table contextmenu directionality emoticons template textcolor paste textcolor colorpicker textpattern codesample"
    ],
    toolbar1: "newdocument | forecolor backcolor cut copy paste bullist numlist bold italic underline strikethrough| alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect  | searchreplace  | outdent indent | undo redo | link unlink anchor image media code | insertdatetime preview | table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | codesample",
    image_advtab: true,
    content_css: [
    '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
    '//www.tinymce.com/css/codepen.min.css'
    ],
    setup: function (ed) {
      ed.on('init', function (e) {
        ed.execCommand("fontName", false, "Tahoma");
      });
    },
    relative_urls: false,
    remove_script_host : false,
    file_browser_callback : function(field_name, url, type, win) {
      var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
      var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

      var cmsURL = route_prefix + '?field_name=' + field_name;
      if (type == 'image') {
        cmsURL = cmsURL + "&type=Images";
      } else {
        cmsURL = cmsURL + "&type=Files";
      }

      tinyMCE.activeEditor.windowManager.open({
        file : cmsURL,
        title : 'Image manager',
        width : x * 0.9,
        height : y * 0.9,
        resizable : "yes",
        close_previous : "no"
      });
    }
  });