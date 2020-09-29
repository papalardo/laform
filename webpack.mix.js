const mix = require('laravel-mix');

var LiveReloadPlugin = require('webpack-livereload-plugin');

require('laravel-mix-tailwind');

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .tailwind()
    .webpackConfig({
        plugins: [
            new LiveReloadPlugin()
        ]
    });
