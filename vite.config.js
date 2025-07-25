import { defineConfig } from 'vite';
import jigsaw from '@tighten/jigsaw-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        jigsaw({
            input: [
                'source/_assets/js/main.js',
                'source/_assets/css/main.css'
            ],
            refresh: {
                files: [
                    'config.php',
                    'bootstrap.php',
                    'listeners/**/*.php',
                    'source/**/*.md',
                    'source/**/*.php',
                    'source/**/*.html',
                    'source/**/*.css',
                    'source/**/*.js',
                ],
                ignored: [
                    'build_**/**',
                    'cache/**',
                    'source/**/_tmp/*',
                ],
            },
        }),
        tailwindcss()
    ],
});