let Encore = require('@symfony/webpack-encore');

Encore
// the project directory where compiled assets will be stored

.setOutputPath('public/build/')

// the public path used by the web server to access the previous directory

.setPublicPath('/build')

.cleanupOutputBeforeBuild()

.enableSourceMaps(!Encore.isProduction())



// uncomment to define the assets of the project

.addEntry('js/app', './assets/js/app.js')

.addStyleEntry('css/app', './assets/css/app.scss')



// uncomment if you use Sass/SCSS files

.enableSassLoader()



// Enable Vue Loader

.enableVueLoader();

module.exports = Encore.getWebpackConfig();