/* start custom datatable */
$.extend(true, $.fn.dataTable.defaults, {
  "language": {
    "responsive": true,
    "emptyTable": "Không có bản ghi nào",
    "search": "Tìm kiếm:",
    "info": "Hiển thị từ bản ghi số _START_ đến _END_ trong _TOTAL_ bản ghi",
    "infoEmpty": "Hiển thị 0 đến 0 trong 0 bản ghi",
    "zeroRecords": "Không tìm thấy bản ghi nào",
    "loadingRecords": "Đang tải...",
    "lengthMenu": '<select class="form-control input-inline">' + '<option value="30" selected>30</option>' + '<option value="50">50</option>' + '<option value="100">100</option>' + '<option value="200">200</option>' + '<option value="500">500</option>' + '</select> bản ghi',
    "paginate": {
      "first": "Trang đầu",
      "last": "Trang cuối",
      "next": "Trang tiếp",
      "previous": "Trang trước"
    },
    "processing": "Đang tải...",
  },
  "pageLength": 30,
  "lengthMenu": [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]]
});