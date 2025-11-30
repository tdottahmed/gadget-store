const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css');

// Compile Tailwind CSS for Greenmarket theme
// Note: This requires tailwindcss, autoprefixer, and postcss to be installed
// Run: npm install -D tailwindcss autoprefixer postcss
if (mix.inProduction()) {
    // In production, compile Tailwind CSS for greenmarket theme
    // This is scoped to only the greenmarket theme and won't affect Bootstrap themes
    try {
        mix.postCss('resources/themes/greenmarket/public/assets/css/tailwind.css', 
                    'resources/themes/greenmarket/public/assets/css/tailwind.css', 
                    [
                        require('tailwindcss')('./resources/themes/greenmarket/tailwind.config.js'),
                        require('autoprefixer'),
                    ])
           .options({
               processCssUrls: false
           });
    } catch (e) {
        console.log('Tailwind CSS compilation skipped - dependencies may not be installed');
    }
}
