<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarritoModel;
use App\Models\DetalleCarritoModel;
use App\Models\DetalleVentaModel;
use App\Models\TarjetasModel;
use App\Models\VentaModel;
use Illuminate\Support\Facades\DB;

class VentasController extends Controller
{
    public function crearventa(Request $request)
    {
        $carrito = CarritoModel::find($request->id);
        $detallec = DetalleCarritoModel::where('id_carrito', $carrito->id)->get();
        $usuario = auth()->user();
        $tarjetas = TarjetasModel::where('user_id', $usuario->id)->first();

        DB::beginTransaction();
        try{
            if(!$tarjetas)
            {
                $venta = VentaModel::create([
                    'fecha' => date('Y-m-d'),
                    'subtotal' => null,
                    'iva' => null,
                    'total' => null,
                    'usuario_id' => null,
                ]);
            }else
            {
                $venta = VentaModel::create([
                    'fecha' => date('Y-m-d'),
                    'subtotal' => $carrito->subtotal,
                    'iva' => $carrito->iva,
                    'total' => $carrito->total,
                    'usuario_id' => $carrito->id_user,
                ]);
            }

            DB::commit();
            foreach($detallec as $detalle)
            {
                $dventa = DetalleVentaModel::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $detalle->id_producto,
                    'cantidad' => $detalle->cantidad,
                ]);
            }

            $carrito->delete();
            $detallec->each->delete();

            DB::commit();
            notify()->success('Venta creada con éxito');
            return back();
        }catch(\Exception $e){
            DB::rollback();
            dd($e);
            notify()->error('Error al crear la venta (puede que falte registrar su tarjeta)');
            return back();
        }
    }

    public function agregarTarjeta()
    {
        $usuario = auth()->user();
        $tarjetas = TarjetasModel::where('user_id', $usuario->id)->first();
        return view('ventas.agregartarjeta', compact('tarjetas','usuario'));
    }

    public function agregarTarjetap(Request $request)
    {
        $request->validate([
            'card_number' => 'required|min:16',
            'card_cvv' => 'min:3',
            'card_type' => 'required',
            'card_expiration'=> 'required',
        ]);

        DB::beginTransaction();
        try{
            TarjetasModel::create([
                'card_number' => $request->card_number,
                'card_cvv' => $request->card_cvv,
                'card_type' => $request->card_type,
                'card_expiration' => $request->card_expiration,
                'user_id' => $request->user_id,
            ]);

            DB::commit();
            notify()->success('Tarjeta agregada con éxito');
            return back();
        }catch(\Exception $e){
            DB::rollback();
            notify()->error('Error al agregar la tarjeta');
            return back();
        }
    }

    public function verventas()
    {
        $usuario = auth()->user();
        $ventas = VentaModel::where('usuario_id', $usuario->id)->get();
        return view('ventas.verventas', compact('ventas'));
    }
}
