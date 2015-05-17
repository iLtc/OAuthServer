$(".confirm").click(function(){
    if(!confirm($(this).data('confirm'))){
        return false;
    }
});
