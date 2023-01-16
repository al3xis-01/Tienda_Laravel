<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAltaProductoRequest;
use App\Http\Requests\UpdateAltaProductoRequest;
use App\Models\alta_producto_detalle;
use App\Models\AltaProducto;
use App\Models\Inventario;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;

class AltaProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View|JsonResponse|Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(AltaProducto::select('*'))
                ->addColumn('action', 'alta_producto.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('alta_producto.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View|Response
     */
    public function create()
    {
        return view('alta_producto.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAltaProductoRequest $request
     * @return RedirectResponse|Response
     */
    public function store(StoreAltaProductoRequest $request)
    {
        $request->validar();

        $alta = new AltaProducto();
        $alta->folio = 'AltaProducto_'.uniqid();
        $alta->fecha = Carbon::now();;
        $alta->motivo = $request->motivo;
        $alta->id_proveedor = $request->id_proveedor;
        $alta->descuento = $request->descuento;
        $alta->subtotal = $request->subtotal;
        $alta->total = $request->total;
        $alta->save();

        if ($productos = $request->producto){
            $precio_venta = $request->precio_venta;
            $precio_compra = $request->precio_venta;
            $existencia = $request->existencia;


            for ($i =0; $i < sizeof($productos); $i++) {

                $alta_producto_detalle = new alta_producto_detalle();
                $alta_producto_detalle->id_producto = $productos[$i];
                $alta_producto_detalle->id_alta = $alta->id;
                $alta_producto_detalle->cantidad = $existencia[$i];
                $alta_producto_detalle->precio_venta = $precio_venta[$i];
                $alta_producto_detalle->precio_compra = $precio_compra[$i];
                $alta_producto_detalle->save();

                if ($inventario = Inventario::where('id_producto','=',$productos[$i])->first()){
                    $inventario->existencia = $inventario->existencia + $existencia[$i];
                    $inventario->precio_venta = $precio_venta[$i];
                    $inventario->precio_compra = $precio_compra[$i];
                    $inventario->save();
                }else{
                    $inventario = new Inventario();
                    $inventario->id_producto = $productos[$i];
                    $inventario->id_alta = $alta->id;
                    $inventario->existencia = $existencia[$i];
                    $inventario->precio_venta = $precio_venta[$i];
                    $inventario->precio_compra = $precio_compra[$i];
                    $inventario->observaciones = '';
                    $inventario->save();
                }

            }
        }


        return redirect()->route('AltaProducto.index')
            ->with('success','Alta de Producto ha sido agregada correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param AltaProducto $altaProducto
     * @return Response
     */
    public function show(AltaProducto $altaProducto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AltaProducto $altaProducto
     * @return Response
     */
    public function edit(AltaProducto $altaProducto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAltaProductoRequest $request
     * @param AltaProducto $altaProducto
     * @return Response
     */
    public function update(UpdateAltaProductoRequest $request, AltaProducto $altaProducto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AltaProducto $altaProducto
     * @return Response
     */
    public function destroy(AltaProducto $altaProducto)
    {
        //
    }
}
