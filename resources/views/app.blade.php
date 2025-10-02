<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  @class(['dark' => ($appearance ?? 'system') == 'dark'])>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        {{-- Inline script to detect system dark mode preference and apply it immediately --}}
        <script>
            (function() {
                const appearance = '{{ $appearance ?? "system" }}';

                if (appearance === 'system') {
                    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

                    if (prefersDark) {
                        document.documentElement.classList.add('dark');
                    }
                }
            })();
        </script>

        {{-- Inline style to set the HTML background color based on our theme in app.css --}}
        <style>
            html {
                background-color: oklch(1 0 0);
            }

            html.dark {
                background-color: oklch(0.145 0 0);
            }
        </style>

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- SEO Meta Tags -->
        <meta name="description" content="Task Fox - A modern, intuitive task management application built with Laravel and Vue.js. Organize, categorize, and track your tasks with advanced filtering and real-time updates.">
        <meta name="keywords" content="task management, todo app, productivity, organization, task tracker, project management, Laravel, Vue.js">
        <meta name="author" content="Task Fox">
        <meta name="robots" content="index, follow">
        <meta name="language" content="English">
        <meta name="revisit-after" content="7 days">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:title" content="{{ config('app.name', 'Task Fox') }} - Modern Task Management">
        <meta property="og:description" content="Organize your tasks efficiently with Task Fox. Features include sophisticated categorization, due date tracking, and advanced filtering capabilities.">
        <meta property="og:image" content="{{ asset('favicon.svg') }}">
        <meta property="og:site_name" content="{{ config('app.name', 'Task Fox') }}">

        <!-- Twitter Card -->
        <meta property="twitter:card" content="summary_large_image">
        <meta property="twitter:url" content="{{ url()->current() }}">
        <meta property="twitter:title" content="{{ config('app.name', 'Task Fox') }} - Modern Task Management">
        <meta property="twitter:description" content="Organize your tasks efficiently with Task Fox. Features include sophisticated categorization, due date tracking, and advanced filtering capabilities.">
        <meta property="twitter:image" content="{{ asset('favicon.svg') }}">

        <!-- Additional SEO Meta Tags -->
        <meta name="theme-color" content="#4B5563" media="(prefers-color-scheme: light)">
        <meta name="theme-color" content="#1F2937" media="(prefers-color-scheme: dark)">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
        <meta name="application-name" content="{{ config('app.name', 'Task Fox') }}">

        <!-- Canonical URL -->
        <link rel="canonical" href="{{ url()->current() }}">

        <!-- Favicon and Icons -->
        <link rel="icon" href="/favicon.ico" sizes="any">
        <link rel="icon" href="/favicon.svg" type="image/svg+xml">
        <link rel="apple-touch-icon" href="/apple-touch-icon.png">

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

        @vite(['resources/js/app.ts', "resources/js/pages/{$page['component']}.vue"])
        @inertiaHead
    </head>
    <body class="font-sans antialiased">
        @inertia
    </body>
</html>
