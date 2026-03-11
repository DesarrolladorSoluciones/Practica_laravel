
import React from 'react';
import { createRoot } from 'react-dom/client';

// Este es un pequeño componente de prueba
function Saludo() {
    return (
        <div style={{ padding: '20px', background: '#4F46E5', color: 'white', borderRadius: '8px', fontFamily: 'sans-serif' }}>
            <h1>¡React está funcionando! 🚀</h1>
            <p>Laravel y Vite lo han cargado correctamente prueba de cambio en tiempo real.</p>
        </div>
    );
}

const root = createRoot(document.getElementById('root'));
root.render(<Saludo />);