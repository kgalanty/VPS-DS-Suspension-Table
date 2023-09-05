import vue from '@vitejs/plugin-vue2'
import path from "path";

const htmlPlugin = () => {
  return {
    name: 'html-transform',
    transformIndexHtml(html) {
      return html.replace(
        /<title>(.*?)<\/title>/,
        `<title>VPS/DS Suspension Table</title>`
      )
    },

  }
}

export default {
  resolve: {
    alias: {
      "@": path.resolve(__dirname, "./src"),
    },
  },
  plugins: [
    vue(),
    htmlPlugin()
    // Custom inline Vite plugin
    // Using Vite's transformIndexHtml() hook, for certain env flag, we overwrite index.html's content with another file.
    // {
    //   name: 'index-html-build-replacement',
    //   apply: 'build', // Only use apply if you need it only for that state. See docs: https://vitejs.dev/guide/api-plugin.html#conditional-application
    //   async transformIndexHtml() {
    //       return await fs.readFile('./index.html', 'utf8')
    //   }
    // }
  ],
  base: process.env.NODE_ENV === 'production' ? 'modules/addons/VPSDSSuspensionTable/lib/app/Views' : '',
  indexPath: 'home@index.tpl',
  server: {
    proxy: {
      '/addonmodules.php': {
        target: 'https://my.tmdhosting.com/admin/',
        headers: { cookie: 'WHMCSBaCqM4Y33YVw=l7irn8m8re908f1pleb8dij9b3' },
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