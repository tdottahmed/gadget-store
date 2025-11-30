# Greenmarket Theme

A modern, Tailwind CSS-based theme for the Gadget Store application.

## Features

- Built with Tailwind CSS for modern, responsive design
- Fully scoped to prevent conflicts with Bootstrap-based themes
- Clean, minimal design
- Mobile-first responsive layout
- Customizable color scheme via theme configuration

## Installation

1. Install Tailwind CSS dependencies:
```bash
npm install -D tailwindcss autoprefixer postcss
```

2. Compile Tailwind CSS:
```bash
npm run dev
# or for production
npm run production
```

## Theme Structure

```
greenmarket/
├── file_names.php              # View file mappings
├── public/
│   ├── addon/
│   │   ├── info.php           # Theme information
│   │   └── theme_routes.php   # Theme routes configuration
│   ├── assets/
│   │   ├── css/
│   │   │   ├── tailwind.css   # Tailwind CSS source
│   │   │   └── custom.css     # Custom theme styles
│   │   ├── js/
│   │   │   └── main.js        # Theme JavaScript
│   │   └── img/               # Theme images
│   └── ...
├── theme-views/
│   ├── layouts/
│   │   ├── app.blade.php      # Main layout
│   │   └── partials/          # Layout partials
│   ├── home.blade.php         # Home page
│   └── ...
├── tailwind.config.js          # Tailwind configuration
└── postcss.config.js           # PostCSS configuration
```

## Configuration

The theme uses CSS variables for colors, which are set dynamically based on the system configuration:

- `--primary-color`: Primary brand color
- `--secondary-color`: Secondary brand color

These are automatically set from the web configuration in the layout file.

## Development

To modify the theme:

1. Edit the Blade templates in `theme-views/`
2. Modify Tailwind classes or add custom CSS in `public/assets/css/`
3. Recompile assets: `npm run dev` or `npm run watch`

## Notes

- This theme uses Tailwind CSS and does NOT use Bootstrap
- The theme is completely isolated from other themes
- Tailwind CSS is compiled separately and only affects this theme
- Existing Bootstrap themes will continue to work without any conflicts

