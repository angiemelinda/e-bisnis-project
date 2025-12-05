<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GrosirHub') - Platform B2B Supplier & Dropshipper</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#ff6b35',
                        secondary: '#f7931e',
                        dark: '#1a1a1a',
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>
<body class="font-sans bg-gray-50">
    @include('partials.navbar')
    <main>
        @yield('content')
    </main>
    @include('partials.footer')
    @stack('scripts')
</body>
</html>

