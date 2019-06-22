$(document).ready(function() {
    $('.change-status').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        var message = $(this).data('text')

        if (confirm(message)) {
            // Post the form
            $(e.target).closest('.wrap-status-form').find('.change-status-form').submit()
        }
    });
});