<!DOCTYPE html>
<html>
<head>
    <title>Mis Tareas</title>
    <style>
        body { font-family: sans-serif; padding: 50px; background: #f4f4f4; }
        .container { background: white; padding: 20px; border-radius: 8px; shadow: 0 2px 4px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 12px; border-bottom: 1px solid #ddd; }
        th { background-color: #4A90E2; color: white; }
        .status { padding: 5px 10px; border-radius: 4px; font-size: 0.8em; }
        .pending { background: #ffeeba; color: #856404; }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="container">

    @if (session('success'))
        <div id="alert-success" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="font-bold">&times;</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="mb-8 p-6 bg-white rounded-lg shadow-md">
            <h2 class="text-xl font-bold mb-4">Nueva Tarea</h2>
            <form action="{{ route('tasks.store') }}" method="POST">
                @csrf
                <div class="flex flex-col gap-4">
                    <input type="text" name="title" 
                        placeholder="Título de la tarea" 
                        class="border p-2 rounded @error('title') border-red-500 @enderror" 
                        value="{{ old('title') }}">
                    <textarea name="description" placeholder="Descripción (opcional)" class="border p-2 rounded"></textarea>
                    <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Guardar Tarea
                    </button>
                </div>
            </form>
        </div>

        <h1>Lista de Tareas</h1>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasks as $task)
                    <tr class="{{ $task->is_completed ? 'opacity-50 line-through' : '' }}">
                        <td class="p-3">{{ $task->title }}</td>
                        <td class="p-3 text-gray-600">{{ $task->description }}</td>
                        <td class="p-3">
                            <form action="{{ route('tasks.update', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="px-3 py-1 rounded text-white {{ $task->is_completed ? 'bg-green-500' : 'bg-gray-400' }}">
                                    {{ $task->is_completed ? '✔ Hecho' : 'Pendiente' }}
                                </button>
                            </form>

                            <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="ml-2 text-red-600 hover:text-red-900 font-bold" onclick="return confirm('¿Seguro que quieres borrarla?')">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>