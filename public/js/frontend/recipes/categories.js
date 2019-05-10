$(document).ready(function(){
    $('#search').on('keyup',function(){
        $('.label-text').unhighlight();
        $('.label-text').highlight($(this).val()); 
    });        
});
