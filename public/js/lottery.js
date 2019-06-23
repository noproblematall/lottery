$(document).ready(function () {
    var lottery_id = 1;
    var avail_amount = 0;
    var game_id = 1;
    var amount = 0;
    var play;
    var filter_play;
    var total_play = 0;
    var total_amount = 0;

    $('#myplay1').focus();

    $('.lottery li').addClass('lottery_disable');
    $('.lottery li:first').removeClass('lottery_disable').addClass('lottery_active');
    $('.lottery li').click(function () {
        $('.lottery li').removeClass('lottery_active').addClass('lottery_disable');
        $(this).removeClass('lottery_disable').addClass('lottery_active');
    })

    $('[id^=myplay]').keypress(validateNumber);

    $('#success').addClass('display-none');
    $('#warning').addClass('display-none');

    $('body').on('keyup', '#myplay1', function (e) {
        if (e.keyCode == 13 || e.keyCode == 109 || e.keyCode == 107) {
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

        $('.lottery li').each(function () {
            if ($(this).hasClass('lottery_active')) {
                lottery_id = $(this).attr('id');
            }
        })
        play = $('#myplay1').val();
        if (play.length <= 0 || !play) {
            $('#myplay1').focus();
            return false;
        }

        if (play.indexOf('+') >= 0 || play.indexOf('-') >= 0) {
            if (play.indexOf('+') == 4) {
                game_id = 7;
                filter_play = play.substr(0, 4);
                play = filter_play + 'B';

                check_avail(lottery_id, game_id, filter_play);
                return
            }
            if (play.indexOf('+') == 3) {
                game_id = 5;
                filter_play = play.substr(0, 3);
                play = filter_play + 'B';
                console.log(filter_play);
                console.log(play);
                check_avail(lottery_id, game_id, filter_play);
                return
            }
            if (play.indexOf('-') == 4) {
                game_id = 6;
                filter_play = play.substr(0, 4);
                play = filter_play + 'S';
                check_avail(lottery_id, game_id, filter_play);
                return
            } else {
                $('#warning').find('span').text('Invaild Play');
                $('#warning').removeClass('display-none');
                $(this).focusout();
                $('#myplay1').focus();
                console.log(234)

                setTimeout(function () {
                    $('#warning').addClass('display-none');
                }, 2000);
                // return false;
            }
        } else {
            if (play.length == 2) {
                game_id = 1;
                filter_play = play;
                check_avail(lottery_id, game_id, filter_play);
                return
            }
            if (play.length == 3) {
                game_id = 4;
                filter_play = play;
                play = filter_play + 'S';
                check_avail(lottery_id, game_id, filter_play);
                return
            }
            if (play.length == 4) {
                game_id = 2;
                let x = play.substr(0, 2);
                let y = play.substr(2, 3);
                filter_play = play;
                play = x + '-' + y;
                check_avail(lottery_id, game_id, filter_play);
                return
            }
            if (play.length == 6) {
                game_id = 3;
                let x = play.substr(0, 2);
                let y = play.substr(2, 2);
                let z = play.substr(4, 2);
                filter_play = play;
                play = x + '-' + y + '-' + z;
                console.log(play)
                check_avail(lottery_id, game_id, filter_play);
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

    })

    $('body').on('keyup', '#myplay2', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
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
                let lottery_name = $('#' + lottery_id).attr('name');
                let html = `<tr>
                                <td name="${lottery_id}">${lottery_name}</td>
                                <td name="${game_id}">${play}</td>
                                <td name="${play}">${amount}</td>
                                <td name="${amount}"><i class='fa fa-trash remove_this' style="color:red;"></i></td>
                            </tr>`
                total_play += 1;
                total_amount += Number(amount);
                $('#total_play').val(total_play);
                $('#total_amount').val(total_amount);
                if (game_id == 1) {
                    $('#playsTableBodyDirecto').prepend(html);
                    let sub_total = $('.table_total1 ').text();
                    sub_total = Number(sub_total) + Number(amount);
                    $('.table_total1').text(sub_total);
                } else if (game_id == 2 || game_id == 3) {
                    $('#playsTableBodyPale').prepend(html);
                    let sub_total = $('.table_total2').text();
                    sub_total = Number(sub_total) + Number(amount);
                    $('.table_total2').text(sub_total);
                } else if (game_id == 4 || game_id == 5) {
                    $('#playsTableBodyCash').prepend(html);
                    let sub_total = $('.table_total3').text();
                    sub_total = Number(sub_total) + Number(amount);
                    $('.table_total3').text(sub_total);
                } else if (game_id == 6 || game_id == 7) {
                    $('#playsTableBodyPick').prepend(html);
                    let sub_total = $('.table_total4').text();
                    sub_total = Number(sub_total) + Number(amount);
                    $('.table_total4').text(sub_total);
                }

                $('#myplay1').val('');
                $('#myplay1').focus();
            }
        }
    })

    $(document).on('click', '.remove_this', function () {
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
                    var html = `<option value="${ticket_id}">${display_ticket}</option>`
                    $('#tickets').prepend(html);
                    $('.balance span').text(data.balance);
                    $('.print-container div.logo-text p').text(date);
                    $('.print-container div.ticket-info p.fecha span').text(date);
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
                    total_amount = 0;
                    total_play = 0;
                    $('#total_play').val('');
                    $('#total_amount').val('');
                    console.log(display_ticket);
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
                    let balance = data.pop();
                    $('#ticket_result .logo-text p').text(date);
                    $('#ticket_result .fecha span').text(date);
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


    var myVar = setInterval(function() {
        myTimer();
      }, 1000);
      
      function myTimer() {
        var d = new Date();
        document.getElementById("clock").innerHTML = d.toLocaleTimeString();
      }

})

function validateNumber(event) {
    var key = window.event ? event.keyCode : event.which;
    if (event.keyCode === 8 || event.keycode === 13) {
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

function draw_table(print_data, tag) {

    var total_price = 0;

    for (let i = 1; i <= 10; i++) {
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