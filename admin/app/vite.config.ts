import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [vue()],
  build: {
    rollupOptions: {
      output: {
        entryFileNames: '[name].js',
        chunkFileNames: '[name].js',
        assetFileNames: '[name].[ext]',
      },
    },
    lib: {
      name: 'magicShortcodesBackOffice',
      entry: 'src/main.ts',
      formats: ['iife'],
    },
    minify: false,
    outDir: './../dist',
    emptyOutDir: false,
  },
})
