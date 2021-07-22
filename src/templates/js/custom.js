$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

const url = "http://blog.oop";
// console.log(`${url}/post-list`);
// console.log(`${url}/admin/post-detail`);


// datatable datalarını alıyorum.
$(document).ready(function () {
    $('#datatable').DataTable({
        ajax: {
            'url': `${url}/admin/blog-list`,
            'type': 'POST',
            'dataSrc': '',
        },
        columns: [
            {data: 'id'},
            {data: 'title',
                render: function (data, type, row){
                    return `<a href="${url}/admin/blog-detail/${row.id}">${data}</a>`;
                }
            },
            {data: 'content'},
            {data: 'category'},
            {data: 'author'},
            {
                render: function (data, type, row) {
                    return `<button id="${row.id}" class="btn btn-danger deleteButton" onclick="refresh()">Delete</button>`;
                }
            },
        ]
    });
});


// post silmek için id'yi post ederek controller'a gönderiyorum.
$(document).on('click', '.deleteButton',function (){
    // console.log(1)
   let id = $(this).attr('id');
   let tr = $(this).closest('tr');

    $.ajax({
        url: `${url}/admin/blog-delete/`+ id,
        success: function (data){
            tr.remove();
            // window.location.href(`${url}/post-list`);
            // location.reload();
        },
        error: function() {
            alert("Something went wrong, please try again.");
        }
    });
});


function refresh(){
    setTimeout(function (){
        window.location.reload()
    },100);
    // alert("sayfa yenilendi");
}
