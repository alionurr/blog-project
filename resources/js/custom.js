const url = "http://blog.ide/";

$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});

$(document).ready( function () {
    $('#table').DataTable({
        'ajax' : {
            'url' : `${url}/views/admin/blog_list.php`,
            // 'url' : '../../views/blog_list.php',
            'dataSrc' : '',
        },
        'columns' : [
            { data: 'id'},
            {
                data: 'title',
                render: function (data, type, row) {
                    return '<a href="/views/admin/post_detail.php?id='+row.id+'">'+data+'</a>';
                }
            },
            { data: 'author' },
            { data: 'excerpt' },
            { data: 'status' },
            { data: 'category' },
            {
                data: 'id',
                render: function (data)  {
                    return `
                            <div class="input-group" style="display: flex;justify-content: center">
                            <!--<a class="btn btn-sm btn-primary mr-2" href="/views/post_detail.php?id=${data}">View</a> -->
                            <form action="../../controller/admin/index.php" method="post">
                                <input type="hidden" name="id" value="${data}">
                                <button type="submit" class="btn btn-sm btn-danger" name="deleteButton">Delete</button>
                            </form>                  
                            </div>   
                    `;
                }
            },
        ]
    });
});