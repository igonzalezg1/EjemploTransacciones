@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Carrito de compras</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        @if (isset($carrito))
                            <h4>Datos de venta</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Subtotal</th>
                                            <th>IVA</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="padding: 30px">$ {{ $carrito->subtotal }}</td>
                                            <td style="padding: 30px">$ {{ $carrito->iva }}</td>
                                            <td style="padding: 30px">$ {{ $carrito->total }}</td>
                                            <td style="padding: 30px">
                                                <form action="crearventa" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" id="id"
                                                        value="{{ $carrito->id }}">
                                                    <button type="submit" class="btn btn-success">Comprar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Imagen</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio unitario</th>
                                            <th>Precio total</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($detalles as $detalle)
                                            <tr>
                                                <td><img src="{{ asset($detalle->producto->imagen) }}"
                                                        alt="{{ $detalle->producto->nombre }}" width="50px"
                                                        height="50px"></td>
                                                <td>{{ $detalle->producto->nombre }}</td>
                                                <td>{{ $detalle->cantidad }}</td>
                                                <td>$ {{ $detalle->producto->precio }}</td>
                                                <td>$ {{ $detalle->producto->precio * $detalle->cantidad }}</td>
                                                <td>
                                                    <form action="quitardecarro" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{ $detalle->id }}">
                                                        <button type="submit" class="btn btn-danger"><i
                                                                class="fas fa-trash-alt"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h4>No hay productos en el carrito</h4>
                        @endif
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
        $(document).on("click", ".btncomprar", function() {
            var id = $(this).data('id');
            $('#id').val(id);
        });
    </script>
@stop
