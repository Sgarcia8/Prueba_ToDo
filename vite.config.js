import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
        server: {
            https: true
        },
        build: {
            manifest: true,
            outDir: 'public/build',
            rollupOptions: {
                input: '/resources/js/app.js',
            },
        },
        plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
});
