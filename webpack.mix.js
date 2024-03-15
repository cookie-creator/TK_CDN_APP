const mix = require('laravel-mix');

// mix.js('resources/js/app.js', 'public/js')
//     .sass('resources/sass/app.scss', 'public/css');

mix.sass('resources/sass/app.scss', 'public/css')
    .js('resources/assets/js/app.js', 'public/js').vue()
