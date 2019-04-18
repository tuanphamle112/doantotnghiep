$(document).ready( function() {
    if ($('#createUser').find('.error-exist').length > 0) {
        $('.btn-insert').trigger( 'click');
    } 
});
