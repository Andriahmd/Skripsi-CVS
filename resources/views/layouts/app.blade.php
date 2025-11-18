<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CVs-Diagnosis</title>
    <div class="hidden from-emerald-500 to-emerald-700"></div>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLMDJ8K2R/cOpm2E2H38+6fH4S7K5wWkF/tqjYlW/S6rD7o/N8O9r8kO8S7F8w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        @custom-variant dark (&:is(.dark *));

        :root {
            --background: #FFFFFF;
            --foreground: #374151;
            --card: #FFFFFF;
            --card-foreground: #374151;
            --popover: #FFFFFF;
            --popover-foreground: #374151;
            --primary: #00695C;
            --primary-foreground: #FFFFFF;
            --secondary: #26A69A;
            --secondary-foreground: #FFFFFF;
            --muted: #D7E7E5;
            --muted-foreground: #374151;
            --accent: #26A69A;
            --accent-foreground: #FFFFFF;
            --destructive: #EF5350;
            --destructive-foreground: #FFFFFF;
            --border: #B0BEC5;
            --input: #FFFFFF;
            --ring: rgba(0, 105, 92, 0.5);
            --chart-1: #00695C;
            --chart-2: #26A69A;
            --chart-3: #EF5350;
            --chart-4: #FFCA28;
            --chart-5: #AB47BC;
            --radius: 0.5rem;
            --sidebar: #889191;
            --sidebar-foreground: #374151;
            --sidebar-primary: #00695C;
            --sidebar-primary-foreground: #FFFFFF;
            --sidebar-accent: #26A69A;
            --sidebar-accent-foreground: #FFFFFF;
            --sidebar-border: #B0BEC5;
            --sidebar-ring: rgba(0, 105, 92, 0.5);
        }

        .dark {
            --background: #c5c8c9;
            --foreground: #ECEFF1;
        }

        @theme inline {
            --font-sans: var(--font-geist-sans);
            --font-mono: var(--font-geist-mono);
        }

        @layer base {
            * {
                @apply border-border outline-ring/50;
            }

            body {
                background-color: #D7E7E5 !important;
                color: #374151;
            }
        }

        main {
            margin-top: 100px;

        }

        @media (min-width: 768px) {
            main {
                margin-top: 80px;
            }
        }

        /* ✅ Tambahan khusus footer */
        footer {
            background-color: #00A693;
            /* Green jade */
            color: white;
        }

        footer a {
            color: #f0fdfa;
        }

        footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Efek hover sidebar */
        .quiz-category button:hover {
            background-color: #f0fdfa !important;
            transition: background-color 0.3s ease-in-out;
        }

        .quiz-category.active button {
            background-color: #d1fae5 !important;
            box-shadow: inset 0 0 0 2px #02a559;
        }
    </style>

</head>

<body class="min-h-screen">
    @include('partials.header')

    <main class="mt-[100px] md:mt-[120px]">
        @yield('content')
    </main>

    @include('partials.footer')

    <script>
        lucide.createIcons();
    </script>
</body>

</html>