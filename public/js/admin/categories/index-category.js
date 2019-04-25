$(document).ready( function() {
    if ($('#createCategory').find('.error-exist').length > 0) {
        $('.btn-insert').trigger( 'click');
    } 

    $('.refresh-page').on('click', function (){
        location.reload();
    });
});
