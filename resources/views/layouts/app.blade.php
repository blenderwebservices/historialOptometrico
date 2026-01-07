<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Historial Optométrico') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #6366f1;
            --primary-light: #818cf8;
            --bg-glass: rgba(255, 255, 255, 0.7);
            --bg-gradient: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-gradient);
            color: var(--text-main);
            min-height: 100vh;
            margin: 0;
            padding: 2rem;
        }

        .premium-container {
            max-width: 1000px;
            margin: 0 auto;
            background: var(--bg-glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 24px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.07);
            padding: 3rem;
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h1,
        h2,
        h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        input,
        select,
        textarea {
            background: rgba(255, 255, 255, 0.5);
            border: 1px solid #cbd5e1;
            border-radius: 12px;
            padding: 0.75rem;
            width: 100%;
            transition: border-color 0.2s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.875rem;
            color: var(--text-muted);
        }

        /* Navigation Styles */
        .navbar {
            position: sticky;
            top: 1rem;
            z-index: 50;
            margin-bottom: 2rem;
            background: var(--bg-glass);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 20px;
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: var(--text-main);
            font-weight: 600;
            font-size: 0.95rem;
            transition: color 0.2s;
        }

        .nav-link:hover {
            color: var(--primary);
        }

        .profile-dropdown {
            position: relative;
        }

        .avatar-btn {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .avatar-img {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: calc(100% + 10px);
            width: 200px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid #f1f5f9;
            padding: 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 2px;
            transform-origin: top right;
        }

        .dropdown-item {
            padding: 0.75rem 1rem;
            text-decoration: none;
            color: var(--text-main);
            font-size: 0.9rem;
            font-weight: 500;
            border-radius: 10px;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: #f8fafc;
            color: var(--primary);
        }

        .mobile-padding {
            padding-bottom: 4rem;
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @livewireStyles
</head>

<body class="mobile-padding">
    <div class="premium-container">
        <nav class="navbar">
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
                @auth
                    <a href="{{ route('consultations.list') }}" class="nav-link">Mis Consultas</a>
                @endauth
                <a href="/admin" class="nav-link">Dashboard</a>
            </div>

            <div class="profile-dropdown" x-data="{ open: false }" @click.away="open = false">
                @auth
                    <button class="avatar-btn" @click="open = !open">
                        <span class="nav-link">{{ Auth::user()->name }}</span>
                        <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=6366f1&color=fff' }}"
                            alt="Avatar" class="avatar-img">
                    </button>
                    <div class="dropdown-menu" x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        style="display: none;">
                        <a href="/admin/profile" class="dropdown-item">Mi Perfil</a>
                        <form method="POST" action="/admin/logout">
                            @csrf
                            <button type="submit" class="dropdown-item"
                                style="width: 100%; text-align: left; background: none; border: none; cursor: pointer;">Cerrar
                                Sesión</button>
                        </form>
                    </div>
                @else
                    <div class="nav-links">
                        <a href="/admin/login" class="nav-link">Login</a>
                        <a href="/admin/register" class="nav-link">Registro</a>
                    </div>
                @endauth
            </div>
        </nav>

        @if(isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </div>
    @livewireScripts
</body>

</html>