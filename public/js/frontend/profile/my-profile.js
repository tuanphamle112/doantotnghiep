$(document).ready( function() {
    $('#attachfile').on('click', function() {
        $('#edit_photo').trigger( 'click');
    });

    // tab profile
    function activeTab(obj) {
        var id = $(obj).find('a').attr('href');

        $('.item-list-tabs ul li').removeClass('selected');
        $(obj).addClass('selected');
        $('.tab-item').hide();
        $(id) .show();
    }
 
    $('.tab li').click(function(){
        activeTab(this);
        return false;
    });
    activeTab($('.tab li:first-child'));
    // end tab profile

    $('.wrap-update-user').on('submit', function (e){
        if ($('input[name="name"]').val().trim() == '') {
            e.preventDefault();
            $('.display-name .filling-error').addClass('active');
        }
    });
});

function readImage() {
    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
        var output = $(event.target).closest(".upload-avatar-form").find(".image-upload").find('.avatar-round');
        for (let i = 0; i < files.length; i++) {

            var file = files[i];

            if (!file.type.match('image')) continue;
            
            var picReader = new FileReader();
            
            picReader.addEventListener('load', function (event) {
                var picFile = event.target;
                output.attr('src', picFile.result);
            });
            
            picReader.readAsDataURL(file);
        }
    } else {
        console.log('Browser not support');
    }
}
