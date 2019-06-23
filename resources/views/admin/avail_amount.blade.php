@extends('admin.layouts.app')
@section('css')
    <style>
        .datepicker-container {
            z-index: 1500 !important;
        }
        /* ul.lottery_name {
            float: right;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.lottery_name li{
            padding:6px;
            font-weight: bold;
        } */
        #amount_modal .modal-body .form-group div{
            display: inline-block;
            width:70%;
        }
    </style>
@endsection
@section('subtitle')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-diamond icon-gradient bg-amy-crisp">
            </i>
        </div>
        <div>AVAILABLE AMOUNTS</div>
    </div>
    <div class="page-title-actions">
        <div class="d-inline-block">
        <a href="javascript:void(0);" id="add_amount" class="btn-shadow btn btn-info">
            <span class="btn-icon-wrapper pr-2 opacity-7">
                <i class="fa fa-user-plus fa-w-20"></i>
            </span>
            Add Amount
        </a>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="main-card mb-3 card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sel1" class="float-left" style="margin-top:0.5rem;">Dates:</label>
                                <select class="form-control float-right" id="select_date" style="width:70%">
                                    @isset($date)
                                        <option value="">{{$date}}</option>
                                    @endisset
                                    
                                    
                                </select>
                                <form id="search_winnumber" action="#" method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="date" id="date">
                                </form>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <table style="width:100%;" id="results" class="table table-hover table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Lottery Name</th>
                                        <th>Game Name</th>
                                        <th>Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($price_data)
                                        @foreach ($price_data as $item)
                                            <tr>
                                                <td>{{$item->lottery->name}}</td>
                                                <td>{{$item->game->name}}</td>
                                                <td>{{$item->price}}</td>
                                            </tr>
                                        @endforeach
                                        
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('modal')
    <div class="modal fade" id="amount_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Available Amount</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <hr>
                    <div class="form-group">
                        <label for="name">Date:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="avail_date" name="avail_date" required autocomplete="off"/>
                        </div>
                        <em id="date-require-error" class="error invalid-feedback text-center float-right">Please enter date</em>
                    </div>
                    
                    <div class="form-group">
                        <label for="lottery">Lottery</span></label>
                        <div class="float-right">
                            <select name="lottery" id="lottery_name"  class="form-control">
                                @isset($lottery)
                                    @foreach ($lottery as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>
                        
                    </div>
                    <div class="form-group">
                        <label for="name">Directo:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" min="0" id="1" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Pale:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" id="2" min="0" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Tripleta:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" id="3" min="0" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Cash 3 Straight:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" id="4" min="0" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Cash 3 Box:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" id="5" min="0" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">4 Straight:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" id="6" min="0" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">4 Box:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" id="7" min="0" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">Super Pale:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="number" class="form-control" id="8" min="0" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit_amount" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
    <script>
        $(document).ready(function(){

            // $('#select_date').change(function () {
            //     console.log($(this).val())
            //     if ($(this).val()) {
            //         $('#date').val($(this).val());
            //         $('#search_winnumber').submit();
            //     } else {

            //     }
            // })

            // $('#results thead th span').text($('#select_date').val());

            $('#avail_date').datepicker({
                format: 'yyyy-mm-dd',
            });
            // $('.loader_container').addClass('display-none');
            $('#add_amount').click(function(){
                $("#amount_modal").modal({backdrop: "static"});
            });
            $("#amount_modal").on('hidden.bs.modal', function(){
                location.reload();
            });
            $('#submit_amount').click(function(){
                let date = $('#avail_date').val();
                if(!date){
                    $('#avail_date').addClass('border-red');
                    $('#date-require-error').addClass('display-show');
                    return false;
                }
                var lottery_id = $('#lottery_name').val();
                console.log(lottery_name)
                var form_group = $('#amount_modal .modal-body .form-group');
                var win_length = form_group.length;

                for(var i=2;i<win_length;i++){
                    var value = $(form_group[i]).find('input').val();
                    var game_id = $(form_group[i]).find('input').attr('id');
                    $.ajax({
                        url:'/admin/add-amount',
                        data:{price:value,lottery_id:lottery_id,game_id:game_id,date:date,length:win_length,i:i},
                        type:'get',
                        beforeSend: function () { $('.loader_container').removeClass('display-none'); },
                        success:function(data){
                            console.log(data);
                        }
                    }).done(function () {
                        $('.loader_container').addClass('display-none');
                    })
                }

                
            })
        })
    </script>
@endsection

<div class="loader_container">    
        <div class="loader">
            <div class="ball-spin-fade-loader">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>    
    </div>