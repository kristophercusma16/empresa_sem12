<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;#manual
use App\Models\Persona;
use App\Http\Requests\CreatePersonaRequest;
class PersonasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personas = Persona::orderBy('nPerCodigo','asc')->paginate(3);
        return view('personas',compact('personas'));
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    //metodo crear
    public function create()
    {
        return view('create',[
            'persona'=>new Persona
        ]);
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    //metodo store
    public function store(CreatePersonaRequest $request)
    {
        //obtener las variables validadas y se guarda a la BD
        // Persona::create($request->validated());
        //se muestra la lista
        // return redirect()->route('personas');
        //otro metodo cuando se crea una persona
        //OTRO METODO
        $persona = new Persona($request->validated());
        $persona->image = $request->file('image')->store('images');
        $persona->save();
        return redirect()->route('personas.index')->with('estado','La persona fue creada correctamente');
     

    }

    /**
     * Display the specified resource.
     */
    public function show(string $nPerCodigo)
    {
        // $persona = Persona::where('nPerCodigo', $nPerCodigo)->first();
        return view('show', [
            'persona' => Persona::find($nPerCodigo)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    //metodo editar
    public function edit(Persona $persona)
    {
        return view('editar',[
            'persona'=>$persona
        ]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    //metodo modificar
    public function update(Persona $persona, CreatePersonaRequest $request)
    {
        // $persona->update($request->validated());

        // return redirect()->route('personas.show',$nPerCodigo);
        // OTRO METODO:
        if($request->hasFile('image')) {// Si enviamos un imagen
            Storage::delete($persona->image); //LE PASAMOS LA UBICACION DE LA IMAGEN
            $persona->fill($request->validated()); //Rellena todos los datos sin guardarlos
            $persona->image = $request->file('image')->store('images'); //Le asignamos La imagen que sube
            $persona->save(); //Finalmente guardamos en La Base de datos
        }else{
            $persona->update( array_filter($request->validated()));
        }
        return redirect()->route('personas.show', $persona)->with('estado','La persona fue actualizada correctamente');
  
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    //metodo eliminar
    public function destroy(Persona $persona)
    {
        // return redirect()->route('personas');
        //otro metodo de eliminar
        Storage::delete($persona->image); //LE PASAMOS LA UBICACION DE LA IMAGEN
        
        $persona->delete();

        return redirect()->route('personas.index')->with('estado','La persona fue eliminada correctamente');
    }
    
    public function __construct(){
        // $this->middleware('auth')->only('create','edit');
        $this->middleware('auth')->except('index','show');

    }
   
}
