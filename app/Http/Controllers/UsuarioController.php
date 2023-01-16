<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUsuarioRequest;
use App\Http\Requests\UpdateUsuarioRequest;
use App\Models\Cliente;
use App\Models\Usuario;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|JsonResponse|View
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Usuario::select('*'))
                ->addColumn('action', 'usuarios.action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('usuarios.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('usuarios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUsuarioRequest $request
     * @return RedirectResponse
     */
    public function store(StoreUsuarioRequest $request)
    {
        $request->validar();
        $usuario = new Usuario;
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->username = $request->username;
        $usuario->password = password_hash($request->password,PASSWORD_DEFAULT);
        $usuario->tipo = $request->tipo;
        $usuario->estado = 1;

        try {
            $usuario->save();
        }catch (\Exception $e){
            return redirect()->route('Usuario.create')->withErrors('status',$e->getMessage());
        }

        if ($usuario->tipo === 'USER')
        {
            $cliente = new Cliente();
            $cliente->id_usuario = $usuario->id;
            $cliente->save();
        }
        return redirect()->route('Usuario.index')
            ->with('success','Usuario ha sido actualizada correctamente.');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUsuarioRequest $request
     * @param $id
     * @return RedirectResponse
     */
    public function update(UpdateUsuarioRequest $request, $id)
    {
        $request->validar();
        $usuario = Usuario::find($id);
        $usuario->nombre = $request->nombre;
        $usuario->apellido = $request->apellido;
        $usuario->email = $request->email;
        $usuario->username = $request->username;
        //$usuario->password = password_hash($request->password,PASSWORD_DEFAULT);
        $usuario->tipo = $request->tipo;
        //$usuario->estado = 1;
        $usuario->save();
        return redirect()->route('Usuario.index')
            ->with('success','Usuario Has Been updated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Usuario $usuario
     * @return Application|Factory|View
     */
    public function show(Usuario $usuario)
    {
        return view('usuarios.show',compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $usuario
     * @return Application|Factory|View
     */
    public function edit(int $usuario)
    {
        $usuario = Usuario::find($usuario);
        return view('usuarios.edit',compact('usuario'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function destroy(Request $request)
    {
        $com = Usuario::where('id',$request->id)->delete();
        return Response()->json($com);
    }
}
