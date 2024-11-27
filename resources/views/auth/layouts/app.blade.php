<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @include('auth.partials.header') <!-- Include the header from the 'partials' folder -->
    <main>
        @yield('content') <!-- Dynamic content will be injected here -->
    </main>
    @include('auth.partials.footer') <!-- Include the footer from the 'partials' folder -->
</body>
</html>

