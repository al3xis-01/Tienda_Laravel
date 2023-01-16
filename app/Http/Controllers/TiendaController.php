<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Cliente;
use App\Models\DetalleVenta;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;

class TiendaController extends Controller
{

    /**
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        return view('tienda.index');
    }

    public function showSecciones(): Factory|View|Application
    {
        return view('tienda.secciones');
    }

    public function searchProductoByCetegoria(Request $request,int $id):Factory|View|Application{
        $categoria = Categoria::find($id);
        return view('tienda.producto_categoria',compact('categoria'));
    }

    public function store(Request $request){
        $venta = new Venta();
        $cliente = Cliente::where('id_usuario','=',auth()->user()->id)->first();
        $venta->folio = 'Venta_'.uniqid();
        $venta->id_cliente =$cliente->id;
        $venta->estado_venta = 'PENDIENTE';
        $venta->fecha = Carbon::now();
        $venta->subtotal = $request->subtotal;
        $venta->total = $request->total;
        $venta->save();
        for ($i = 0; $i < sizeof($request->inventario); $i++){
            $detalle_venta = new DetalleVenta();
            $detalle_venta->id_venta = $venta->id;
            $detalle_venta->id_inventario = $request->inventario[$i];
            $detalle_venta->cantidad = $request->existencia[$i];
            $detalle_venta->descuento = 0;
            $detalle_venta->precio_venta = $request->precio_venta[$i];
            $detalle_venta->total = $request->total_p[$i];
            $detalle_venta->save();

            $inventario = Inventario::find((int) $request->inventario[$i]);
            $inventario->existencia = $inventario->existencia - $request->existencia[$i];
            $inventario->save();
        }

        $venta = $venta->toArray();
        return redirect()->route('Tienda.index')
            ->with('success',compact('venta'));
    }

    public function getTicket($id){

        $venta = Venta::find($id);

        $cliente = Usuario::find(Cliente::find($venta->id_cliente)->first()->id_usuario);

        $Ticket = '
       <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<div class="container-fluid">
    <div class="row text-center">Empresa x</div>
    <div class="row text-center" >Ticket de Venta</div>

    <div style="margin: 0 auto">
        Folio: FOLIO
    </div>
    <div style="margin: 0 auto">
       Cliente: CLIENTE
    </div>
    <div style="margin: 0 auto">
       Fecha:  FECHA_HORA
    </div>
    <div style="margin: 0 auto">
        ****************************************
        <table>
       <thead>
       <tr>
       <th>
       Producto
</th>
  <th>
       Cantidad
</th>
  <th>
       Precio
</th>
  <th>
       Total
</th>
</tr>
</thead>
<tbody>
PRODUCTOS
</tbody>

        </table>
        ****************************************
    </div>
    <div style="margin: 0 auto">
        Total: TOTAL
    </div>

</div>
</body>
</html>

        ';
        $Ticket = str_replace(['FOLIO','CLIENTE','FECHA_HORA','TOTAL'],
            [$venta->folio,$cliente->nombre,$venta->fecha,$venta->total],
            $Ticket);

        $detalle = DetalleVenta::where('id_venta','=',$venta->id)->get();
        $Productos = '';
        foreach ($detalle as $item) {
            $TAGS = [
              Producto::find(Inventario::find($item->id_inventario)->id_producto)->nombre,
              $item->cantidad,
              $item->precio_venta,
                $item->total
            ];

            $Productos .= str_replace(
             ['NOMBRE','CANTIDAD','PRECIO','TOTAL'],$TAGS,'
        <tr>
        <td>NOMBRE</td>
        <td>CANTIDAD</td>
        <td>PRECIO</td>
        <td>TOTAL</td>
</tr>');
        }
        $Ticket = str_replace('PRODUCTOS',$Productos,$Ticket);

        return Response()->json(['ticket'=>$Ticket]);
    }

}
