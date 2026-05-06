<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'UMKM Kita' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/style.css') }}">
    @livewireStyles
</head>
<body>
    {{ $slot }}
    
    <!-- FOOTER -->
    <footer>
        <p>&copy; {{ date('Y') }} UMKM Kita — SMK Telkom Sidoarjo. Dibuat dengan ❤️ untuk UMKM lokal.</p>
    </footer>

    @livewireScripts
</body>
</html>
