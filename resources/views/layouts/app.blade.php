<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SENAI Mauá - Gestão</title>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            background-image: url('{{ asset("image_6ce3a2.png") }}');
            background-size: cover; background-attachment: fixed; background-position: center;
            background-color: #f4f7fa; margin: 0;
        }
        .glass { background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.5); }
    </style>
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen">
        @include('layouts.navigation')
        <main> {{ $slot }} </main>
    </div>
</body>
</html>