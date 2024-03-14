import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/sass/app.scss',
                'resources/js/app.js',
                'resources/js/jquery.js',
                'node_modules/@ckeditor/ckeditor5-alignment/build/alignment.js',
            ],
            refresh: true,
        }),
    ],
});
