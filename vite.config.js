import { defineConfig } from 'vite';
import path from 'path';

export default defineConfig({
    build: {
        outDir: path.resolve(__dirname, 'assets/css'),
        emptyOutDir: false, // Don't empty the directory, we might have other files there
        rollupOptions: {
            input: path.resolve(__dirname, 'assets/css/src/input.css'),
            output: {
                entryFileNames: `[name].js`,
                chunkFileNames: `[name].js`,
                assetFileNames: `[name].[ext]`
            }
        }
    },
    // Plugin to handle full page reload on PHP file changes
    plugins: [
        {
            name: 'php',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.php')) {
                    server.ws.send({ type: 'full-reload' });
                }
            },
        },
    ],
});
