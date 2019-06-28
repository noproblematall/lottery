@extends('layouts.app')
@section('css')
    <style>
        div.sales {
            margin: 50px auto;
            color:white;
        }
        div.sales table{
            color:white;
        }
        div.sales table td{
            width: 50%;
        }
        div.sales table tr:hover{
            color:wheat;
        }
        span.date {
            color: white;
            margin-right:10px;
        }
    </style>
@endsection
@section('content')
<span class="date">{{$date}}</span>
<a href="{{route('home')}}" class="btn btn-primary">Back</a>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="sales">
                <h3 class="text-center">Sales Summary</h3>
                <table class="table table-striped table-hover table-bordered">
                    <tbody>
                        <tr>
                            <td>Current Balance</td>
                            <td>{{$current_balance}}</td>
                        </tr>
                        <tr>
                            <td>Pending Tickets Total Amount</td>
                            <td>{{$sum_of_amount}}</td>
                        </tr>
                        <tr>
                            <td>Betting Pool</td>
                            <td>{{$name}}</td>
                        </tr>
                        <tr>
                            <td>Sales</td>
                            <td>{{$today_balance}}</td>
                        </tr>
                        <tr>
                            <td>Pending</td>
                            <td>{{$pending_tickets_number}}</td>
                        </tr>
                        <tr>
                            <td>Losers</td>
                            <td>{{$loser_tickets_number}}</td>
                        </tr>
                        <tr>
                            <td>Winners</td>
                            <td>{{$win_tickets_number}}</td>
                        </tr>
                        <tr>
                            <td>Prizes</td>
                            <td>{{$prizes}}</td>
                        </tr>
                        <tr>
                            <td>Net</td>
                            <td>{{$today_balance}}</td>
                        </tr>
                        <tr>
                            <td>Final</td>
                            <td>{{$today_balance}}</td>
                        </tr>
                        <tr>
                            <td>Balance</td>
                            <td>{{$balance}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@endsection


@section('script')

@endsection
