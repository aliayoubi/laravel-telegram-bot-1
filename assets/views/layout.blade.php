<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Telegram Bot Manager</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.css">
    <link rel="shortcut icon" href="https://www.telegram.org/favicon.ico?3" type="image/x-icon">

    <style>
        html, body { overflow-x: auto; }
    </style>
</head>
<body>

    <div style="width: 1200px; padding: 0 20px; margin: 0 auto">

        @include('telegram::partials.header')

        @include('telegram::partials.menu.bots')
        @include('telegram::partials.menu.bot')

        <div style="margin: 40px 0">
            @yield('content')
        </div>

        @include('telegram::partials.footer')

    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.2.6/semantic.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.2/lodash.min.js"></script>

    <script>
        $(".dropdown").dropdown();
    </script>

    @stack('scripts')
</body>
</html>