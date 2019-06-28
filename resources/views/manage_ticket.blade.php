@extends('layouts.app')
@section('css')
<link rel="stylesheet" href="{{asset('css/datepicker.css')}}">
    <style>
        div.manage_ticket {
            margin: 50px auto;
            color:white;
        }
        div.manage_ticket table{
            color:white;
        }
        div.manage_ticket table td{
            width: 50%;
        }
        div.manage_ticket table thead tr:hover{
            color:black;
        }
        span.date {
            color: white;
            margin-right:10px;
        }
        div.manage_ticket table i{
            cursor: pointer;
            color:blueviolet;
        }
        div.manage_ticket table i:hover{
            color:red;
        }
    </style>
@endsection
@section('content')
<div style="display:none;">
    <ul class="lottery mx-auto">
        @isset($lottery)
            @foreach ($lottery as $item)
                <li id="{{$item->id}}" name="{{$item->abbrev}}">{{$item->name}}</li>
            @endforeach
        @endisset
    </ul>
    <span class="name">{{Auth::user()->name}}</span>
    <ul class="game mx-auto">
        @isset($game)
            @foreach ($game as $item)
                <li id="{{$item->id}}" name="{{$item->abbrev}}">{{$item->name}}</li>
            @endforeach
        @endisset
    </ul>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="manage_ticket">
                <h3 class="text-center mt-5">Manage Tickets({{$date}})</h3>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <form action="{{route('search_ticket')}}" method="post">
                            @csrf
                            <div class="input-group">
                                <input type="text" class="form-control" name="search_date" id="search_date" placeholder="Search" autocomplete="off">
                                <div class="input-group-append">
                                    <button class="btn btn-success" id="ticket_search" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('home')}}" style="width:100%;" class="btn btn-primary">Back</a>
                    </div>
                </div>
                
                <table class="table table-bordered mt-3 text-center">
                    <thead>
                        <tr>
                            <th>Ticket Number</th>
                            <th>Creation Date</th>
                            <th>User</th>
                            <th>Amount</th>
                            <th>Pending</th>
                            <th>Status</th>
                            <th>Mark Paid</th>
                            <th>Print</th>
                            <th>Cancel/Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($tickets)
                            @foreach ($tickets as $ticket)
                                <tr>
                                    <td id="{{$ticket->id}}" class="ticket_id">{{$ticket->user->name}} - {{$ticket->id}}</td>
                                    <td>{{$ticket->created_at}}</td>
                                    <td>{{$ticket->user->name}}</td>
                                    <td>{{$ticket->details()->sum('amount')}}</td>
                                    <?php
                                        if($ticket->is_pending == 1){
                                    ?>
                                    <td>{{$ticket->details()->where('is_win',1)->sum('prize')}}</td>
                                    <?php
                                        }else{
                                    ?>
                                    <td>---</td>
                                    <?php
                                        }
                                    ?>
                                    <?php
                                        if($date != date('Y-m-d') && $ticket->details()->where('is_win',1)){
                                    ?>
                                    <td>Winner</td>
                                    <?php
                                        }elseif ($date != date('Y-m-d') && $ticket->details()->where('is_win',0)) {
                                    
                                    ?>
                                    <td>Losser</td>
                                    <?php
                                        }else{
                                    ?>
                                    <td>---</td>
                                    <?php
                                        }
                                    ?>
                                    <?php 
                                        if($ticket->is_pending == 1){
                                    ?>
                                    <td class="paid"><i title="pagar" class="fa fa-exclamation-triangle ticket_paid"></i></td>
                                    <?php
                                        }elseif ($ticket->is_pending == 2) {
                                    ?>
                                    <td><i title="paid" class="fa fa-check-square-o" style="color:white;"></i></td>
                                    <?php
                                        }else{
                                    ?>
                                    <td>---</td>
                                    <?php
                                        }
                                    ?>
                                    <td><i title="print" class="ticket_print fa fa-print"></i></td>
                                    <td><i title="delete" class="ticket_delete fa fa-times"></i></td>
                                </tr>
                            @endforeach
                        @endisset
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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
@endsection
@section('modal')
        <!-- The Modal -->
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
@endsection

@section('script')
<script src="{{asset('js/print.js')}}"></script>
<script src="{{asset('js/manage_ticket.js')}}"></script>
<script src="{{asset('js/datepicker.min.js')}}"></script>
<script>
    $('#search_date').datepicker({
        format: 'yyyy-mm-dd'
    });
</script>
@endsection
