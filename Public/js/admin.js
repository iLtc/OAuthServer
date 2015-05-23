$(".confirm").click(function(){
    if(!confirm($(this).data('confirm'))){
        return false;
    }
});

$(".panel-body").css('display', 'none');
$(".panel-heading").click(function(){
    $(this).parent().children().last().slideToggle();

    window.location.hash = $(this).attr('id');
});

if(window.location.hash){
    $(window.location.hash).parent().children().last().css('display', 'block');
}