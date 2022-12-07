<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductosModel;
use Illuminate\Support\Facades\DB;
use App\Models\CarritoModel;
use App\Models\DetalleCarritoModel;

class ProductosController extends Controller
{
    public function verProductos()
    {
        $productos = ProductosModel::where('existencias', '>', 0)->get();
        return view('productos.verproductos', compact('productos'));
    }

    public function agregaracarrito(Request $request)
    {
        $usuario = auth()->user();
        $carrito = CarritoModel::where('id_user', $usuario->id)->first();
        DB::beginTransaction();
        try {
            $producto = ProductosModel::find($request->id);
            if ($producto->existencias < $request->unidades) {
                $producto->existencias = null;
            } else {
                $producto->existencias = $producto->existencias - $request->unidades;
            }
            $producto->save();
            if ($carrito == null) {
                $carrito = CarritoModel::create([
                    'id_user' => $usuario->id,
                    'total' => $producto->precio * $request->unidades,
                    'subtotal' => ($producto->precio * $request->unidades) - (($producto->precio * $request->unidades) * 0.16),
                    'iva' => ($producto->precio * $request->unidades) * 0.16
                ]);

                DetalleCarritoModel::create([
                    'id_carrito' => $carrito->id,
                    'id_producto' => $producto->id,
                    'cantidad' => $request->unidades,
                ]);
            } else {
                $carrito->total = $carrito->total + ($producto->precio * $request->unidades);
                $carrito->subtotal = $carrito->subtotal + (($producto->precio * $request->unidades) - (($producto->precio * $request->unidades) * 0.16));
                $carrito->iva = $carrito->iva + (($producto->precio * $request->unidades) * 0.16);
                $carrito->save();

                DetalleCarritoModel::create([
                    'id_carrito' => $carrito->id,
                    'id_producto' => $producto->id,
                    'cantidad' => $request->unidades,
                ]);
            }
            DB::commit();
            notify()->success('Producto agregado al carrito');
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            notify()->error('Error al agregar producto al carrito');
            return back();
        }
    }

    public function vercarro()
    {
        $usuario = auth()->user();
        $carrito = CarritoModel::where('id_user', $usuario->id)->first();
        if ($carrito == null) {
            return view('productos.carrito');
        } else {
            $detalles = DetalleCarritoModel::where('id_carrito', $carrito->id)->get();
            return view('productos.carrito', compact('detalles', 'carrito'));
        }
    }

    public function quitardecarro(Request $request)
    {
        $detalle = DetalleCarritoModel::find($request->id);
        DB::beginTransaction();
        try {
            $producto = ProductosModel::find($detalle->id_producto);
            $producto->existencias = $producto->existencias + $detalle->cantidad;
            $producto->save();

            $carrito = CarritoModel::find($detalle->id_carrito);
            $carrito->total = $carrito->total - ($producto->precio * $detalle->cantidad);
            $carrito->subtotal = $carrito->subtotal - (($producto->precio * $detalle->cantidad) - (($producto->precio * $detalle->cantidad) * 0.16));
            $carrito->iva = $carrito->iva - (($producto->precio * $detalle->cantidad) * 0.16);
            $carrito->save();
            $detalle->delete();
            DB::commit();
            notify()->success('Producto quitado del carrito');
            return back();
        } catch (\Exception $e) {
            DB::rollback();
            notify()->error('Error al quitar producto del carrito');
            return back();
        }
    }
}
