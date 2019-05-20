$(function() {
    var table = $('#logs-table').DataTable({
        processing: true,
        serverSide: true,
        order: [], 
        lengthMenu: [[30, 50, 100, 200, 500], [30, 50, 100, 200, 500]],
        ajax: app_url + 'systems/list-backup-database',
        columns: [
            {data: 'id', name: 'id', 'class':'dt-center'},
            {data: 'name', name: 'name'},
            {data: 'size', name: 'size'},
            {data: 'created_at', name: 'created_at', 'class':'dt-center'},
            {data: 'action', name: 'action',  orderable: false, searchable: false},
        ]
    });

});