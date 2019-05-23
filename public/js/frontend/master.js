$(document).ready( function() {

    var toastrSessionData = $('.toastr-session').data('session')
    var toastrSessionArray = toastrSessionData.split(',')
    //toastr js notification
    if (toastrSessionArray[0] == 1) {
        var type = toastrSessionArray[1]

        switch(type) {
            case 'info':
                toastr.info(toastrSessionArray[2], 'Infor Alert', {timeOut: 8000});
                break;
            
            case 'warning':
                toastr.warning(toastrSessionArray[2], 'Warning Alert', {timeOut: 8000});
                break;
    
            case 'success':
                toastr.success(toastrSessionArray[2], 'Success Alert', {timeOut: 8000});
                break;
    
            case 'error':
                toastr.error(toastrSessionArray[2], 'Error Alert', {timeOut: 8000});
                break;
        }
    }

    $('.delete').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        var message = $(this).data('text')

        if (confirm(message)) {
            // Post the form
            $(e.target).closest('.wrap-delete-form').find('.delete-form').submit()
        }
    });
    
});
