@extends('admin.layouts.app')
@section('css')
    <style>
        .datepicker-container {
            z-index: 1500 !important;
        }
        #win_modal .modal-body .form-group div{
            display: inline-block;
            width:80%;
        }
    </style>
@endsection
@section('subtitle')
    <div class="page-title-heading">
        <div class="page-title-icon">
            <i class="pe-7s-medal icon-gradient bg-amy-crisp">
            </i>
        </div>
        <div>WINNING NUMBERS</div>
    </div>
    <div class="page-title-actions">
        <div class="d-inline-block">
        <a href="javascript:void(0);" id="add_win" class="btn-shadow btn btn-info">
            <span class="btn-icon-wrapper pr-2 opacity-7">
                <i class="fa fa-user-plus fa-w-20"></i>
            </span>
            Add Result
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
                                @isset($date_array)
                                    @foreach ($date_array as $item)
                                    
                                    <?php 
                                        if(isset($date)){
                                            if($item == $date){
                                    ?>
                                        <option value="{{$item}}" selected>{{$item}}</option>
                                    <?php
                                            }else{
                                    ?>
                                    <option value="{{$item}}">{{$item}}</option>
                                    <?php            
                                            }
                                        }else{
                                    ?>
                                        <option value="{{$item}}">{{$item}}</option>
                                    <?php

                                        }
                                    ?>

                                    @endforeach
                                @endisset
                                
                            </select>
                            <form id="search_winnumber" action="{{route('admin.win_search')}}" method="POST" style="display: none;">
                                @csrf
                                <input type="hidden" name="date" id="date">
                            </form>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <table style="width: 100%;" id="results" class="table table-hover table-striped table-bordered">
                            <thead>
                                <tr> 
                                    <th colspan="6" class="text-center"> RESULTADOS <span></span> </th> 
                                </tr>
                            </thead>
                            <tbody>
                                @isset($win_data)
                                    @foreach ($win_data as $item)
                                        <tr style="margin-bottom: 15px">
                                            <td>{{$item->lottery->name}}</td>
                                            <?php 
                                                $numbers = $item->value;
                                                $number = explode(',',$numbers);
                                                $length = count($number);
                                                if($length < 6){
                                                    for ($i=$length; $i < 5; $i++) { 
                                                        $number[$i] = '';
                                                    }
                                                }
                                                foreach ($number as $value) {
                                            ?>
                                                <td>{{$value}}</td>
                                            <?php
                                                }
                                            ?>
                                        </tr>
                                    @endforeach
                                @endisset
                                {{-- <tr style="margin-bottom: 15px"> 
                                    <td class="bolder lottery-abbreviation"> NYA1 </td> 
                                    <td class="result"> <span> 33 </span> </td> 
                                    <td class="result"> <span> 00 </span> </td> 
                                    <td class="result"> <span> 00 </span> </td> 
                                    <td> <span> </span> </td> 
                                    <td> <span> </span> </td> 
                                </tr> --}}
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
    <div class="modal fade" id="win_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Add Winning Numbers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5>Enter numbers separated by comma( , ).</h5>
                    <hr>
                    <div class="form-group">
                        <label for="name">Date:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="win_date" name="win_date" required autocomplete="off"/>
                            <em id="date-require-error" class="error invalid-feedback">Please enter date</em>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">NYA1:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="1" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">NY AM:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="2" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">SP AM:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="3" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">GA AM:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="4" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">NJ AM:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="5" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">P2AM:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="6" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">FL AM:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="7" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name">FAFO:&nbsp;&nbsp;</span></label>
                        <div class="float-right">
                            <input type="text" class="form-control" id="8" user_id="" name="" required autocomplete="off"/>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="submit_win" class="btn btn-primary">Add</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/datepicker/0.6.5/datepicker.min.js"></script>
    <script>
        $(document).ready(function(){

            $('#select_date').change(function () {
                console.log($(this).val())
                if ($(this).val()) {
                    $('#date').val($(this).val());
                    $('#search_winnumber').submit();
                } else {

                }
            })

            $('#results thead th span').text($('#select_date').val());

            $('#win_date').datepicker({
                format: 'yyyy-mm-dd',
            });
            // $('.loader_container').addClass('display-none');
            $('#add_win').click(function(){
                $("#win_modal").modal({backdrop: "static"});
            });
            $("#win_modal").on('hidden.bs.modal', function(){
                location.reload();
            });
            $('#submit_win').click(function(){
                let date = $('#win_date').val();
                if(!date){
                    $('#win_date').addClass('border-red');
                    $('#date-require-error').addClass('display-show');
                    return false;
                }
                
                var form_group = $('#win_modal .modal-body .form-group');
                var win_length = form_group.length;

                for(var i=1;i<win_length;i++){
                    var value = $(form_group[i]).find('input').val();
                    var id = $(form_group[i]).find('input').attr('id');
                    $.ajax({
                        url:'/admin/add-win',
                        data:{value:value,lottery_id:id,date:date,length:win_length,i:i},
                        type:'get',
                        beforeSend: function () { $('.loader_container').removeClass('display-none'); },
                        success:function(data){
                            console.log(data);
                            if(data == 1){
                                swal({
                                    title: "Success",
                                    text: "Winning Number successfully added.",
                                    icon: "success",
                                    button: "OK",
                                    }).then(()=>{
                                    location.href = '/admin/win-number';
                                });
                            }else if(data == 0){
                                swal({
                                    title: "Success",
                                    text: "Winning Number successfully updated.",
                                    icon: "success",
                                    button: "OK",
                                    }).then(()=>{
                                    location.href = '/admin/win-number';
                                });
                            }
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
