<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Observacion;
use App\Categoria;
use App\Carrera;
use Auth;
use App\Observacion_usuario_estudiante;
use App\Estudiante;

class ObservacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $observaciones=Observacion::all();
        return view('estudiante.show',compact('observaciones'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $categorias=Categoria::all();
        $carrera=Carrera::find($request->get('id'));
        $modulos=$carrera->modulos();
        return view ('observacion.create', compact('modulos', 'categorias'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id, Request $request)
    {

        $validate=$request->validate([
            'titulo'=>'required|string|max:255',
            'tipo_observacion'=>'required|string|max:15',
            'descripcion'=>'required|string|max:2000',
            'id_categoria'=>'required|string|max:255',
            'modulo'=>'required|string|max:255',
        ]);

    $observacion=new Observacion();
    $observacion->titulo=$request->get('titulo');
    $observacion->tipo_observacion=$request->get('tipo_observacion');
    $observacion->descripcion=$request->get('descripcion');
    $categoria=Categoria::find($request->get('id_categoria'));
    $observacion->nombre_categoria=$categoria->nombre;
    $observacion->id_categoria=$categoria->id;
    $observacion->modulo=$request->get('modulo');
    $observacion->id_autor =  Auth::user()->id;
    $observacion->nombre_autor = Auth::user()->name;

    $observacion->save();
    
    
    Observacion_usuario_estudiante::create([
        'id_usuario'=> Auth::user()->id,
        'id_observacion' => $observacion->id,
        'id_estudiante' => $id,
    ]);
    $estudiante = Estudiante::find($id);
    $estudiante->num_observaciones +=1;
    $estudiante->save();

    return redirect()->action('EstudianteController@show', $id)
        ->with('success','Observacion ingresada con éxito'); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $observacion = Observacion::find($id);
        #falta agregar los módulos y categorias
        return view('observacion.edit',compact('observacion'));
    
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validate=$request->validate([
            'titulo_edit'=>'required|string|max:255',
            'tipo_edit'=>'required|string|max:15',
            'descripcion_edit'=>'required|string|max:2000',
            'categoria_edit'=>'required|string|max:255',
            'modulo_edit'=>'required|string|max:255',
        ]);

    $observacion=Observacion::find($request->get('id_edit'));
    $observacion->titulo=$request->get('titulo_edit');
    $observacion->tipo_observacion=$request->get('tipo_edit');
    $observacion->descripcion=$request->get('descripcion_edit');
    $observacion->nombre_categoria=$request->get('categoria_edit');
    $observacion->modulo=$request->get('modulo_edit');
    $observacion->id_autor =  Auth::user()->id;
    $observacion->nombre_autor = Auth::user()->name;

    $observacion->save();

    return redirect()->action('EstudianteController@show', $id)
    ->with('success','Observacion modificada con éxito'); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $estudiante = Estudiante::find($id);
        $estudiante->num_observaciones -=1;
        $estudiante->save();

        Observacion::find($request->get('id_observacion_eliminar'))->delete();
        return redirect()->action('EstudianteController@show', $id)
        ->with('success','Observacion eliminada con éxito'); 
    }
}
