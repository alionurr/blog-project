$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

// const url = "http://blog.oop";
// console.log(`${url}/post-list`);
// console.log(`${url}/admin/post-detail`);


// datatable datalarını alıyorum.
$(document).ready(function () {
    $('#datatable').DataTable({
        ajax: {
            'url': `/admin/blog-list`,
            'type': 'POST',
            'dataSrc': '',
        },
        columns: [
            {data: 'id'},
            {data: 'title',
                render: function (data, type, row){
                    return `<a href="/admin/blog-detail/${row.id}">${data}</a>`;
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
        url: `/admin/blog-delete/`+ id,
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

function saveComment (){
    let comment = $('#comment').val();
    let blogId = $('#blogId').val();
    let username = $('#username').val();
    if (comment !== "") {
        // console.log(comment);
        // console.log('/blog/'+blogId+'/add-comment');

        $.ajax({
            url: `/blog/`+ blogId +`/add-comment`,
            type: "POST",
            data: {
                'comment': comment,
                'username': username
            },
            success: function (result){
                $('#comment').val('');
                var result = JSON.parse(result);
                if(result.status === 'success'){
                    const commentTemplate =
                        '<div class="d-flex mb-3">' +
                            '<div class="flex-shrink-0">' +
                                '<img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..."/>' +
                            '</div>' +
                            '<div class="ms-3">' +
                                '<div class="fw-bold">'+ username + " - " + result.data.createdAt + '</div>' +
                                '<div class="text-break">'+comment+'</div>' +
                            '</div>' +
                        '</div>';
                    jQuery("#commentListArea").append(commentTemplate);
                }
            },
            error: function() {
                alert("Something went wrong, please try again.");
            }
        });
    }
}