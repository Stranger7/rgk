$(function() {
    $('.preview').click(function() {
        event.preventDefault();
        $('#bookImageModal').modal('show');
        $('#bookImage').html('<img src="' + $(this).data('imageUrl') + '">');
    });

    // open modal and show book info
    $('.book-view').click(function() {
        event.preventDefault();
        $('#bookViewModal').modal('show');
        var container = $('#bookInfo');
        $.ajax({
            url      : $(this).data('viewUrl'),
            cache    : false,
            type     : 'GET',
            dataType : 'html',
            success  : function(data) {
                container.html(data);
                $('#bookThumb').click(function() {
                    event.preventDefault();
                    $('#bookImageModal').modal('show');
                    $('#bookImage').html('<img src="' + $(this).data('imageUrl') + '">');
                });
            },
            error    : function(data) {
                container.html(data.responseText);
            }
        });
    });

    // set reset handler
    $(".reset").click(function() {
        $("#booksearch-name, #booksearch-date_start, #booksearch-date_end, #booksearch-author_id").val('');
        $("#filter-form").submit();
    });
});