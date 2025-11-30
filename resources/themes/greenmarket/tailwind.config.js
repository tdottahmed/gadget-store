/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './theme-views/**/*.blade.php',
        './public/assets/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                'primary-color': 'var(--primary-color)',
                'secondary-color': 'var(--secondary-color)',
            },
        },
    },
    plugins: [],
    // Important: This ensures Tailwind only affects the greenmarket theme
    // and doesn't interfere with Bootstrap in other themes
    important: false,
    corePlugins: {
        preflight: true,
    },
}

