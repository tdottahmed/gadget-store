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

// Copy Slick Carousel CSS and JS for Greenmarket theme
// Note: These are copied manually or via npm script to avoid webpack compilation issues
// Run: npm run copy-assets (if script exists) or copy manually
// mix.copy('node_modules/slick-carousel/slick/slick.css', 'public/themes/greenmarket/assets/css/slick.css')
//    .copy('node_modules/slick-carousel/slick/slick-theme.css', 'public/themes/greenmarket/assets/css/slick-theme.css')
//    .copy('node_modules/slick-carousel/slick/slick.min.js', 'public/themes/greenmarket/assets/js/slick.min.js')
//    .copy('node_modules/slick-carousel/slick/fonts/', 'public/themes/greenmarket/assets/css/fonts/');

// Copy FontAwesome CSS and fonts for Greenmarket theme
// mix.copy('node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/themes/greenmarket/assets/css/fontawesome.min.css')
//    .copy('node_modules/@fortawesome/fontawesome-free/webfonts/', 'public/themes/greenmarket/assets/webfonts/');

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
