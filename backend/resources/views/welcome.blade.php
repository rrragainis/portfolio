<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: 'Figtree', sans-serif;
                background: #f8fafc;
                color: #1f2937;
            }
            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 2rem;
            }
            .logo {
                height: 6em;
                padding: 1.5em;
                will-change: filter;
                transition: filter 300ms;
            }
            .logo:hover {
                filter: drop-shadow(0 0 2em #646cffaa);
            }
            .logo.vanilla:hover {
                filter: drop-shadow(0 0 2em #f7df1eaa);
            }
            .card {
                padding: 2em;
            }
            .read-the-docs {
                color: #888;
            }
            a {
                font-weight: 500;
                color: #646cff;
                text-decoration: inherit;
            }
            a:hover {
                color: #535bf2;
            }
            h1 {
                font-size: 3.2em;
                line-height: 1.1;
            }
            button {
                border-radius: 8px;
                border: 1px solid transparent;
                padding: 0.6em 1.2em;
                font-size: 1em;
                font-weight: 500;
                font-family: inherit;
                background-color: #1a1a1a;
                cursor: pointer;
                transition: border-color 0.25s;
            }
            button:hover {
                border-color: #646cff;
            }
            button:focus,
            button:focus-visible {
                outline: 4px auto -webkit-focus-ring-color;
            }
            @media (prefers-color-scheme: light) {
                :root {
                    color: #213547;
                    background-color: #ffffff;
                }
                a:hover {
                    color: #747bff;
                }
                button {
                    background-color: #f9f9f9;
                }
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="card">
                <h1>Welcome to Laravel</h1>
                <p>This is the default Laravel welcome page. Your application is working correctly!</p>
                <div class="links">
                    <a href="https://laravel.com/docs">Docs</a>
                    <a href="https://laracasts.com">Laracasts</a>
                    <a href="https://laravel-news.com">News</a>
                    <a href="https://forge.laravel.com">Forge</a>
                    <a href="https://github.com/laravel/laravel">GitHub</a>
                </div>
            </div>
        </div>
    </body>
</html>
