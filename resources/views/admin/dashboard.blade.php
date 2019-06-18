@extends('admin.layouts.app')

@section('subtitle')
    <div class="page-title-icon">
        <i class="pe-7s-home icon-gradient bg-amy-crisp">
        </i>
    </div>
    <div>HOME</div>
@endsection

@section('content')

<div class="row">
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Number of Admmins According Date</h5>
                <div id="chart-apex-area"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="main-card mb-3 card">
            <div class="card-body">
                <h5 class="card-title">Number of Admmins According Date</h5>
                <div id=""></div>
            </div>
        </div>
    </div>
</div>
@endsection
@php
    //  dd($sold_mount);
@endphp
@section('script')

<script src="{{asset('js/appexchart.js')}}"></script>
<script src="{{asset('js/apex-series.js')}}"></script>
<script>
    
    var options = {
    chart: {
        height: 350,
        type: 'area',
        zoom: {
            enabled: false
        }
    },
    dataLabels: {
        enabled: false
    },
    stroke: {
        curve: 'straight'
    },
    series: [{
        name: "STOCK ABC",
        data: series.monthDataSeries1.prices
    }],
    title: {
        text: 'Fundamental Analysis of Stocks',
        align: 'left'
    },
    subtitle: {
        text: 'Price Movements',
        align: 'left'
    },
    labels: series.monthDataSeries1.dates,
    xaxis: {
        type: 'datetime'
    },
    yaxis: {
        opposite: true
    },
    legend: {
        horizontalAlign: 'left'
    }
};

var chart = new ApexCharts(
    document.querySelector("#chart-apex-area"),
    options
);
 
</script>
    
@endsection
