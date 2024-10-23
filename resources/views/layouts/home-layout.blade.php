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
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        @foreach(auth()->user()->pccontroi as $Pccontroi)
            @if($Pccontroi->codrotina == 1444)
                @if($Pccontroi->codcontrole == 1 && $Pccontroi->acesso =='S')
                    <li><a class="app-menu__item some_no_mobile" href="/home"><i class="app-menu__icon bi bi-card-text"></i><span class="app-menu__label">Sugestão</span></a></li>
                    <li><a class="app-menu__item some_no_mobile" href="/solicitados"><i class="app-menu__icon bi bi-android"></i><span class="app-menu__label">Solicitados</span></a></li>
                @endif
                @if($Pccontroi->codcontrole == 2 && $Pccontroi->acesso =='S')
                    <li><a class="app-menu__item some_no_mobile" href="/avaliar"><i class="app-menu__icon bi bi-graph-up-arrow"></i><span class="app-menu__label">Avaliar</span></a></li>
                @endif
            @endif
        @endforeach
    </ul>
</aside>
<main class="app-content">
    <x-livewire-alert::scripts />
    <div class="cover">
        {{ $slot }}
    </div>
</main>
<x-livewire-alert::scripts />
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.on('nome-preenchido', () => {
            document.getElementById('quantidade').focus();
        });

        Livewire.on('NovoItem', () => {
            document.getElementById('codigo').focus();
        });

        Livewire.on('ModalTableAvaliar', () => {
            $('#ModalTableAvaliar').modal('show');
        });

        Livewire.on('ModalOptions', () => {
            $('#ModalTableAvaliarOptions').modal('show');
        });

        Livewire.on('ModalTableAvaliar227', () => {
            $('#ModalTableAvaliar227').modal('show');
        });

        Livewire.on('ModalEditItem', () => {
            $('#ModalEditItem').modal('show');
        });

        Livewire.on('closeModalEditItem', () => {
            $('#ModalEditItem').modal('hide');
        });
        Livewire.on('abrir-nova-aba', data => {
           window.open(data[0].url, '_blank');
        });

    });

    function formatarMoeda(input) {
        // Remove qualquer caractere que não seja um número
        let valor = input.value.replace(/\D/g, '');

        // Formata o valor como moeda brasileira
        valor = (valor / 100).toFixed(2).replace('.', ',');

        // Adiciona o símbolo da moeda
        input.value = valor.replace(/\B(?=(\d{3})+(?!\d))/g, '.') || 'R$ 0,00';
        if (valor) {
            input.value = 'R$ ' + input.value;
        }
    }

    function spanLoading() {
        var spanLoading = document.querySelectorAll("#span-loading");
        var buttonLoading = document.querySelectorAll("#button-loading");

        spanLoading.forEach(function (item) {
            item.style.display = "none";
        });

        buttonLoading.forEach(function (item) {
            item.style.display = "block";
            item.style.width = "71px";
        });
    }

    function spanLoadingHome() {
        var spanLoading = document.querySelectorAll("#span-loading");
        var buttonLoading = document.querySelectorAll("#button-loading");

        spanLoading.forEach(function (item) {
            item.style.display = "none";
        });

        buttonLoading.forEach(function (item) {
            item.style.display = "block";
        });
    }

</script>
</body>
</html>

