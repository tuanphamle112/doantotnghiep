$(document).ready(function() {

    $('body').on('click', '.nav-search', function (e){
        var tabArray = ['tab1', 'tab2'];
        var tab = $(e.target).data('tab');
        tabArray.splice( tabArray.indexOf(tab), 1 );
        var tabRest = tabArray.toString()

        $(e.target).parent().removeClass('active');
        $(e.target).parent().addClass('active');
        $(e.target).parent().siblings('.nav-search').removeClass('active');
        
        $('#'+ tab).attr('style', 'display: block !important');
        $('#'+ tabRest).attr('style', 'display: none !important');
    });
});