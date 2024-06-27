<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="strict-origin" />
    <title>CRUD - Lista de Tareas</title>
    <script src="https://kit.fontawesome.com/d121035ec5.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/general/general.css') }}">
    @yield('styles')
</head>
<script>
    let baseUrl = '{{ url("/api/")}}';
</script>

<body class="bg-body">
    <div class="wrapper">
        <header class="p-3 bg-dark text-white">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                    <a href="{{url('/')}}" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
                        <img src="{{ asset('images/logos/Logo_Tigo.svg') }}" alt="Logo" width="50" height="40" class="me-2">
                        <span class="fs-4 p-2">Prueba Técnica - CRUD  </span>
                    </a>
                </div>
            </div>
        </header>

        <main class="content">
            <div class="container mt-5 mb-3">
                @yield('content')
            </div>
        </main>

        <footer class="footer bg-dark text-white mt-5 pt-3">
            <div class="container">
                <p class="text-white text-center">José Cuevas - Prueba Técnica Vacante Tigo Panamá </p>
                <p class="text-white text-center">{{ date('Y') }}</p>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/bootstrap/bootstrap.min.js') }}"></script>
    @yield('scripts')
</body>
</html>
