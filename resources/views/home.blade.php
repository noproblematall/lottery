@extends('layouts.app')
@section('css')

    <style>
        table > thead > tr > th,table tbody tr td{
            padding:2px !important;
            text-align: center;
        }
        #duplicate_modal .one_lottery label{
                color:black;
        }
    </style>
@endsection
@section('content')
<span class="name" style="display:none;">{{Auth::user()->name}}</span>

<div class="float-left">
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-primary winning_number"> NUMEROS GANADORES </button>
        <button type="button" id="print_win" class="btn btn-warning"><i class="fa fa-print"></i></button>
    </div>
</div>
<div class="float-right" style="margin-right:10px;color:wheat;">
    <h5 id="clock"></h5>
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
                    <li id="{{$item->id}}" time="{{$item->limit_time}}" name="{{$item->abbrev}}">{{$item->name}}</li>
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
                        @isset($tickets)
                            @foreach ($tickets as $ticket)
                                @php
                                    $price = $ticket->details()->sum('amount');
                                    $temp = $ticket->id.' - '.'$'.$price;
                                @endphp
                                <option value="{{$ticket->id}}">{{$temp}}</option>
                            @endforeach
                        @endisset
                    </select>
                    <div class="input-group-append">
                        <button class="btn btn-primary" id="ticket_copy" type="button"><i class="fa fa-files-o"></i></button>
                        <button class="btn btn-danger" id="ticket_delete" type="button"><i class="fa fa-times"></i></button> 
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
                        <h5>Total: $<span class="table_total1">0</span></h5>
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
                        <h5>Total: $<span class="table_total2">0</span></h5>
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
                        <h5>Total: $<span class="table_total3">0</span></h5>
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
                        <h5>Total: $<span class="table_total4">0</span></h5>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row text-center" id="footer">
            <ul class="menu">
                <li class="balance" style="color:white;font-weight:bolder;">$ <span>{{$balance}}</span></li>
                <li><a href="{{route('summary')}}">Sales Summary</a></li>
                <li><a href="{{route('manage_ticket')}}">Pendientes de Pago</a></li>
                <li><a href="javascript:void(0);" class="winning_number">Resultados</a></li>
                <li><a href="javascript:void(0);" id="duplicate">Duplicar</a></li>
                <li><a href="javascript:void(0);" id="pagar">Pagar</a></li>
                <li><a href="javascript:void(0);" id="help">Ayuda</a></li>
                <li><a id="create_ticket" href="javascript:void(0);">Crear ticket</a></li>
                <li><a href="javascript:void(0);" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Salir</a></li>
            </ul>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
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
                                <th colspan="6" class="text-center"> RESULTADOS @isset($date){{$date}}@endisset<span></span> </th>
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

    <!-- The Modal -->
  <div class="modal fade" id="help_modal">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
      <div class="modal-content">
      
        <!-- Modal Header -->
        <div class="modal-header">
          <h2 class="modal-title">Help</h2>
          <button type="button" class="close" data-dismiss="modal">×</button>
        </div>
        
        <!-- Modal body -->
        <div class="modal-body">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#how_to_play">How to play?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#keys">keys</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#menu2">Menu 2</a>
                </li> --}}
            </ul>
            
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active container" id="how_to_play">
                    <h4>To play a Directo</h4> 
                    <ol> 
                        <li>Type a two digit number on the Play and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Palé</h4> 
                    <ol> 
                        <li>Type the a four digit number on the Play and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Tripleta</h4> 
                    <ol> 
                        <li>Type a six digits number on the Play and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Cash 3 Straight</h4> 
                    <ol> 
                        <li>Type a three digits number on the Play and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Cash 3 Box</h4> 
                    <ol> 
                        <li>Type a three digits number on the Play followed by a + sign (Ex .: 123+) and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Play 4 Straight</h4> 
                    <ol> 
                        <li>Type a four digits number on the Play followed by a - sign (Ex .: 1234-) and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Play 4 Box</h4> 
                    <ol> 
                        <li>Type a four digits number on the Play followed by a + sign (Ex .: 1234+) and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Pick 5 Straight</h4> 
                    <ol> 
                        <li>Type a five digits number on the Play followed by a - sign (Ex .: 12345-) and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Pick 5 Box</h4> 
                    <ol> 
                        <li>Type a five digits number on the Play followed by a + sign (Ex .: 12345+) and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                    <h4>To play a Super Palé</h4> 
                    <ol> 
                        <li>Type the a four digit number on the Play and press ENTER.</li> 
                        <li>Type the amount and press ENTER.</li> 
                    </ol> 
                </div>
                <div class="tab-pane container" id="keys">...</div>
                {{-- <div class="tab-pane container" id="menu2">...</div> --}}
            </div>
        </div>
        
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
        
      </div>
    </div>
  </div>


  <!-- The Mark Modal -->
  <div class="modal fade" id="mark_modal">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h2 class="modal-title">Mark as Paid</h2>
              <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="code" style="color:black;">Code:</label>
                    <input type="text" class="form-control" id="code">
                    <em id="code-require-error" class="error invalid-feedback">Please enter your code</em>
                    <em id="code-invalid-error" class="error invalid-feedback">Invalid code</em>
                </div>
                <div class="ticket_mark_result text-center">
                    <input type="hidden" name="" id="temp_barcode">
                    <h5>Ticket: <span></span></h5>
                    <p>Legend</p>
                    <ul>
                        <li class="winning-play">Winner</li>
                        <li class="losing-play">Loser</li>
                        <li class="pending-play">Pending</li>
                    </ul>
                    <p>PLAYS(AMOUNT: <span class="amount"></span>)(PENDING PAYMENT:<span style="color:red;font-weight:bold;" class="pending_payment"></span>)(TOTAL PRIZE:<span class="pending_payment"></span>)</p>
                    <table class="table table-borded mx-auto">
                        <thead>
                            <tr>
                                <th>Play</th>
                                <th>Play Type</th>
                                <th>Amount</th>
                                <th>Prize</th>
                                <th>Paid</th>
                            </tr>
                        </thead>
                        <tbody class="mark_result">
                         
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Go Back</button>
              <button type="button" class="btn btn-danger mark_submit">Mark as Paid</button>
            </div>
            
          </div>
        </div>
      </div>

      <!-- The Duplicate Modal -->
  <div class="modal fade" id="duplicate_modal">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h2 class="modal-title">Duplicate ticket</h2>
              <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
                <div class="form-group">
                    <label for="ticket_number" style="color:black;">Ticket Number:</label>
                    <input type="text" class="form-control" id="ticket_number">
                    <em id="ticket_number-require-error" class="error invalid-feedback">Please enter your code</em>
                    <em id="ticket_number-invalid-error" class="error invalid-feedback">Invalid code</em>
                </div>
                <div class="duplicate_lottery">
                    <input type="hidden" name="" id="temp_barcode2">
                    <h4 class="text-center">Choose the lottery on the right side to move the plays from the lottery on the left</h4>
                    <hr>
                    <div class="duplicate_result text-center">
                        
                    </div>
                </div>
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Go Back</button>
              <button type="button" class="btn btn-danger duplicate_submit">Load ticket duplicate</button>
            </div>
            
          </div>
        </div>
      </div>
@endsection

<select class="form-control float-right w-50 display-none" id="lottery_clone">
    <option>--Don't Move--</option>
    <option>--Don't Copy--</option>
    @isset($lottery)
        @foreach ($lottery as $item)
            <option value="{{$item->id}}" name="{{$item->abbrev}}">{{$item->name}}</option>
        @endforeach
    @endisset
</select>
{{-- Ticket create Print --}}
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
                        <h1 class="origin">**&nbsp;&nbsp; ORIGINAL &nbsp;&nbsp;**</h1>
                        <p></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ticket-info">
                        <p>Ticket: <span></span></p>
                        <p class="fecha">Fecha: <span></span></p>
                        <h3></h3>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <div class="ticket-detail text-center">
                        
                    </div>
                    <h2 class="total_display">-- <span></span> --</h2>
                </div>
                <div class="col-md-12">
                    <div class="general-info text-center">
                        <p>1st:$65(00-99):$65 2nd:$15</p>
                        <p>3rd:$10, Pick2:$75</p>
                        <p>Pale:$800, SuperPale:$2,000</p>
                        <p>Cash3:$700(000-999:$500)</p>
                        <p>Play4:$4,000 Pick5:$30,000</p>
                        <p>Kole3:$10,000</p>
                        <p>NO TICKET NO MONEY . WE DON'T P A Y</p>
                        <p>DOUBLE P ALE.</p>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    </div>
{{-- Ticket cancel print --}}

<div class="wrap-print" style="display:none;">
        <div  id="ticket_cancel">
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
                        .logo-text h1{
                            margin: 0;
                        }
                    </style>
        
        <div class="container print-container" style="margin:0;">
            <div class="row">
                <div class="col-md-12">
                    <div class="logo-text text-center">
                        <h1 style="font-weight: bold;">Kaizer & Assoc</h1>
                        <h1>*******************</h1>
                        <h1>*                CANCELADO              *</h1>
                        <h1>*******************</h1>
                        <p style="margin:5px;"></p>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="ticket-info">
                        <p>Ticket: <span></span></p>
                        <p class="fecha">Fecha: <span></span></p>
                        <h3></h3>
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <div class="ticket-detail text-center">
                        
                    </div>
                    <h2 class="total_display">-- <span class=""></span> --</h2>
                </div>
                <div class="col-md-12">
                    <div class="general-info text-center">
                        <p>1st:$65(00-99):$65 2nd:$15</p>
                        <p>3rd:$10, Pick2:$75</p>
                        <p>Pale:$800, SuperPale:$2,000</p>
                        <p>Cash3:$700(000-999:$500)</p>
                        <p>Play4:$4,000 Pick5:$30,000</p>
                        <p>Kole3:$10,000</p>
                        <p>NO TICKET NO MONEY . WE DON'T P A Y</p>
                        <p>DOUBLE P ALE.</p>
                    </div>
                </div>
                
            </div>
            
        </div>
    </div>
    </div>


    <div class="clone" style="display:none;">
        <p style="font-weight:bolder">------------------------------------------------</p>
        <p class="table_title"><span class="title"></span><span class="price"></span></p>
        <p style="font-weight:bolder">------------------------------------------------</p>
        <table class="text-center" style="margin:0 auto;">
            <thead>
                <tr>
                    <th>JUGADA</th>
                    <th>MONTO</th>
                    <th>JUGADA</th>
                    <th>MONTO</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>
    </div>

@section('script')
<script src="{{ asset('js/lottery.js') }}"></script>
<script src="{{asset('js/print.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.winning_number').click(function(){
                $("#win_modal").modal();
            })

            $('#help').click(function(){
                $("#help_modal").modal();
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
