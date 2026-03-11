<?php

namespace App\Http\Controllers;

use App\Models\Task; // Importante: Esto conecta el controlador con la tabla
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Muestra la lista de tareas.
     */
    /*public function index()
    {
        // Trae todas las tareas de la base de datos
        $tasks = Task::all();
        //return response()->json($tasks); //json unicode
        return view('tareas.index', compact('tasks')); // Esto es para mostrar las tareas en una vista blade (que crearemos después)
    }*/

    public function index(Request $request)
    {
        $tasks = Task::all();

        // Si la URL es /tasks y pides JSON (desde React)
        if ($request->wantsJson()) {
            return response()->json($tasks);
        }

        // Si entras normal por el navegador
        // Si quieres usar REACT, deja 'react'. Si quieres usar BLADE, deja 'tareas.index'
        return view('react'); 
    }

    public function store(Request $request)
    {
        // 1. Definimos las reglas
        $request->validate([
            'title' => 'required|min:3|max:100', // Obligatorio, mínimo 3 letras, máximo 100
            'description' => 'nullable|max:500',  // Opcional, máximo 500
        ], [
            // Mensajes personalizados (opcional, pero se ve mejor)
            'title.required' => '¡Oye! No puedes dejar la tarea sin título.',
            'title.min' => 'El título es muy corto, pon al menos 3 letras.',
        ]);

        // 2. Si la validación pasa, se guarda
        Task::create($request->all());

        // 3. Redirigimos con un mensaje de éxito (Flash Message)
        return redirect()->route('tasks.index')->with('success', '¡Excelente! Tarea guardada correctamente.');
    }

    public function update(Task $task)
    {
        $task->update(['is_completed' => !$task->is_completed]);

        return redirect()->back()->with('success', 'Estado actualizado');
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Tarea eliminada');
    }
}