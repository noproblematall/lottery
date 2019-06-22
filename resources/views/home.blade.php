@extends('layouts.app')
@section('css')

    <style>
        table > thead > tr > th,table tbody tr td{
            padding:2px !important;
            text-align: center;
        }
    </style>
@endsection
@section('content')
<div class="winning_number float-left">
    <div class="btn-group btn-group-sm">
        <button type="button" id="winning_number" class="btn btn-primary"> NUMEROS GANADORES </button>
        <button type="button" id="print_win" class="btn btn-warning"><i class="fa fa-print"></i></button>
    </div>
</div>
<div class="winning_number float-right" style="margin-right:10px;color:wheat;">
    <h5>12 : 55 : 33 : PM</h5>
</div>
<div class="container custom_container">
    <div class="row">
        <div class="mx-auto mt-5 text-center">
            <img src="{{asset('images/logo.png')}}" alt="" srcset="" width="200" height="100">
        </div>
    </div>
    <div class="row mx-auto mt-4 text-center">
        <ul class="lottery mx-auto">
            @isset($lottery)
                @foreach ($lottery as $item)
                    <li id="{{$item->id}}" name="{{$item->abbrev}}">{{$item->name}}</li>
                @endforeach
            @endisset
            {{-- <li>New York AM</li>
            <li>Florida AM</li>
            <li>Gana Mas</li>
            <li>Georgia AM</li>
            <li>FL Pick2 AM</li>
            <li>New York PM</li>
            <li>Loteria Nacional</li>
            <li>Florida PM</li>
            <li>Georgia Evening PM</li>
            <li>FL Pick2 PM</li> --}}
        </ul>
    </div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" id="myplay1" name="play" placeholder="Play"/>
                    <em id="email-type-error" class="error invalid-feedback">Please enter your correct email</em>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" id="avalable" name="avalable" placeholder="" readonly/>
                    <em id="email-type-error" class="error invalid-feedback">Please enter your correct email</em>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" id="myplay2" name="amount" placeholder="Amount"/>
                    <em id="email-type-error" class="error invalid-feedback">Please enter your correct email</em>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                    <label for="usr">My Tickets:</label>
                <div class="input-group mb-3">
                    <select name="tickets" id="tickets">
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button"><i class="fa fa-files-o"></i></button> 
                        <button class="btn btn-danger" type="button"><i class="fa fa-times"></i></button> 
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="usr">Total Play:</label>
                    <input type="text" class="form-control" id="total_play" name="total_play" placeholder="" readonly/>
                    <em id="email-type-error" class="error invalid-feedback">Please enter your correct email</em>
                </div>
            </div>
            <div class="col-md-4">
                <label for="usr">Total Amount:</label>
                <div class="form-group">
                    <input type="text" class="form-control" id="total_amount" name="total_amount" placeholder="" readonly/>
                    <em id="email-type-error" class="error invalid-feedback">Please enter your correct email</em>
                </div>
            </div>
        </div>
        <div class="row table_row">
            <div class="col-md-3" style="padding:0;">
                <div class="ticket-info-container">
                    <div id="headerForDirecto" class="row header text-center">
                        <h5>Directo</h5>
                    </div>
                    <div class="row ticket-table" style="height:235px;overflow:auto;">
                        <table id="playsTableDirecto" class="table table-striped table-bordered table-hover plays-table">
                            <thead>
                                <tr>
                                    <th>LOTERIA</th>
                                    <th>NUMERO</th>
                                    <th>MONTO</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody id="playsTableBodyDirecto">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row lottery-table-footer">
                        <h5>Total: <span class="table-total">$0.00</span></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="padding:0;">
                <div class="ticket-info-container">
                    <div id="headerForPale" class="row header">
                        <h5>Pale & Tripleta</h5>
                    </div>
                    <div class="row ticket-table" style="height:235px;overflow:auto;">
                        <table id="playsTablePale" class="table table-striped table-bordered table-hover plays-table">
                            <thead>
                                <tr>
                                    <th>LOTERIA</th>
                                    <th>NUMERO</th>
                                    <th>MONTO</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody id="playsTableBodyPale">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row lottery-table-footer">
                        <h5>Total: <span class="table-total">$0.00</span></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="padding:0;">
                <div class="ticket-info-container">
                    <div id="headerForCash" class="row header">
                        <h5>Pick 3</h5>
                    </div>
                    <div class="row ticket-table" style="height:235px;overflow:auto;">
                        <table id="playsTableCash" class="table table-striped table-bordered table-hover plays-table">
                            <thead>
                                <tr>
                                    <th>LOTERIA</th>
                                    <th>NUMERO</th>
                                    <th>MONTO</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody id="playsTableBodyCash">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row lottery-table-footer">
                        <h5>Total: <span class="table-total">$0.00</span></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3" style="padding:0;">
                <div class="ticket-info-container">
                    <div id="headerForPick" class="row header">
                        <h5>Pick 4 / Pick 5</h5>
                    </div>
                    <div class="row ticket-table" style="height:235px;overflow:auto;">
                        <table id="playsTablePick" class="table table-striped table-bordered table-hover plays-table">
                            <thead>
                                <tr>
                                    <th>LOTERIA</th>
                                    <th>NUMERO</th>
                                    <th>MONTO</th>
                                    <th style="width:10%"></th>
                                </tr>
                            </thead>
                            <tbody id="playsTableBodyPick">
                                
                            </tbody>
                        </table>
                    </div>
                    <div class="row lottery-table-footer">
                        <h5>Total: <span class="table-total">$0.00</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row text-center" id="footer">
            <ul class="menu">
                <li><a href="#">Monitoreo</a></li>
                <li><a href="#">Pendientes de Pago</a></li>
                <li><a href="#">Imprimir Reporte</a></li>
                <li><a href="#">Resultados</a></li>
                <li><a href="#">Duplicar</a></li>
                <li><a href="#">Jugadas</a></li>
                <li><a href="#">Pagar</a></li>
                <li><a id="create_ticket" href="javascript:void(0);">Crear ticket</a></li>
                <li><a href="#">Ayuda</a></li>
                <li><a href="#">Salir</a></li>
            </ul>
        </div>        
    </div>
</div>
<div class="container text-center">
        <div class="row">
            <div class="alert alert-success" id="success" style="margin:5px auto;">
                <strong>Success!</strong> <span>Indicates a successful or positive action.</span>
            </div>
        </div>
        <div class="row">
            <div class="alert alert-danger" id="warning" style="margin:5px auto;">
                <strong>Winning!</strong> <span>Indicates a successful or positive action.</span>
            </div>
        </div>
</div>
@endsection

@section('modal')
    <div class="modal fade" id="win_modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-modal="true">
        <div class="modal-dialog" >
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Winning Numbers</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body text-center" id="print_result">
                    <img src="{{asset('images/logo-inverse.png')}}" alt="" srcset="" width="200" height="100">
                    <table style="width: 100%;" id="results" class="table table-hover table-striped table-bordered">
                        <thead>
                            <tr> 
                                <th colspan="6" class="text-center"> RESULTADOS {{$date}}<span></span> </th> 
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
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" id="submit_win" class="btn btn-primary">Add</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="wrap-print" style="display:none;">
        <div  id="ticket_result">
                <style>
                        .print-container {
                            background: white;
                            padding:40px;
                        }
                        .logo-text{
                            margin:10px auto;
                        }
                        p {
                            margin-bottom: 5px;
                        }
                        table thead tr th, table tbody tr td{
                            padding-left: 10px;
                            padding-right: 10px;
                        }
                        .ticket-detail table tbody tr td{
                            text-align: left;
                        }
                        .general-info p,.ticket-detail p,.ticket-info p{
                            font-style: italic;
                            margin-bottom: 5px;
                        }
                    </style>
        
        <div class="container print-container" style="margin:0;">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo-text text-center">
                        <h1 style="font-weight: bold;">Kaizer & Assoc</h1>
                        <h1>**&nbsp;&nbsp; ORIGINAL &nbsp;&nbsp;**</h1>
                        <p>06/14/2019 01 : 24 PM</p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ticket-info">
                        <p>Ticket: <span>001 - 280 - 014030856</span></p>
                        <p>Fecha: <span>06/14/2019 01 : 24 PM</span></p>
                        <p>2BCC2C307D316B5D3D71032B957E7E93</p>
                        <h3>573843071605</h3>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <div class="ticket-detail text-center">
                        <div>
                            <p style="font-weight:bolder">------------------------------------------------</p>
                            <p>FLORIDA AM : 1.00</p>
                            <p style="font-weight:bolder">------------------------------------------------</p>
                            <table class="text-center" style="margin-left:210px;">
                                <thead>
                                    <tr>
                                        <th>JUGADA</th>
                                        <th>MONTO</th>
                                        <th>JUGADA</th>
                                        <th>MONTO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>12</td>
                                        <td>1</td>
                                        <td>22</td>
                                        <td>10</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                        
                    </div>
                    <h2 class="total_display">-- <span>TOTAL : 1.00</span> --</h2>
                </div>
                <div class="col-md-12">
                    <div class="general-info text-center">
                        <p>1st:$65(00-99):$60 2nd:$15</p>
                        <p>3rd:$10 First Only and Pick2:$80</p>
                        <p>Pale:$1,000 SuperPale:$2,000</p>
                        <p>Cash3:$700(000-999:$500)</p>
                        <p>Play4:$4,000 Pick5:$40,000</p>
                        <p>Kole3:$10,000</p>
                        <p>NO TICKET NO MONEY . WE DON'T P A Y</p>
                        <p>DOUBLE P ALE.</p>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    </div>

@section('script')
<script src="{{asset('js/print.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#winning_number').click(function(){
                $("#win_modal").modal();
            })

            $('#print_win').click(function(){
                printJS({
                    printable: 'print_result',
                    type: 'html',
                    targetStyles: ['*'],
                    documentTitle:'Winning Numbers'
                })
            })
        })
    </script>
@endsection
