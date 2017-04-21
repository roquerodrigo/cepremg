let mix = require('laravel-mix');

mix.less('resources/assets/less/app.less', 'public/assets/css')
    .combine([
        'node_modules/jquery/dist/jquery.js',
        'node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        'node_modules/angular/angular.js',
        'node_modules/highcharts/js/highcharts.js',
        'node_modules/highcharts-ng/dist/highcharts-ng.js',
        'resources/assets/js/app.js'
    ], 'public/assets/js/app.js');
