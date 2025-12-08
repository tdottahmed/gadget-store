// Main JavaScript file for Greenmarket Theme
// This file handles theme-specific JavaScript functionality

(function() {
    'use strict';

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Hide loading spinner
        const loading = document.getElementById('loading');
        if (loading) {
            loading.classList.add('hidden');
        }

        // Initialize any theme-specific functionality here
        initTheme();
    });

    function initTheme() {
        // Add any initialization code here
        console.log('Greenmarket theme initialized');
    }

    // Export functions if needed
    window.GreenmarketTheme = {
        init: initTheme
    };
})();

