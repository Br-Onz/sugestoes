<!-- resources/views/layouts/login-layout.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ env('NOME_EMPRESA') }}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://code.jquery.com/jquery-3.7.1.slim.js" integrity="sha256-UgvvN8vBkgO0luPSUl2s8TIlOSYRoGFAX4jlCIm9Adc=" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite(['resources/css/main.css', 'resources/css/app.css'])
    @fluxStyles
</head>
<body class="app sidebar-mini " x-data="{ open: true }" :class="open ? '' : 'sidenav-toggled' ">
<!-- Navbar-->
<header class="app-header"><a class="app-header__logo" style="font-family: 'Arial Black',serif;font-size: 18px" wire:navigate.hover href="/home"><img src="{{ asset('images/logo.png') }}" style="width: 100px; height: 40px;"></a>
    <!-- Sidebar toggle button--><span x-on:click="open = ! open" style="cursor: pointer" class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></span>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown">
            <a class="app-nav__item" href="#" data-bs-toggle="dropdown" aria-label="Open Profile Menu"><i class="bi bi-person fs-4"></i></a>
            <ul class="dropdown-menu settings-menu dropdown-menu-right">
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"><i class="bi bi-box-arrow-right me-2 fs-5"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user">
        <div class="d-grid align-items-center justify-center">
            <p class="app-sidebar__user-name">{{ auth()->user()->nome_guerra }}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item some_no_mobile" window.location.reload() href="/home"><i class="app-menu__icon bi bi-house"></i><span class="app-menu__label">Home</span></a></li>
        <li><a class="app-menu__item some_no_mobile"  window.location.reload() href="/mesas"><i class="app-menu__icon bi bi-calendar4-week"></i><span class="app-menu__label">Mesas</span></a></li>
        <li><a class="app-menu__item some_no_mobile"  window.location.reload() href="/balcao"><i class="app-menu__icon bi bi-cast"></i><span class="app-menu__label">Balcão</span></a></li>
        <li><a class="app-menu__item"  window.location.reload() href="/mobile"><i class="app-menu__icon bi bi-phone-flip"></i><span class="app-menu__label">Mobile</span></a></li>

        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon bi bi-laptop"></i><span class="app-menu__label">Cadastros</span><i class="treeview-indicator bi bi-chevron-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" window.location.reload() href="/cadprodutos"><i class="icon bi bi-circle-fill"></i> Cadastro de produtos</a></li>
                <li><a class="treeview-item" window.location.reload() href="/grupos" rel="noopener"><i class="icon bi bi-circle-fill"></i> Grupos de produtos</a></li>
                <li><a class="treeview-item" window.location.reload() href="/produtos"><i class="icon bi bi-circle-fill"></i> Produtos</a></li>
                <li><a class="treeview-item" window.location.reload() href="/impressoras"><i class="icon bi bi-circle-fill"></i> Impressoras</a></li>
                <li><a class="treeview-item" window.location.reload() href="/usuarios"><i class="icon bi bi-circle-fill"></i> Usuários</a></li>
            </ul>
        </li>
    </ul>
</aside>
<main class="app-content">
    <x-livewire-alert::scripts />
    <div class="cover">
        {{ $slot }}
    </div>
</main>
@fluxScripts
<x-livewire-alert::scripts />
</body>
</html>

