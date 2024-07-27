import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createVuetify } from 'vuetify';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

// Vuetify
import 'vuetify/styles';
import '@mdi/font/css/materialdesignicons.css';

const vuetify = createVuetify({
  ssr: true,
  icons: {
    defaultSet: 'mdi', // This is already the default value - only for display purposes
  },
  theme: {
    defaultTheme: 'light',
    themes: {
      light: {
        colors: {
          primary: '#00a65a', // Primary color
          secondary: '#8863f9', // Secondary color
          accent: '#00a65a', // Accent color
          error: '#FF5252', // Error color
          info: '#2196F3', // Info color
          success: '#4CAF50', // Success color
          warning: '#FFC107', // Warning color}
          greenlight: '#ddfff0',
          secondaryLight: '#ede9ff',
        },
      },
    },
  },
});

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => resolvePageComponent(
    `./Pages/${name}.vue`,
    import.meta.glob('./Pages/**/*.vue'),
  ),
  setup({
    el, App, props, plugin,
  }) {
    return createApp({ render: () => h(App, props) })
      .use(plugin)
      .use(ZiggyVue)
      .use(vuetify)
      .mount(el);
  },
  progress: {
    color: '#4B5563',
  },
});
