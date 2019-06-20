$(document).ready(function(){
    $('.lottery li').addClass('lottery_disable');
    $('.lottery li:first').removeClass('lottery_disable').addClass('lottery_active');
    $('.lottery li').click(function(){
        $('.lottery li').removeClass('lottery_active').addClass('lottery_disable');
        $(this).removeClass('lottery_disable').addClass('lottery_active');
    })
})