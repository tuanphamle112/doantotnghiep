$(document).ready( function() {
    if ($('#createCategory').find('.error-exist').length > 0) {
        $('.btn-insert').trigger( 'click');
    } 

    $('.refresh-page').on('click', function (){
        location.reload();
    });
});

function readImage() {
    var num = 1;

    if (window.File && window.FileList && window.FileReader) {
        var files = event.target.files; //FileList object
        var output = $(event.target).closest(".wrap-upload-image").find(".preview-images-zone");
        output.html("");
        for (let i = 0; i < files.length; i++) {

            var file = files[i];

            if (!file.type.match('image')) continue;
            
            var picReader = new FileReader();
            
            picReader.addEventListener('load', function (event) {
                var picFile = event.target;
                
                var img = '<img id="img-cate" src="' + picFile.result + '">'
                output.html(img);
            });
            
            picReader.readAsDataURL(file);
            $('.wrap-preview').attr('style', 'display:block;');
        }
        $("#pro-image").val('');
    } else {
        console.log('Browser not support');
    }
}
