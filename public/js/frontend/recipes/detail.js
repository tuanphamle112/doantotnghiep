$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#commentform').submit(function(e) {     
        if ($('#comment').val().trim() == '') {
            $(this).find('.filling-error').addClass('active');
            return false;
        }

        var formdata = $(this).serializeArray();  
        var recipe_url = $(this).data('recipe');
        var userLink = $(this).data('user-link');
        formdata.push({ name: "userLink", value: userLink });
        e.preventDefault();
        $.ajax({
            url: recipe_url,
            type: "POST",
            data: formdata,
            success: function(response) {

                var appendElement = "<li class='comment clearfix'>" + 
                                        "<div class='avatar'>" +
                                            "<img alt='' src='" + response.avatar + "' class='avatar avatar-90 photo' height='90' width='90'>" +
                                        "</div>" +
                                        "<div class='comment-box'>" +
                                            "<div class='comment-author meta'>" +
                                                "<strong><a href='" + response.userLink + "' class='url'>" + response.name + "</a></strong><br>" +
                                                response.createAt +
                                                "<a class='comment-reply-link edit' href='#'>Edit</a>" +
                                                "<a class='comment-reply-link delete' href='#'>Delete</a>" + 
                                            "</div>" +
                                            "<div class='comment-text'>" +
                                                "<p>" + response.content + "</p>" +
                                            "</div>" +
                                        "</div>" +
                                    "</li>";
                $('.comment-list').append(appendElement);
                location.reload();
                $('#comment').val('');
                $('#commentform').find('.filling-error').removeClass('active');
            }
        });      
    }); 

    $('body').on('click', '.edit', function (e) {
        e.preventDefault();
        var oldContent = $(this).closest('.comment-box').find('.edit-comment-form textarea').val();
        $(this).parent('.wrap-comment-button').attr('style', 'display: none');
        $(this).parent('.wrap-comment-button').next('.wrap-open-edit').attr('style', 'display: block !important');
        $(this).closest('.comment-box').find('.edit-comment-form').attr('style', 'display: block !important');
        $(this).closest('.comment-box').find('.edit-comment-form textarea').focus().val('').val(oldContent);
        
        $(this).closest('.comment-box').find('.comment-view').attr('style', 'display: none !important');
    });

    $('body').on('click', '.save-comment', function (e) {
        e.preventDefault();
        $(this).closest('.comment-box').find('.edit-comment-form').submit();
    });

    $('#heart-link').on('click', function (e) {
        if (typeof $('input[name=user_id]').val() === 'undefined') {
            window.location.href = "/login";
        }
        $('#submit_heart').click();
       e.preventDefault()
    });

    $('#wishlist_form').on('submit', function(e){
        var formdata = $(this).serializeArray();  
        var wishlist_url = $(this).data('wishlist');
        var method = $(this).data('method');
        e.preventDefault();
        $.ajax({
            url: wishlist_url,
            type: method,
            data: formdata,
            success: function(response) {
                if (method == "POST")
                {
                    $('#heart-link .fa-heart').attr('style', 'color: red !important');
                } else {
                    $('#heart-link .fa-heart').attr('style', 'color: #fff !important');
                }
            }
        });  

    });
});
$('body').on('click', '.reply', function (e) {
    e.preventDefault();
    var commentOwner = $(this).data('owner-comment');
    var tagName = '@' + commentOwner + ' ';
    $('#comment').val(tagName);
    $('html, body').animate({
        scrollTop: $("#respond").offset().top
    }, 1000)
});

