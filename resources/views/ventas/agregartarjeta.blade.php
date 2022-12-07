@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Tarjetas</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Detalle de tarjeta</h4>
                        <br />
                        <br />
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show">
                                <strong>Favor de revisar los campos</strong>
                                <br />
                                @foreach ($errors->all() as $error)
                                    <span class="text-white">{{ $error }}</span>
                                    <br />
                                @endforeach
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if (!$tarjetas)
                            <button type="button" data-toggle="modal" data-target="#agregarTarjeta"
                                data-iduser="{{ $usuario->id }}" data-nombre="{{ $usuario->name }}"
                                class="btn btn-primary w-100 btntarjeta">
                                Agregar tarjeta
                            </button>
                        @else
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <td>Titular</td>
                                            <td>Tarjeta</td>
                                            <td>CVV</td>
                                            <td>fecha</td>
                                            <td>Tipo de tarjeta</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{ $tarjetas->usuarios->name }}</td>
                                            <td>**** **** **** {{ substr($tarjetas->card_number, 15, 4) }}</td>
                                            <td>{{ $tarjetas->cvv }}</td>
                                            <td>{{ $tarjetas->card_expiration }}</td>
                                            <td>{{ $tarjetas->card_type }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="agregarTarjeta" tabindex="-1" role="dialog" aria-labelledby="exampleMoldalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Ingresa los datos de la tarjeta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="agregarTarjetap" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="user">Nombre de tarjetabiente:</label>
                            <input type="text" name="user" id="user" class="form-control" readonly />
                            <input type="hidden" name="user_id" id="user_id" class="form-control" />
                            <label for="card_number">Numero de tarjeta:</label>
                            <input type="number" name="card_number" id="card_number" class="form-control" />
                            <label for="card_number">CVV:</label>
                            <input type="number" name="card_cvv" id="card_cvv" class="form-control" />
                            <label for="card_type">Tipo de tarjeta:</label>
                            <select name="card_type" id="card_type" class="form-control">
                                <option value="credito">Credito</option>
                                <option value="debito">Debito</option>
                            </select>
                            <label for="card_type">Fecha de expiracion:</label>
                            <input type="month" name="card_expiration" id="card_expiration" class="form-control"
                                class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Agregar tarjeta</button>
                        <br />
                        <br />
                        <button type="button" class="btn btn-danger w-100" data-dismiss="modal">Cancelar</button>
                    </form>
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
