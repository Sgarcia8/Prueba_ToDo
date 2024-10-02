<?php

namespace App\Http\Controllers;

use App\Models\Note;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class NoteController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return[
            new Middleware('auth:sanctum')
        ];
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Obtén el usuario autenticado
        $user = $request->user();

        // Devuelve las notas asociadas con el usuario
        return Note::where('user_id', $user->id)->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // valida la solicitud
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'etiquetas' => 'required|string',
            'img_uri' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date|after:today',
        ]);

        // Crea una nueva nota 
        $note = $request->user()->notes()->create([
            'title' => $validateData['title'],
            'description' => $validateData['description'] ?? '',
            'user_id' => $request->user()->id, //Asocia la nota al usuario que la esta creando
            'etiquetas' => $validateData['etiquetas'],
            'img_uri' => $validateData['img_uri'],
            'fecha_vencimiento' => $validateData['fecha_vencimiento'],
        ]);

        return response()->json($note, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return $note; //Muestra una nota en especifico
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        Gate::authorize('modify', $note);
        // valida la solicitud
        $validateData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'etiquetas' => 'required|string',
            'img_uri' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date|after:today',
        ]);

        // Actualiza los campos de la nota
        $note -> update([
            'title' => $validateData['title'],
            'description' => $validateData['description'] ?? '',
            'user_id' => $request->user()->id, //Asocia la nota al usuario que la esta creando
            'etiquetas' => $validateData['etiquetas'],
            'img_uri' => $validateData['img_uri'],
            'fecha_vencimiento' => $validateData['fecha_vencimiento'],
        ]);

        return response()->json($note, 200); // Devolver la nota actualizada

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        Gate::authorize('modify', $note);
        
        $note->delete();

        return ['mensaje' => 'La nota fue eliminada' ];
    }
}
