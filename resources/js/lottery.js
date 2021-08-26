$(document).ready(function () {
    var lottery_id = [];
    var avail_amount = 0;
    var game_id = 1;
    var amount = 0;
    var play;
    var filter_play;
    var total_play = 0;
    var total_amount = 0;
    var current_time_compare = '';
    var multi_select = false;
    var sms = false;
    var regex = /([0-9])\1{2,}/;
    var play_array = [];
    // time schedule -------------------------
    
    function schedule(){
        $('.lottery li').each(function(){
            let lottery_time = $(this).attr('time');
            if(current_time_compare > lottery_time){
                $(this).removeClass('lottery_active');
                $(this).addClass('lottery_disable');
            }else{
                $(this).removeClass('lottery_disable');
            }
        })
    }

    var myVar = setInterval(function() {
        myTimer();
    }, 1000);
      
    function myTimer() {
        current_time = new Date().toLocaleString("en-US", {timeZone: "America/New_York"});
        var d = new Date(current_time);
        document.getElementById("clock").innerHTML = d.toLocaleTimeString();
        let currentHours = d.getHours();
        let currentMinutes = d.getMinutes();
        let currentSeconds = d.getSeconds();
        currentHours = (currentHours < 10 ? "0" : "") + currentHours;
        currentMinutes = (currentMinutes < 10 ? "0" : "") + currentMinutes;
        currentSeconds = (currentSeconds < 10 ? "0" : "") + currentSeconds;
        current_time_compare = currentHours + ':' + currentMinutes + ':' + currentSeconds;
        schedule();
    }

    $('#myplay1').focus();
    var flag = [];
    for (let i = 1; i <= $('.lottery li').length; i++) {
        flag[i] = false;
    }

    $('.lottery li').click(function () {        
        if($(this).hasClass('lottery_disable')){
            return false;
        }else{
            if(!multi_select){
                lottery_id.length = 0;
                let id = Number($(this).attr('id'));
                lottery_id.push(id);
                $('.lottery li').removeClass('lottery_active');
                $(this).addClass('lottery_active');
            }else{
                let id = Number($(this).attr('id'));
                flag[id] = !flag[id];
                lottery_id.length = 0;
                for (let i = 1; i <= $('.lottery li').length; i++) {
                    if(flag[i] == true){
                        lottery_id.push(i);
                    }
                }
                if(flag[id]){
                    $(this).addClass('lottery_active');
                }else{
                    $(this).removeClass('lottery_active');
                }
            }
            
        }
        
    })

    // Multi-select -------------
    $(document).on('click','.multi_select', function (){
        multi_select = $('#multi_select').prop('checked');
        multi_select = !multi_select;
        $('.lottery li').removeClass('lottery_active');
        for (let i = 1; i <= $('.lottery li').length; i++) {
            flag[i] = false;
        }
        lottery_id.length = 0;
    })
    // SMS -----------------
    $(document).on('click','.sms', function (){
        sms = $('#sms').prop('checked');
        sms = !sms;
    })


    $('[id^=myplay]').keypress(validateNumber);

    $('#success').addClass('display-none');
    $('#warning').addClass('display-none');

    $('body').on('keyup', '#myplay1', function (e) {
        if (e.keyCode == 13 || e.keyCode == 109 || e.keyCode == 107 || e.keyCode == 110) {
            e.preventDefault();
            if ($(this).val().length <= 0) {
                $(this).focus();
                return false;
            } else {
                $('#myplay2').attr('readonly', 'readonly');
                $('#myplay2').focus();
            }
        }
    })


    $('#myplay2').focusin(function () {

        // $('.lottery li').each(function () {
        //     if ($(this).hasClass('lottery_active')) {
        //         lottery_id = $(this).attr('id');
        //         console.log(lottery_id)
        //     }
        // })
        if(lottery_id.length == 0){
            $('#warning').find('span').text('please select lottery.');
            $('#warning').removeClass('display-none');
            $(this).focusout();
            $('#myplay1').focus();
            setTimeout(function () {
                $('#warning').addClass('display-none');
            }, 2000);
            return false;
        }
        play = $('#myplay1').val();
        if (play.length <= 0 || !play) {
            $('#myplay1').focus();
            return false;
        }
        play.length = 0;
        if(!multi_select){
            let lottery_name =  $('.lottery li[id=' + lottery_id[0] + ']').text();
            let lottery_abbrev = $('.lottery li[id=' + lottery_id[0] + ']').attr('name');
            if(lottery_name == "FL Pick2 AM" || lottery_abbrev == "P2AM" || lottery_name == "FL Pick2 PM" || lottery_abbrev == "P2PM"){
                if(play.length != 2){
                        $('#warning').find('span').text('Invaild game for P2AM or P2PM');
                        $('#warning').removeClass('display-none');
                        $(this).focusout();
                        $('#myplay1').focus();
                        setTimeout(function () {
                            $('#warning').addClass('display-none');
                        }, 2000);
                        return false;
                }
            }
            if (play.indexOf('+') >= 0 || play.indexOf('-') >= 0 || play.indexOf('.') >= 0) {
                if(play.indexOf('.') == 2){
                    game_id = 1;
                    play = play.substr(0,2)
                    play_array = dot_check(play);
                    $('#avalable').val('X');
                    $('#myplay2').removeAttr('readonly');
                    $('#myplay2').select();
                    console.log(play_array)
                    return
                }
                if(play.indexOf('.') == 4){
                    game_id = 2;
                    play = play.substr(0,4)
                    play_array = dot_check(play);
                    $('#avalable').val('X');
                    $('#myplay2').removeAttr('readonly');
                    $('#myplay2').select();
                    return
                }
                if(play.indexOf('.') == 6){
                    game_id = 3;
                    play = play.substr(0,6)
                    play_array = dot_check(play);
                    $('#avalable').val('X');
                    $('#myplay2').removeAttr('readonly');
                    $('#myplay2').select();
                    return
                }
                if(play.indexOf('+') == 5){
                    game_id = 9;
                    filter_play = play.substr(0,5);
                    play = filter_play + 'B';
                    check_avail(lottery_id[0], game_id, play);
                    return
                }
                if (play.indexOf('+') == 4) {
                    game_id = 7;
                    filter_play = play.substr(0, 4);
                    play = filter_play + 'B';
                    check_avail(lottery_id[0], game_id, play);
                    return
                }
                if (play.indexOf('+') == 3) {
                    if(regex.test(play)){
                        game_id = 4;
                        filter_play = play.substr(0, 3);
                        play = filter_play + 'S';
                        check_avail(lottery_id[0], game_id, play);
                        return
                    }else{
                        game_id = 5;
                        filter_play = play.substr(0, 3);
                        play = filter_play + 'B';                    
                        check_avail(lottery_id[0], game_id, play);
                        return
                    }
                    
                }
                if(play.indexOf('-') == 5){
                    game_id = 8;
                    filter_play = play.substr(0,5);
                    play = filter_play + 'S';
                    check_avail(lottery_id[0], game_id, play);
                    return
                }
                if (play.indexOf('-') == 4) {
                    game_id = 6;
                    filter_play = play.substr(0, 4);
                    play = filter_play + 'S';
                    check_avail(lottery_id[0], game_id, play);
                    return
                } else {
                    $('#warning').find('span').text('Invaild Play');
                    $('#warning').removeClass('display-none');
                    $(this).focusout();
                    $('#myplay1').focus();

                    setTimeout(function () {
                        $('#warning').addClass('display-none');
                    }, 2000);
                    // return false;
                }
            } else {
                if (play.length == 2) {
                    game_id = 1;
                    filter_play = play;
                    check_avail(lottery_id[0], game_id, play);
                    return
                }
                if (play.length == 3) {
                    game_id = 4;
                    filter_play = play;
                    play = filter_play + 'S';
                    check_avail(lottery_id[0], game_id, play);
                    return
                }
                if (play.length == 4) {
                    game_id = 2;
                    let x = play.substr(0, 2);
                    let y = play.substr(2, 3);
                    filter_play = play;
                    play = x + '-' + y;
                    check_avail(lottery_id[0], game_id, play);
                    return
                }
                if (play.length == 6) {
                    game_id = 3;
                    let x = play.substr(0, 2);
                    let y = play.substr(2, 2);
                    let z = play.substr(4, 2);
                    filter_play = play;
                    play = x + '-' + y + '-' + z;
                    check_avail(lottery_id[0], game_id, play);
                    return
                } else {
                    $('#warning').find('span').text('Invaild Play1');
                    $('#warning').removeClass('display-none');
                    $(this).focusout();
                    $('#myplay1').focus();
                    setTimeout(function () {
                        $('#warning').addClass('display-none');
                    }, 2000);
                    // return false;
                }
            }
        }else{
            if(play.indexOf('.') == 2){
                game_id = 1;
                play = play.substr(0,2)
                play_array = dot_check(play);
                $('#avalable').val('X');
                $('#myplay2').removeAttr('readonly');
                $('#myplay2').select();
                return
            }
            let lottery_name = [];
            let lottery_abbrev = [];
            lottery_id.forEach(ele => {
                lottery_name.push($('.lottery li[id=' + ele + ']').text());
                lottery_abbrev.push($('.lottery li[id=' + ele + ']').attr('name'));
            });
            let lottery_length = lottery_id.length;
            let j = 0;
            for (let i = 0; i < lottery_length; i++) {
                if (lottery_name[i] == 'FL Pick2 AM' || lottery_abbrev[i] == 'P2AM' || lottery_name[i] == 'FL Pick2 PM' || lottery_abbrev[i] == 'P2PM') {
                    if (play.length != 2) {
                        $('#warning').find('span').text('Invaild play for P2AM or P2PM');
                        $('#warning').removeClass('display-none');
                        setTimeout(function () {
                            $('#warning').addClass('display-none');
                        }, 2000);
                        $('.lottery li[id=' + lottery_id[i-j] + ']').removeClass('lottery_active');
                        flag[lottery_id[i-j]] = false;
                        lottery_id.splice(i-j,1);
                        j++
                    }
                }                
            }
            if (play.indexOf('+') >= 0 || play.indexOf('-') >= 0 || play.indexOf('.') >= 0){
                
                if(play.indexOf('.') == 4){
                    game_id = 2;
                    play = play.substr(0,4)
                    play_array = dot_check(play);
                    $('#avalable').val('X');
                    $('#myplay2').removeAttr('readonly');
                    $('#myplay2').select();
                    return
                }
                if(play.indexOf('.') == 6){
                    game_id = 3;
                    play = play.substr(0,6)
                    play_array = dot_check(play);
                    $('#avalable').val('X');
                    $('#myplay2').removeAttr('readonly');
                    $('#myplay2').select();
                    return
                }
                if(play.indexOf('+') == 5){
                    game_id = 9;
                    filter_play = play.substr(0,5);
                    play = filter_play + 'B';
                    check_avail_multi(lottery_id, game_id, play);
                    return
                }
                if (play.indexOf('+') == 4) {
                    game_id = 7;
                    filter_play = play.substr(0, 4);
                    play = filter_play + 'B';

                    check_avail_multi(lottery_id, game_id, play);
                    return
                }
                if (play.indexOf('+') == 3) {
                    if(regex.test(play)){
                        game_id = 4;
                        filter_play = play.substr(0, 3);
                        play = filter_play + 'S';
                        check_avail_multi(lottery_id, game_id, play);
                        return
                    }else{
                        game_id = 5;
                        filter_play = play.substr(0, 3);
                        play = filter_play + 'B';                    
                        check_avail_multi(lottery_id, game_id, play);
                        return
                    }
                    
                }
                if(play.indexOf('-') == 5){
                    game_id = 8;
                    filter_play = play.substr(0,5);
                    play = filter_play + 'S';
                    check_avail_multi(lottery_id, game_id, play);
                    return
                }
                if (play.indexOf('-') == 4) {
                    game_id = 6;
                    filter_play = play.substr(0, 4);
                    play = filter_play + 'S';
                    check_avail_multi(lottery_id, game_id, play);
                    return
                } else {
                    $('#warning').find('span').text('Invaild Play');
                    $('#warning').removeClass('display-none');
                    $(this).focusout();
                    $('#myplay1').focus();

                    setTimeout(function () {
                        $('#warning').addClass('display-none');
                    }, 2000);
                    // return false;
                }
            } else {
                if (play.length == 2) {
                    game_id = 1;
                    filter_play = play;
                    check_avail_multi(lottery_id, game_id, play);
                    return
                }
                if (play.length == 3) {
                    game_id = 4;
                    filter_play = play;
                    play = filter_play + 'S';
                    check_avail_multi(lottery_id, game_id, play);
                    return
                }
                if (play.length == 4) {
                    game_id = 2;
                    let x = play.substr(0, 2);
                    let y = play.substr(2, 3);
                    filter_play = play;
                    play = x + '-' + y;
                    check_avail_multi(lottery_id, game_id, play);
                    return
                }
                if (play.length == 6) {
                    game_id = 3;
                    let x = play.substr(0, 2);
                    let y = play.substr(2, 2);
                    let z = play.substr(4, 2);
                    filter_play = play;
                    play = x + '-' + y + '-' + z;
                    check_avail_multi(lottery_id, game_id, play);
                    return
                } else {
                    $('#warning').find('span').text('Invaild Play');
                    $('#warning').removeClass('display-none');
                    $(this).focusout();
                    $('#myplay1').focus();
                    setTimeout(function () {
                        $('#warning').addClass('display-none');
                    }, 2000);
                    // return false;
                }
            }
        }

    })

    $('body').on('keyup', '#myplay2', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            if($('#avalable').val() == 'X'){

                amount = Number($(this).val());
                $(this).val('');
                $('#avalable').val('');
                if (!amount) {
                    $(this).focus();
                    return false
                }

                if(play_array.length > 0){
                    let temp_amount = 0;
                    let html = ``;
                    lottery_id.forEach(ele => {
                        let lottery_name = $('#' + ele).attr('name');
                        play_array.forEach(ply => {
                            html += `<tr>
                                    <td name="${ele}">${lottery_name}</td>
                                    <td name="${game_id}">${ply}</td>
                                    <td name="${ply}">${amount}</td>
                                    <td name="${amount}"><i class='fa fa-trash remove_this' style="color:red;"></i></td>
                                </tr>`
                            temp_amount += Number(amount);
                        })
                    })
                    total_play += 1;
                    total_amount += Number(temp_amount);
                    $('#total_play').val(total_play);
                    $('#total_amount').val(total_amount);
                    if (game_id == 1) {
                        $('#playsTableBodyDirecto').prepend(html);
                        let sub_total = $('.table_total1 ').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total1').text(sub_total);
                    } else if (game_id == 2 || game_id == 3) {
                        $('#playsTableBodyPale').prepend(html);
                        let sub_total = $('.table_total2').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total2').text(sub_total);
                    } else if (game_id == 4 || game_id == 5) {
                        $('#playsTableBodyCash').prepend(html);
                        let sub_total = $('.table_total3').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total3').text(sub_total);
                    } else if (game_id == 6 || game_id == 7) {
                        $('#playsTableBodyPick').prepend(html);
                        let sub_total = $('.table_total4').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total4').text(sub_total);
                    }else if (game_id == 8 || game_id == 9) {
                        $('#playsTableBodyPick').prepend(html);
                        let sub_total = $('.table_total4').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total4').text(sub_total);
                    }

                    $('#myplay1').val('');
                    $('#myplay1').focus();
                }else{
                    return false;
                }

            }else{
                avail_amount = Number($('#avalable').val());
                if (!avail_amount) {
                    $('#myplay1').select();
                    return
                }
                amount = Number($(this).val());
                $(this).val('');
                $('#avalable').val('');
                if (!amount) {
                    $(this).focus();
                    return false
                }
                if (amount > avail_amount) {
                    $('#warning').find('span').text('Invaild Input');
                    $('#warning').removeClass('display-none');
                    setTimeout(function () {
                        $('#warning').addClass('display-none');
                    }, 2000);
                    $('#myplay2').focus();
                } else {
                    let temp_amount = 0;
                    let html = ``;
                    lottery_id.forEach(ele => {
                        let lottery_name = $('#' + ele).attr('name');
                        html += `<tr>
                                    <td name="${ele}">${lottery_name}</td>
                                    <td name="${game_id}">${play}</td>
                                    <td name="${play}">${amount}</td>
                                    <td name="${amount}"><i class='fa fa-trash remove_this' style="color:red;"></i></td>
                                </tr>`
                        temp_amount += Number(amount);
                    });                    
                    total_play += 1;
                    total_amount += Number(temp_amount);
                    $('#total_play').val(total_play);
                    $('#total_amount').val(total_amount);
                    if (game_id == 1) {
                        $('#playsTableBodyDirecto').prepend(html);
                        let sub_total = $('.table_total1 ').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total1').text(sub_total);
                    } else if (game_id == 2 || game_id == 3) {
                        $('#playsTableBodyPale').prepend(html);
                        let sub_total = $('.table_total2').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total2').text(sub_total);
                    } else if (game_id == 4 || game_id == 5) {
                        $('#playsTableBodyCash').prepend(html);
                        let sub_total = $('.table_total3').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total3').text(sub_total);
                    } else if (game_id == 6 || game_id == 7) {
                        $('#playsTableBodyPick').prepend(html);
                        let sub_total = $('.table_total4').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total4').text(sub_total);
                    }else if (game_id == 8 || game_id == 9) {
                        $('#playsTableBodyPick').prepend(html);
                        let sub_total = $('.table_total4').text();
                        sub_total = Number(sub_total) + Number(temp_amount);
                        $('.table_total4').text(sub_total);
                    }

                    $('#myplay1').val('');
                    $('#myplay1').focus();
                }
            }
        }
    })

    $(document).on('click', '.remove_this', function () {
        let total = $(this).parents('div.ticket-info-container').children('.lottery-table-footer').find('span').text();
        let value = $(this).parent().parent().children('td').eq(2).text();
        total = total - value;
        total_amount -= value;
        $('#total_amount').val(total_amount);
        $(this).parents('div.ticket-info-container').children('.lottery-table-footer').find('span').text(total);
        $(this).parent().parent().remove();

    })

    $('body').on('keyup', function (e) {
        if (e.keyCode == 106) {
            $("#create_ticket").click();
        }
    })

    $("#create_ticket").click(function () {

        var post_data = {};
        var print_data = [];
        var t_tr = $('.table_row').find('tbody tr');
        for (let i = 0; i < t_tr.length; i++) {
            var txt = "";
            var t_td = $(t_tr[i]).find('td');
            for (let j = 0; j < t_td.length; j++) {
                txt += $(t_td[j]).attr('name') + ",";
            }
            post_data[i] = txt;
            print_data.push(txt);
        }
        if (print_data.length == 0) {
            return false;
        }
        $.ajax({
            url: '/create-ticket',
            data: post_data,
            dataType: 'json',
            type: 'get',
            success: function (data) {
                if (data != 'fail') {
                    var date = data.date;
                    var ticket_id = data.ticket_id;
                    var display_ticket = ticket_id + ' - ' + '$' + total_amount;
                    var print_ticket_id = '001 - ' + data.name + ' - ' + ticket_id;
                    var html = `<option value="${ticket_id}">${display_ticket}</option>`
                    $('#tickets').prepend(html);
                    $('.balance span').text(data.balance);
                    $('#ticket_result .print-container div.logo-text p').text(date);
                    $('#ticket_result .print-container div.ticket-info p.fecha span').text(date);
                    $('#ticket_result .print-container div.ticket-info p:first').text(print_ticket_id);
                    $('#ticket_result .print-container div.ticket-info h3').text(data.bar_code);
                    // $('.total_display span').text(total_amount+'.00');

                    $('.ticket-detail').empty();
                    draw_table(print_data, 'create');

                    printJS({
                        printable: 'ticket_result',
                        type: 'html',
                        targetStyles: ['*'],
                        documentTitle: 'Vender tickets'
                    })

                    $('#playsTableBodyDirecto').empty();
                    $('#playsTableBodyPale').empty();
                    $('#playsTableBodyCash').empty();
                    $('#playsTableBodyPick').empty();

                    $('.table_total1').text('0')
                    $('.table_total2').text('0')
                    $('.table_total3').text('0')
                    $('.table_total4').text('0')
                    total_amount = 0;
                    total_play = 0;
                    $('#total_play').val('');
                    $('#total_amount').val('');
                }
            }
        })
    })


    $('#ticket_delete').click(function () {
        let ticket_id = $('#tickets').val();
        $('#tickets option[value='+ticket_id+']').remove();
        if (ticket_id) {
            $.ajax({
                url: '/delete-ticket',
                data: { ticket_id: ticket_id },
                type: 'get',
                success: function (data) {
                    $('#ticket_cancel .ticket-detail').empty();
                    let date = data.pop();
                    let balance = data.pop();
                    let name = data.pop();
                    let bar_code = data.pop();
                    var print_ticket_id = '001 - ' + name + ' - ' + ticket_id;
                    $('#ticket_cancel .print-container div.ticket-info h3').text(bar_code);
                    $('#ticket_cancel .print-container div.ticket-info p:first').text(print_ticket_id);
                    $('.balance span').text(balance);
                    $('#ticket_cancel .logo-text p').text(date);
                    $('#ticket_cancel .fecha span').text(date);
                    draw_table(data, 'cancel');
                    printJS({
                        printable: 'ticket_cancel',
                        type: 'html',
                        targetStyles: ['*'],
                        documentTitle: 'Vender tickets'
                    })
                }
            })
        }
    })

    $('#ticket_copy').click(function(){
        let ticket_id = $('#tickets').val();
        if (ticket_id) {
            $.ajax({
                url: '/delete-ticket',
                data: { ticket_id: ticket_id,copy:1 },
                type: 'get',
                success: function (data) {
                    $('#ticket_result .ticket-detail').empty();
                    let date = data.pop();
                    let ticket_id = data.pop();
                    let name = data.pop();
                    var print_ticket_id = '001 - ' + name + ' - ' + ticket_id;
                    $('#ticket_result h1.origin').html('**&nbsp;&nbsp; COPIED &nbsp;&nbsp;**');
                    $('#ticket_result .logo-text p').text(date);
                    $('#ticket_result .fecha span').text(date);
                    $('#ticket_result .print-container div.ticket-info p:first').text(print_ticket_id);
                    $('#ticket_result .print-container div.ticket-info h3').empty();
                    draw_table(data, 'cancel');
                    printJS({
                        printable: 'ticket_result',
                        type: 'html',
                        targetStyles: ['*'],
                        documentTitle: 'Vender tickets'
                    })
                }
            })
        }
    })

    $('#mark_modal .ticket_mark_result').addClass('display-none');

    $('#pagar').click(function(){
        $('#mark_modal').modal({backdrop: "static"});
    })
    $("#mark_modal").on('hidden.bs.modal', function(){
        location.reload();
    });
    $('.mark_submit').click(function(){
        // let ticket_id = $(this).attr('id');
        let code = $('#code').val();
        let temp_barcode = $('#temp_barcode').val();
        let data;
        if(!code){
            $('#code-require-error').addClass('display-show');
            return false;
        }
        if(code == temp_barcode){
            data = {code:code,is_paid:1};
        }else{
            data = {code:code}
        }
        $.ajax({
            url:'ticket-mark',
            data:data,
            type:'get',
            success:function(data){
                if(data == 'no'){
                    $('.error').removeClass('display-show');
                    $('#code-invalid-error').addClass('display-show');
                }else if(data == 'ok'){
                    swal({
                        title: "Success",
                        text: "Successful paid.",
                        icon: "success",
                        button: "OK",
                    }).then(()=>{
                        location.reload();
                    });
                }else if(data == 'already'){
                    alert('The ticket is not a winning ticket or has already been paid.');
                }else{
                    $('#temp_barcode').val(data.bar_code);
                    $('.mark_result').empty();
                    let amount = 0;
                    let prize = 0;
                    let pending_flag = 0;
                    $('.ticket_mark_result').removeClass('display-none');
                    let name = $('.name').text();
                    name = name + '-' + data.id;
                    $('.ticket_mark_result h5 span').text(name);
                    data.details.forEach(detail => {
                        amount += detail.amount;
                        if(detail.is_win == 1){
                            prize += Number(detail.prize);
                        }
                    });
                    $('.ticket_mark_result .amount').text(amount);
                    if(data.is_pending == 1){
                        $('.ticket_mark_result .pending_payment').text(prize);
                    }
                    if(data.is_pending == 2){
                        pending_flag = 1;
                    }
                    let lottery_length = $('.lottery li').length;

                    var details = data['details'];
                    for(let j=1;j<=lottery_length;j++){
                        var temp = 0;
                        var txt = "";
                        for(let i=0;i<details.length;i++){
                            
                            if(details[i]['lottery_id'] == j){
                                if(temp == 0){
                                    temp = 1;
                                    txt += "<tr>"+"<td colspan='5'>"+ $('.lottery li[id=' + j + ']').text() +"</td>"+"</tr>";
                                    if(details[i]['is_win'] == 1){
                                        txt += '<tr class="winning-play">';
                                    }
                                    if(details[i]['is_win'] == 0){
                                        txt += '<tr class="losing-play">';
                                    }
                                    
                                    txt += '<td>'+details[i]['number']+'</td>';
                                    txt += '<td>'+$('.game li[id=' + details[i]['game_id'] + ']').text()+'</td>';
                                    txt += '<td>'+details[i]['amount']+'</td>';
                                    txt += '<td>'+details[i]['prize']+'</td>';
                                    if(pending_flag && details[i]['is_win'] == 1){
                                        txt += '<td style="color:blue;">paid</td>';
                                    }else if(!pending_flag && details[i]['is_win'] == 1){
                                        txt += '<td style="color:red;">pending</td>';
                                    }else{
                                        txt += '<td></td>'
                                    }
                                    
                                    txt += '</tr>';
                                } else {
                                    if(details[i]['is_win'] == 1){
                                        txt += '<tr class="winning-play">';
                                    }
                                    if(details[i]['is_win'] == 0){
                                        txt += '<tr class="losing-play">';
                                    }
                                    txt += '<td>'+details[i]['number']+'</td>';
                                    txt += '<td>'+$('.game li[id=' + details[i]['game_id'] + ']').text()+'</td>';
                                    txt += '<td>'+details[i]['amount']+'</td>';
                                    txt += '<td>'+details[i]['prize']+'</td>';
                                    if(pending_flag && details[i]['is_win'] == 1){
                                        txt += '<td style="color:blue;">paid</td>';
                                    }else if(!pending_flag && details[i]['is_win'] == 1){
                                        txt += '<td style="color:red;">pending</td>';
                                    }else{
                                        txt += '<td></td>'
                                    }
                                    txt += '</tr>';
                                }
                                
                            }
                        }

                        $('.mark_result').append(txt);
                    }
                    
                }
            }
        })
    })

    $('#duplicate').click(function(){
        $('#duplicate_modal').modal({backdrop: "static"});
        $('#ticket_number').focus();
    })
    // $("#duplicate_modal").on('hidden.bs.modal', function(){
    //     location.reload();
    // });

    $('.duplicate_lottery').addClass('display-none');

    var duplicate_data = [];
    $('.duplicate_submit').click(function(){
        let ticket_number = $('#ticket_number').val();
        let temp_barcode = $('#temp_barcode2').val();
        if(temp_barcode && duplicate_data.length > 0 && ticket_number == temp_barcode){
            let lottery_length = $('#duplicate_modal .duplicate_result .one_lottery').length;
            $('#duplicate_modal .duplicate_result .one_lottery').each(function(){
                let from_id = $(this).find('label').attr('temp_id')
                let to_id = $(this).find('select').val();
                if(from_id && to_id){
                    let html = ``;
                    duplicate_data.forEach(ele => {
                        if(from_id == ele.lottery_id){
                            let lottery_name = $('#' + to_id).attr('name');
                            html = `<tr>
                                <td name="${to_id}">${lottery_name}</td>
                                <td name="${ele.game_id}">${ele.number}</td>
                                <td name="${ele.number}">${ele.amount}</td>
                                <td name="${ele.amount}"><i class='fa fa-trash remove_this' style="color:red;"></i></td>
                            </tr>`
                            if (ele.game_id == 1) {
                                $('#playsTableBodyDirecto').prepend(html);
                                let sub_total = $('.table_total1 ').text();
                                sub_total = Number(sub_total) + Number(ele.amount);
                                $('.table_total1').text(sub_total);
                            } else if (ele.game_id == 2 || ele.game_id == 3) {
                                $('#playsTableBodyPale').prepend(html);
                                let sub_total = $('.table_total2').text();
                                sub_total = Number(sub_total) + Number(ele.amount);
                                $('.table_total2').text(sub_total);
                            } else if (ele.game_id == 4 || ele.game_id == 5) {
                                $('#playsTableBodyCash').prepend(html);
                                let sub_total = $('.table_total3').text();
                                sub_total = Number(sub_total) + Number(ele.amount);
                                $('.table_total3').text(sub_total);
                            } else if (ele.game_id == 6 || ele.game_id == 7) {
                                $('#playsTableBodyPick').prepend(html);
                                let sub_total = $('.table_total4').text();
                                sub_total = Number(sub_total) + Number(ele.amount);
                                $('.table_total4').text(sub_total);
                            }
                        }
                    });
                    
                }

            })
            
            return false;
        }
        if(!ticket_number){
            $('#ticket_number-require-error').addClass('display-show');
            return false;
        }

        $.ajax({
            url:'duplicate',
            data:{bar_code:ticket_number},
            type:'get',
            success:function(data){
                if(data == 'no'){
                    $('.duplicate_lottery').addClass('display-none');
                    $('.duplicate_result').empty();
                    $('.error').removeClass('display-show');
                    $('#ticket_number-invalid-error').addClass('display-show');
                }else{
                    duplicate_data = data.details;
                    $('#temp_barcode2').val(data.bar_code);
                    $('.duplicate_result').empty();
                    $('.duplicate_lottery').removeClass('display-none');
                    $('.error').removeClass('display-show');
                    var details = data['details'];
                    let lottery_length = $('.lottery li').length;
                    for(let j=1;j<=lottery_length;j++){
                        var temp = 0;
                        var txt = ``;
                        for (let i = 0; i < details.length; i++) {
                            if(details[i]['lottery_id'] == j){
                                if(temp == 0){
                                    temp = 1;
                                    txt += `
                                        <div class="one_lottery clearfix mb-3">
                                            <label for="lottery_array" temp_id="${j}" class="float-left">${$('.lottery li[id=' + j + ']').text()}</label>
                                            
                                        </div>
                                    `
                                } else {

                                }
                                
                            }
                        }

                        $('.duplicate_result').append(txt);
                            
                    }

                    var items = $(".one_lottery");
                    let clone_lottery = $('#lottery_clone').clone().removeAttr('id');
                    clone_lottery.removeClass('display-none');
                    // for(let i=0;i<items.length)
                    items.append(clone_lottery);
                }
            }
        })
    })

})

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keycode === 13 || event.keyCode === 46) {
        return true;
    } else if (event.keyCode == 43 || event.keyCode == 45) {
        return true;
    } else if (key < 48 || key > 57) {
        return false;
    }
    else {
        return true;
    }
}

function check_avail(lottery_id, game_id, play) {
    $.ajax({
        url: 'check-avail',
        data: { lottery_id: lottery_id, game_id: game_id, play: play },
        type: 'get',
        success: function (data) {
            if (data.error) {
                $('#warning').find('span').text(data.content);
                $('#warning').removeClass('display-none');
                setTimeout(function () {
                    $('#warning').addClass('display-none');
                }, 2000);
                $('#myplay1').focus();
            } else {
                $('#avalable').val(data);
                $('#myplay2').removeAttr('readonly');
                $('#myplay2').select();
            }
        }
    })
}

function check_avail_multi(lottery_id,game_id,play){
    let lottery_id_string = lottery_id.join(',');
    let data = {lottery_id:lottery_id_string,game_id:game_id,play:play}
    $.ajax({
        url:'check-avail-multi',
        data:data,
        type:'get',
        success:function(data){
            $('#avalable').val(data);
            $('#myplay2').removeAttr('readonly');
            $('#myplay2').select();
        }
    })
}

function draw_table(print_data, tag) {

    var total_price = 0;
    let lottery_length = $('.lottery li').length;
    for (let i = 1; i <= lottery_length; i++) {
        var cl = $('.clone').clone().removeClass('clone');
        var temp = 0;
        var key = 0;
        var txt = "";
        for (let j = 0; j < print_data.length; j++) {
            var row_data = print_data[j].split(',');
            var sub_price = 0;
            if (row_data[0] == i) {
                if (temp == 0) {
                    temp = 1;
                    cl.css('display', 'block');
                    cl.attr('id', tag + 'item-' + i);
                    cl.find(".table_title .title").first().text($('.lottery li[id=' + i + ']').text() + " : ")
                    $('.ticket-detail').append(cl);
                    if (key == 0) {
                        txt += "<tr>";
                    }
                    key++;
                    if (key == 3) {
                        txt += "</tr><tr>";
                        key = 1;
                    }
                    txt += "<td>" + row_data[2] + "</td>";
                    txt += "<td>" + row_data[3] + "</td>";
                    $('#' + tag + 'item-' + i + ' .price').text(row_data[3]);

                } else {
                    if (key == 0) {
                        txt += "<tr>";
                    }
                    key++;
                    if (key == 3) {
                        txt += "</tr><tr>";
                        key = 1;
                    }
                    txt += "<td>" + row_data[2] + "</td>";
                    txt += "<td>" + row_data[3] + "</td>";
                    var price = Number($('#' + tag + 'item-' + i + ' .price').first().text()) + Number(row_data[3]);
                    $('#' + tag + 'item-' + i + ' .price').text(price);

                }

                total_price = Number(total_price) + Number(row_data[3]);


            }
        }
        if (temp == 1) {
            txt += "</tr>";
            $('#' + tag + 'item-' + i + ' tbody').append(txt);
        }

    }

    $('.total_display span').text(total_price.toFixed(2));

}

function dot_check(data){
    let result = [];
    if(data.length == 6){
        let aa = data.substr(0,2);
        let bb = data.substr(2,2);
        let cc = data.substr(4,2);            
        for(var ii = 0;ii< 8;ii++)
        {
            let x1 = Math.floor(ii/4);
            let y1 = Math.floor((ii-x1*4)/2);
            let z1 = ii - x1*4-y1*2;
            result.push(swap(aa,x1)+'-'+swap(bb,y1)+'-'+swap(cc,z1));
        }
        return unique_value(result);
    }else if(data.length == 4){
        let aa = data.substr(0,2);
        let bb = data.substr(2,2);
        for (let ii = 0; ii < 4; ii++) {
            let x1 = Math.floor(ii/2);
            let y1 = Math.floor(ii-x1*2);
            result.push(swap(aa,x1)+'-'+swap(bb,y1));
        }
        return unique_value(result);
    }else if(data.length == 2){
        result.push(data);
        result.push(swap(data,1));
        return unique_value(result);
    }
}

function swap(x, y){
    if(y==0)
    return x;
    else if(y==1)
    {
        let ss = x.split('');
        let tt = ss.shift();
        ss.push(tt);
        let temp = ss.join('');
        return temp;
    }
}

function unique_value(data)
{
    let unique = [];
    $.each(data, function(i, el){
        if($.inArray(el, unique) === -1) unique.push(el);
    });
    return unique;
}