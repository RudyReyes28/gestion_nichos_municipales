<!-- resources/views/layouts/ayudante.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Ayudante - @yield('titulo')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para íconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .sidebar {
            background-color: #3e6b89;
            min-height: calc(100vh - 56px);
        }
        .sidebar .nav-link {
            color: #f8f9fa;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.5rem;
        }
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            font-weight: bold;
        }
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        main {
            flex: 1;
        }
        .navbar {
            background-color: #2c4d63;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .section-title {
            background-color: #eef2f5;
            padding: 10px 15px;
            margin-bottom: 20px;
            border-left: 4px solid #3e6b89;
            border-radius: 4px;
        }
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #2c4d63;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 10px;
        }
        .footer {
            background-color: #2c4d63;
            color: white;
            padding: 1rem 0;
            margin-top: auto;
        }
        .badge-contrato {
            font-size: 0.8rem;
            padding: 5px 8px;
        }
        .card-ayudante {
            border-left: 4px solid #3e6b89;
            transition: all 0.3s ease;
        }
        .card-ayudante:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
    </style>
    @yield('estilos')
</head>
<body>
    <!-- Navbar superior -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('ayudante.home') }}">
                <i class="fas fa-landmark me-2"></i>
                Panel de Ayudante
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="d-flex align-items-center">
                                <div class="avatar">
                                    {{ substr($persona->nombre ?? 'A', 0, 1) }}
                                </div>
                                <span>{{ $persona->nombre ?? 'Ayudante' }} {{ $persona->apellido ?? '' }}</span>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('ayudante.mi_perfil') }}"><i class="fas fa-user-cog me-2"></i>Mi perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 px-0 sidebar">
                <div class="d-flex flex-column p-3">
                    <ul class="nav nav-pills flex-column mb-auto">
                        <li class="nav-item">
                            <a href="{{ route('ayudante.home') }}" class="nav-link {{ request()->routeIs('ayudante.home') ? 'active' : '' }}">
                                <i class="fas fa-home"></i>
                                Inicio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ayudante.gestion_nichos') }}" 
                                class="nav-link {{ request()->routeIs('ayudante.gestion_nichos*') ? 'active' : '' }}">
                                <i class="fas fa-monument"></i>
                                Nichos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ayudante.gestion_usuarios') }}" 
                                class="nav-link {{ request()->routeIs('ayudante.gestion_usuarios*') ? 'active' : '' }}">
                                <i class="fas fa-users"></i>
                                Ocupantes y Responsables
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ayudante.contratos') }}" class="nav-link {{ request()->routeIs('ayudante.contratos*') ? 'active' : '' }}">
                                <i class="fas fa-file-contract"></i>
                                Gestión de Contratos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ayudante.gestion_reportes') }}"
                                class="nav-link {{ request()->routeIs('ayudante.gestion_reportes*') ? 'active' : '' }}">
                                <i class="fas fa-chart-bar"></i>
                                Gestión de Reportes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('ayudante.mi_perfil') }}" 
                                class="nav-link {{ request()->routeIs('ayudante.mi_perfil*') ? 'active' : '' }}" >
                                <i class="fas fa-user"></i>
                                Mi Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="fas fa-sign-out-alt"></i>
                                Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contenido principal -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <h2 class="section-title">@yield('titulo_seccion')</h2>
                
                @yield('contenido')
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <span>© {{ date('Y') }} Sistema de Gestión de Nichos Municipales - Panel de Ayudante</span>
        </div>
    </footer>

    <!-- Scripts de Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>