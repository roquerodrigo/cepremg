let mix = require('laravel-mix');

mix
    .options({
        uglify: {
            comments: false
        }
    })
    .setPublicPath('./public/')
    .less('./resources/assets/less/app.less', 'css/app.less.css')
    .sass('./resources/assets/scss/app.scss', 'css/app.scss.css')
    .combine([
        './public/css/app.less.css',
        './public/css/app.scss.css'
    ], './public/css/app.css')
    .js('./resources/assets/js/app.js', 'js')
    .autoload({
        'jquery': ['$', 'window.jQuery', 'jQuery'],
        'moment': 'moment',
        'highcharts': ['Highcharts']
    });
