<!-- PWA Manifest -->
<link rel="manifest" href="/manifest.json">

<!-- Favicon -->
<link rel="shortcut icon" href="{{ $web_config['fav_icon']['path'] }}">

<!-- Apple Touch Icons -->
<link rel="apple-touch-icon" sizes="180x180" href="/assets/pwa/ios/180.png">
<link rel="apple-touch-icon" sizes="152x152" href="/assets/pwa/ios/152.png">
<link rel="apple-touch-icon" sizes="120x120" href="/assets/pwa/ios/120.png">
<link rel="apple-touch-icon" sizes="76x76" href="/assets/pwa/ios/76.png">
<link rel="apple-touch-icon" sizes="60x60" href="/assets/pwa/ios/60.png">

<!-- Apple Startup Image -->
<link rel="apple-touch-startup-image" href="/assets/pwa/ios/1024.png">

<!-- Apple Mask Icon -->
<link rel="mask-icon" href="{{ $web_config['fav_icon']['path'] }}" color="#4B0082">

<!-- PWA Meta Tags -->
<meta name="theme-color" content="#4B0082">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="apple-mobile-web-app-title" content="Nix">
<meta name="mobile-web-app-capable" content="yes">
<meta name="msapplication-TileColor" content="#4B0082">
<meta name="msapplication-TileImage" content="/assets/pwa/android/android-launchericon-144-144.png">

<!-- PWA Service Worker Registration -->
<script>
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', function() {
      navigator.serviceWorker.register('/sw.js')
        .then(function(registration) {
          console.log('ServiceWorker registration successful with scope: ', registration.scope);
        })
        .catch(function(error) {
          console.log('ServiceWorker registration failed: ', error);
        });
    });
  }
</script>
