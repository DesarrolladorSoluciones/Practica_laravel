import React, { useState, useEffect } from 'react';
import { createRoot } from 'react-dom/client';

function App() {
    const [tareas, setTareas] = useState([]);
    const [cargando, setCargando] = useState(true);

    // 1. Cargar tareas al iniciar
    useEffect(() => {
        obtenerTareas();
    }, []);

    const obtenerTareas = () => {
        fetch('/tasks', { headers: { 'Accept': 'application/json' } })
            .then(res => res.json())
            .then(data => {
                setTareas(data);
                setCargando(false);
            });
    };

    if (cargando) return <p className="text-center mt-10">Cargando tareas...</p>;

    return (
        <div className="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow-lg">
            <h1 className="text-3xl font-bold mb-6 text-blue-600">Lista de Tareas</h1>

            {/* Formulario de Nueva Tarea (Versión React) */}
            <div className="mb-8 p-6 bg-gray-50 rounded-lg border">
                <h2 className="text-xl font-bold mb-4">Nueva Tarea</h2>
                <div className="flex flex-col gap-4">
                    <input type="text" placeholder="Título de la tarea" className="border p-2 rounded" id="new-title" />
                    <textarea placeholder="Descripción (opcional)" className="border p-2 rounded" id="new-desc"></textarea>
                    <button className="bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Guardar Tarea (Próximamente funcional)
                    </button>
                </div>
            </div>

            {/* Tabla con tu diseño original */}
            <table className="w-full border-collapse">
                <thead>
                    <tr className="bg-blue-500 text-white">
                        <th className="p-3 text-left">Título</th>
                        <th className="p-3 text-left">Descripción</th>
                        <th className="p-3 text-left">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    {tareas.map(tarea => (
                        <tr key={tarea.id} className={`border-b ${tarea.is_completed ? 'opacity-50 line-through' : ''}`}>
                            <td className="p-3">{tarea.title}</td>
                            <td className="p-3 text-gray-600">{tarea.description}</td>
                            <td className="p-3">
                                <button className={`px-3 py-1 rounded text-white ${tarea.is_completed ? 'bg-green-500' : 'bg-gray-400'}`}>
                                    {tarea.is_completed ? '✔ Hecho' : 'Pendiente'}
                                </button>
                                <button className="ml-4 text-red-600 font-bold">Eliminar</button>
                            </td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>
    );
}

const root = createRoot(document.getElementById('root'));
root.render(<App />);