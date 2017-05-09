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
    .combine([
        'node_modules/moment/moment.js',
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        'node_modules/angular/angular.js',
        'node_modules/highcharts/js/highcharts.js',
        'node_modules/highcharts-ng/dist/highcharts-ng.js',
        'node_modules/bootstrap-daterangepicker/daterangepicker.js',
        'node_modules/angular-daterangepicker/js/angular-daterangepicker.js',
        'resources/assets/js/app.js'
    ], 'public/js/app.js');
