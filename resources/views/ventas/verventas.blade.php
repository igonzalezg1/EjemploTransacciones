@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Ventas</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Ver ventas realizadas</h4>
                        <br />
                        <br />
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>Fecha</td>
                                        <td>Subtotal</td>
                                        <td>IVA</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($ventas as $venta)
                                        <tr>
                                            <td>{{ $venta->fecha }}</td>
                                            <td>{{ $venta->subtotal }}</td>
                                            <td>{{ $venta->iva }}</td>
                                            <td>{{ $venta->total }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    @notifyCss
@stop

@section('js')
    <x:notify-messages />
    @notifyJs
    <script>
        $(document).on("click", ".btntarjeta", function() {
            var iduser = $(this).data('iduser');
            $('#user_id').val(iduser);
            var user = $(this).data('nombre');
            $('#user').val(user);
        });
    </script>
@stop
