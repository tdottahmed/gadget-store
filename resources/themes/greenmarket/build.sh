#!/bin/bash
# Build script for Greenmarket Theme Tailwind CSS
# This script compiles Tailwind CSS for the greenmarket theme

echo "Building Tailwind CSS for Greenmarket Theme..."

# Check if node_modules exists
if [ ! -d "node_modules" ]; then
    echo "Installing dependencies..."
    npm install
fi

# Compile Tailwind CSS using npx
npx tailwindcss -i ./public/assets/css/tailwind.css -o ./public/assets/css/tailwind.css --minify

echo "Tailwind CSS compiled successfully!"

