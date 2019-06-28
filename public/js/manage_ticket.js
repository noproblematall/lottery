$(document).ready(function(){

    $('.ticket_mark_result').addClass('display-none');
    $('.ticket_print').click(function(){
        let ticket_id = $(this).parent().parent().find('.ticket_id').attr('id');
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


    $('.ticket_delete').click(function () {
        let ticket_id = $(this).parent().parent().find('.ticket_id').attr('id');
        $(this).parent().parent().remove();
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

    $('.ticket_paid').click(function(){
        // let ticket_id = $(this).parent().parent().find('.ticket_id').attr('id');
        // $('.mark_submit').attr('id',ticket_id);
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
                console.log(data);
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
                    console.log(details.length)
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
})




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