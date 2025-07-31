import tailwindcss from '@tailwindcss/vite';
import laravel, { refreshPaths } from 'laravel-vite-plugin';
import { resolve } from 'path';
import { defineConfig } from 'vite';

export default defineConfig({
  build: {
    outDir: 'public',
    emptyOutDir: false,
    manifest: 'assets/manifest.json',
  },
  plugins: [
    tailwindcss(),
    laravel({
      input: ['resources/client/tailwind.css', 'resources/client/app.ts'],
      refresh: [...refreshPaths, 'Inkwell/views/**'],
    }),
  ],
  resolve: {
    alias: {
      '@vendor': resolve(__dirname, 'vendor/'),
    },
  },
});
