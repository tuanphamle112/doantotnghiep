$(document).ready( function() {
    if ($('#createGift').find('.error-exist').length > 0) {
        $('.btn-insert').trigger( 'click');
    } 
    $('.image-gift').addClass('img-enlargable').click(function(){
        var src = $(this).attr('src');
        $('<div>').css({
            background: 'RGBA(0,0,0,.5) url('+src+') no-repeat center',
            backgroundSize: '600px 600px',
            width:'100%', height:'100%',
            position:'fixed',
            zIndex:'10000',
            top:'0', left:'0',
            cursor: 'zoom-out'
        }).click(function(){
            $(this).remove();
        }).appendTo('body');
    });

    $('.change-status').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        var message = $(this).data('text')

        if (confirm(message)) {
            // Post the form
            $(e.target).closest('.wrap-status-form').find('.change-status-form').submit()
        }
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

