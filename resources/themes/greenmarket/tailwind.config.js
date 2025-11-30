/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './theme-views/**/*.blade.php',
        './public/assets/js/**/*.js',
        './templates/**/*.html',
    ],
    theme: {
        extend: {
            colors: {
                'primary-green': '#003315',
                'primary-light': '#cae9d7',
                'primary-light-green': '#4caf50',
                'primary-neon': '#39ff14',
                'primary-neon-green': '#39ff14',
                'primary-semi-dark': '#25b672',
                'primary-dark': '#000f06',
                'primary-dark-green': '#1b3a2c',
                'secondary-gold': '#d4af37',
                'secondary-amber': '#ffa500',
                'secondary-brown': '#8b4513',
                'neutral-off-white': '#f8f9fa',
                'neutral-light-gray': '#e9ecef',
                'neutral-gray': '#6c757d',
                'neutral-dark-gray': '#495057',
            },
            fontFamily: {
                'primary': ['Inter', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'sans-serif'],
                'secondary': ['Poppins', 'sans-serif'],
                'display': ['Playfair Display', 'serif'],
            },
            maxWidth: {
                'container-ds': '1240px',
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

