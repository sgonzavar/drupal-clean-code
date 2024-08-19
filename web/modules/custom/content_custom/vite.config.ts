import { defineConfig } from 'vite';
import react from '@vitejs/plugin-react';
import path from 'path';

export default defineConfig({
  plugins: [react()],
  build: {
    lib: {
      entry: path.resolve(__dirname, 'web/modules/custom/custom_content/js/src/index.tsx'),
      name: 'ArticlesApp',
      fileName: (format) => `articles-app.${format}.js`,
    },
    outDir: 'web/modules/custom/custom_content/js/dist',
    emptyOutDir: true,
  },
});
