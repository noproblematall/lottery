@extends('layouts.app')
@section('css')

    <style>
        
    </style>
@endsection
@section('content')
<div class="winning_number float-left">
    <div class="btn-group btn-group-sm">
        <button type="button" class="btn btn-primary"> NUMEROS GANADORES </button>
        <button type="button" class="btn btn-warning"><i class="fa fa-print"></i></button>
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
            <li>New York AM</li>
            <li>Florida AM</li>
            <li>Gana Mas</li>
            <li>Georgia AM</li>
            <li>FL Pick2 AM</li>
            <li>New York PM</li>
            <li>Loteria Nacional</li>
            <li>Florida PM</li>
            <li>Georgia Evening PM</li>
            <li>FL Pick2 PM</li>
        </ul>
    </div>
    <div class="container">
        <div class="row mt-3">
            <div class="col-md-4">
                <div class="form-group">
                    <input type="text" class="form-control" id="play" name="play" placeholder="Play"/>
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
                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Amount"/>
                    <em id="email-type-error" class="error invalid-feedback">Please enter your correct email</em>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-4">
                    <label for="usr">My Tickets:</label>
                <div class="input-group mb-3">
                    <select name="tickets" id="tickets">
                        <option value="">Please select...</option>
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
        <div class="row">
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
                    <div id="headerForDirecto" class="row header">
                        <h5>Pale & Tripleta</h5>
                    </div>
                    <div class="row ticket-table" style="height:235px;overflow:auto;">
                        <table id="playsTableDirecto" class="table table-striped table-bordered table-hover plays-table">
                            <thead>
                                <tr>
                                    <th>LOTERIA</th>
                                    <th>NUMERO</th>
                                    <th>MONTO</th>
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
                    <div id="headerForDirecto" class="row header">
                        <h5>Pick 3</h5>
                    </div>
                    <div class="row ticket-table" style="height:235px;overflow:auto;">
                        <table id="playsTableDirecto" class="table table-striped table-bordered table-hover plays-table">
                            <thead>
                                <tr>
                                    <th>LOTERIA</th>
                                    <th>NUMERO</th>
                                    <th>MONTO</th>
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
                    <div id="headerForDirecto" class="row header">
                        <h5>Pick 4 / Pick 5</h5>
                    </div>
                    <div class="row ticket-table" style="height:235px;overflow:auto;">
                        <table id="playsTableDirecto" class="table table-striped table-bordered table-hover plays-table">
                            <thead>
                                <tr>
                                    <th>LOTERIA</th>
                                    <th>NUMERO</th>
                                    <th>MONTO</th>
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
                <li><a href="#">Ver Ventas</a></li>
                <li><a href="#">Ayuda</a></li>
                <li><a href="#">Salir</a></li>
            </ul>
        </div>
    </div>
    
</div>
@endsection
