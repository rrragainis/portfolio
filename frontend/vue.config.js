const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  transpileDependencies: true,
  publicPath: '/',
  assetsDir: 'static',
  productionSourceMap: false,
  configureWebpack: {
    resolve: {
      fallback: {
        "events": require.resolve("events/"),
        "path": false,
        "fs": false,
        "crypto": false
      }
    }
  }
})
