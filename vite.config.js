import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import vuetify from 'vite-plugin-vuetify';

export default defineConfig({
  //   server: {
  //     hmr: {
  //       host: 'localhost',
  //     },
  //   },
  //   server: {
  //     host: 'localhost', // Add this to force IPv4 only
  //     port: 5173,
  //   },
  plugins: [
    laravel({
      input: 'resources/js/app.js',
      ssr: 'resources/js/ssr.js',
      refresh: true,
    }),
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
    vuetify(),
  ],
});
