<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoriaRequest;
use App\Models\Categoria;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|JsonResponse|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Categoria::select('*'))
                ->addColumn('action', 'categorias.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('categorias.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('categorias.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoriaRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoriaRequest $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required'
        ]);
        $categoria = new Categoria;
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        return redirect()->route('Categoria.index')
            ->with('success','Categoria ha sido actualizada correctamente.');
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
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);
        $categoria = Categoria::find($id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        return redirect()->route('Categoria.index')
            ->with('success','Categoria Has Been updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Categoria $categoria
     * @return Application|Factory|View
     */
    public function show(Categoria $categoria)
    {
        return view('categorias.show',compact('categoria'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $categoria
     * @return Application|Factory|View
     */
    public function edit(int $categoria)
    {
        $categoria = Categoria::find($categoria);
        return view('categorias.edit',compact('categoria'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $com = Categoria::where('id',$request->id)->delete();
        return Response()->json($com);
    }

    public function list_combo(){
        $prov = Categoria::get();
        return Response()->json($prov);
    }
}
