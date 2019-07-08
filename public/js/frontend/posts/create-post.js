

$(document).ready(function() {

    $('#imgInp').change(function() {
        readURL(this);
        $('#img-upload').attr('style', 'width:100%;height:300px');
        $('.mainFileContainer').attr('style', 'border:1px solid #ccc');
        $('.mainFileContainer .main-pic').attr('style', 'font-size:16px;');
    }); 

    // read url main image
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img-upload').attr('src', e.target.result);
            }
                
            reader.readAsDataURL(input.files[0]);
        }
    }
});