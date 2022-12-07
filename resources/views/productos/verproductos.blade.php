@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Lista de productos</h1>
@stop

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4>Listado de productos</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Imagen</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Existencias</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productos as $producto)
                                        <tr>
                                            <td style="padding: 30px"><img src="{{ asset($producto->imagen) }}" width="50px"
                                                    height="50px">
                                            </td>
                                            <td style="padding: 30px">{{ $producto->nombre }}</td>
                                            <td style="padding: 30px">{{ $producto->descripcion }}</td>
                                            <td style="padding: 30px">{{ $producto->existencias }}</td>
                                            <td style="padding: 30px">$ {{ $producto->precio }}</td>
                                            <td style="padding: 30px"><button type="button" data-toggle="modal"
                                                    data-target="#comprarProducto" data-id="{{ $producto->id }}"
                                                    class="btn btn-success btncomprar">Comprar</button>
                                            </td>
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

    <div class="modal fade" id="comprarProducto" tabindex="-1" role="dialog" aria-labelledby="exampleMoldalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Ingresa las unidades a comprar</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="agregaracarrito" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="no_tienda">Unidades del producto:</label>
                            <input type="number" name="unidades" id="unidades" class="form-control" />
                            <input type="hidden" name="id" id="id" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Agregar al carrito</button>
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
        $(document).on("click", ".btncomprar", function() {
            var id = $(this).data('id');
            $('#id').val(id);
        });
    </script>
@stop
