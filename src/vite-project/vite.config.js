import vue from '@vitejs/plugin-vue2'
import path from "path";

export default {
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
  plugins: [vue()],
  base: '',
  server: {
    proxy: {
      '/api/': {
        target: 'https://ticketing.stage.tmdhosting.com/admin/',
        headers: { cookie: 'WHMCSBaCqM4Y33YVw=pktcb0q5m3r1m9ve5ijb6dfs5l' },
        changeOrigin: true,
        rewrite: (path) => path.replace(/^\/api/, ''),
        secure: false,
        configure: (proxy, _options) => {
          proxy.on('error', (err, _req, _res) => {
            console.log('proxy error', err);
          });
          proxy.on('proxyReq', (proxyReq, req, _res) => {
            console.log('Sending Request to the Target:', req.method, req.url);
          });
          proxy.on('proxyRes', (proxyRes, req, _res) => {
            console.log('Received Response from the Target:', proxyRes.statusCode, req.url);
          });
        },
      },
    }
  }
}