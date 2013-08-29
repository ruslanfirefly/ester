$(document).ready(function(){
    //модалка для входа в систему
    $('#loginModal').modal("show");
    // все тултипы в системе
    $("body").on("mouseenter","*[data-toggle=tooltip]",function(){
        $(this).tooltip('show');
    });
    $("body").on("mouseleave","*[data-toggle=tooltip]",function(){
        $(this).tooltip('hide');
    });

})
