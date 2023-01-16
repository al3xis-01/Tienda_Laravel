<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Producto;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|JsonResponse|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Producto::select('*'))
                ->addColumn('action', 'productos.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('productos.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProductoRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProductoRequest $request)
    {
        if ($image_path = $request->file('imagen')){
            $image_path->store('image', 'public');
        }
        $request->validar();
        $producto = new Producto;
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio_venta = $request->precio_venta;
        $producto->minimo = $request->minimo;
        $producto->maximo = $request->maximo;
        $producto->fecha_caducidad = $request->fecha_caducidad;
        $producto->id_categoria = $request->id_categoria;

        $producto->save();
        return redirect()->route('Producto.index')
            ->with('success','Producto ha sido actualizada correctamente.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateProductoRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateProductoRequest $request, $id)
    {
        $request->validar();
        $producto = Producto::find($id);
        $producto->nombre = $request->nombre;
        $producto->descripcion = $request->descripcion;
        $producto->precio_venta = $request->precio_venta;
        $producto->minimo = $request->minimo;
        $producto->maximo = $request->maximo;
        $producto->fecha_caducidad = $request->fecha_caducidad;
        $producto->id_categoria = $request->id_categoria;
        $producto->save();
        return redirect()->route('Producto.index')
            ->with('success','Producto Has Been updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Producto $producto
     * @return Application|Factory|View
     */
    public function show(Producto $producto)
    {
        return view('productos.show',compact('producto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $producto
     * @return Application|Factory|View
     */
    public function edit(int $producto)
    {
        $producto = Producto::find($producto);
        return view('productos.edit',compact('producto'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $com = Producto::where('id',$request->id)->delete();
        return Response()->json($com);
    }

    public function list_combo(){
        $prov = Producto::get();
        return Response()->json($prov);
    }

}
