import { defineConfig } from 'vite';
import laravel, {refreshPaths} from 'laravel-vite-plugin';

export default defineConfig({
    css: {
        postcss: './postcss.config.cjs'
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js', // Your JS entry
                'resources/css/app.css' // Ensure this path is correct
            ],
            refresh: [
                ...refreshPaths,
                'app/Livewire/**',
            ],
        }),
    ],
});
