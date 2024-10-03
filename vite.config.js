import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
            }),
            vue(),
        ],
        // Asegúrate de que Vite utilice HTTPS en producción
        base: mode === 'production' ? 'https://pruebatodo-production.up.railway.app/' : '/',
    ],
});
