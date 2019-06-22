@extends('layouts.app')
@section('css')
    
@endsection
@section('content')




@endsection

@section('modal')
   
@endsection

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
