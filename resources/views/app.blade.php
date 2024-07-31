<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    @inertiaHead
</head>

<body>
    <div id="app" class="SimpleCMS" data-page="{{ json_encode($page) }}"></div>
    <div id="loading-bg">
        <div class="loading-logo">
            <img src="/assets/logo_load.png" />
        </div>
    </div>
    <script>
        const loaderColor = '#111827'
        const primaryColor = '#FFFFFF'
        document.documentElement.style.setProperty('--initial-loader-bg', loaderColor)
        document.documentElement.style.setProperty('--initial-loader-color', primaryColor)
    </script>
</body>

</html>
