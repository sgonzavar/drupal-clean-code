import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  build: {
    lib: {
      entry: path.resolve(__dirname, 'web/modules/custom/mi_modulo/js/src/main.tsx'),
      name: 'ArticlesApp',
      fileName: (format) => `articles-app.${format}.js`,
    },
    outDir: 'web/modules/custom/mi_modulo/js/dist',
    emptyOutDir: true,
    rollupOptions: {
      output: {
        assetFileNames: (assetInfo) => {
          if (assetInfo.name === 'style.css') return 'articles-app.css';
          return assetInfo.name;
        },
      },
    },
  },
});
