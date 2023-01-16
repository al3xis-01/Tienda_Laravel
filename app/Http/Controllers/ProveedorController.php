<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;
use App\Models\Proveedor;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|JsonResponse|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Proveedor::select('*'))
                ->addColumn('action', 'proveedores.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('proveedores.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreProveedorRequest $request
     * @return RedirectResponse
     */
    public function store(StoreProveedorRequest $request)
    {
        $request->validate([
            'nombre_completo' => 'required',
            'descripcion' => 'required',
            'email'=>'required',
            'tipo'=>'required'
        ]);
        $proveedor = new Proveedor;
        $proveedor->nombre_completo = $request->nombre_completo;
        $proveedor->descripcion = $request->descripcion;
        $proveedor->email = $request->email;
        $proveedor->tipo = $request->tipo;
        $proveedor->save();
        return redirect()->route('Proveedor.index')
            ->with('success','Proveedor ha sido actualizada correctamente.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre_completo' => 'required',
            'descripcion' => 'required',
            'email'=>'required',
            'tipo'=>'required'
        ]);
        $proveedor = Proveedor::find($id);
        $proveedor->nombre_completo = $request->nombre_completo;
        $proveedor->descripcion = $request->descripcion;
        $proveedor->email = $request->email;
        $proveedor->tipo = $request->tipo;
        $proveedor->save();
        return redirect()->route('Proveedor.index')
            ->with('success','Proveedor Has Been updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Proveedor $proveedor
     * @return Application|Factory|View
     */
    public function show(Proveedor $proveedor)
    {
        return view('proveedores.show',compact('proveedor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $proveedor
     * @return Application|Factory|View
     */
    public function edit(int $proveedor)
    {
        $proveedor = Proveedor::find($proveedor);
        return view('proveedores.edit',compact('proveedor'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $com = Proveedor::where('id',$request->id)->delete();
        return Response()->json($com);
    }

    public function list_combo(){
        $prov = Proveedor::get();
        return Response()->json($prov);
    }

}
