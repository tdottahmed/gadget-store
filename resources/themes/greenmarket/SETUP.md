# Greenmarket Theme Setup Guide

## Overview

The Greenmarket theme is a modern, Tailwind CSS-based theme for the Gadget Store application. It's designed to be completely isolated from Bootstrap-based themes, ensuring no conflicts.

## Quick Start

### 1. Install Dependencies

From the project root, install Tailwind CSS dependencies:

```bash
npm install -D tailwindcss autoprefixer postcss
```

### 2. Build Tailwind CSS

You have two options:

**Option A: Using the build script (Recommended)**
```bash
cd resources/themes/greenmarket
./build.sh
```

**Option B: Using npm scripts**
```bash
npm run dev
# or for production
npm run production
```

**Option C: Using Tailwind CLI directly**
```bash
cd resources/themes/greenmarket
npx tailwindcss -i ./public/assets/css/tailwind.css -o ./public/assets/css/tailwind.css --minify
```

### 3. Activate the Theme

1. Go to Admin Panel → System Setup → Themes
2. Find "Greenmarket Theme" in the theme list
3. Click "Publish" to activate the theme

## Theme Structure

```
greenmarket/
├── file_names.php                    # View file mappings
├── tailwind.config.js                # Tailwind configuration
├── postcss.config.js                 # PostCSS configuration
├── build.sh                          # Build script
├── README.md                         # Theme documentation
├── public/
│   ├── addon/
│   │   ├── info.php                  # Theme metadata
│   │   └── theme_routes.php         # Theme routes
│   └── assets/
│       ├── css/
│       │   ├── tailwind.css         # Tailwind source (input)
│       │   └── custom.css           # Custom styles
│       ├── js/
│       │   └── main.js              # Theme JavaScript
│       └── img/                     # Theme images
└── theme-views/
    ├── layouts/
    │   ├── app.blade.php            # Main layout
    │   └── partials/                # Layout partials
    ├── home.blade.php               # Home page
    └── partials/                   # View partials
```

## Key Features

- **Tailwind CSS**: Modern utility-first CSS framework
- **Isolated**: No conflicts with Bootstrap themes
- **Responsive**: Mobile-first design
- **Customizable**: Colors configured via system settings
- **Clean Code**: Well-organized, maintainable structure

## Development

### Modifying Styles

1. Edit Tailwind classes directly in Blade templates
2. Add custom CSS in `public/assets/css/custom.css`
3. Rebuild: `npm run dev` or use the build script

### Adding New Views

1. Create Blade files in `theme-views/`
2. Add view mappings to `file_names.php`
3. Use the layout: `@extends('theme-views.layouts.app')`

## Color Configuration

The theme uses CSS variables that are automatically set from system configuration:

- Primary Color: Set in Admin → Business Settings
- Secondary Color: Set in Admin → Business Settings

These are applied via `--primary-color` and `--secondary-color` CSS variables.

## Notes

- Tailwind CSS is compiled separately and only affects this theme
- Bootstrap themes (default, theme_aster) remain unaffected
- The theme follows the same structure as other themes for consistency
- All Laravel helpers and functions work as expected

## Troubleshooting

**Issue: Styles not applying**
- Make sure Tailwind CSS is compiled: Run `./build.sh` or `npm run dev`
- Clear browser cache
- Check that the theme is activated in admin panel

**Issue: Build errors**
- Ensure all dependencies are installed: `npm install -D tailwindcss autoprefixer postcss`
- Check Node.js version (requires Node 14+)

**Issue: Theme not showing**
- Verify theme is activated in Admin → System Setup → Themes
- Clear Laravel cache: `php artisan cache:clear` and `php artisan view:clear`
- Check `.env` file has correct `WEB_THEME=greenmarket`

## Support

For issues or questions, refer to the main project documentation or contact the development team.

