<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Colinas del Sol</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
    <link rel="icon" href="{{ asset('images/logo.svg') }}">
    @vite('resources/css/global.css')
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="/"><img src="{{ asset('images/logo.svg') }}"
                        width="30px"height="30px" alt="logo">Colina del Sol</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
                    aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a href="{{ url('/') }}"
                                class="nav-link @if (request()->path() === '/') disabled @endif"
                                aria-current="page">Inicio</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/news') }}"
                                class="nav-link @if (request()->path() === 'news') disabled @endif"
                                aria-current="page">Noticias</a>
                        </li>
                        <li class="nav-item">
                            <a id="transparent" href="{{ url('/transparent') }}"
                                class="nav-link @if (request()->path() === 'transparent') disabled @endif"
                                aria-current="page">Transparencias</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Servicios
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a id='services' href="{{ url('/atention') }}"
                                        class="dropdown-item @if (request()->path() === 'atention') disabled @endif">Horarios</a>
                                </li>
                                <li><a id='serv' href="{{ url('/solicitud') }}"
                                        class="dropdown-item @if (request()->path() === 'solicitud') disabled @endif">Solicitudes</a>
                                </li>
                            </ul>
                        </li>
                        @auth
                            @if (Auth::user()->role !== 2)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Socios
                                    </a>
                                    @if (Auth::user()->is_socio === 1)
                                        <ul class="dropdown-menu dropdown-menu-dark">
                                            <li><a id='member' href="{{ url('/members') }}"
                                                    class="dropdown-item @if (request()->path() === 'members') disabled @endif">Socios
                                                    activos</a></li>
                                            <li><a href="{{ url('/facturas') }}"
                                                    class="dropdown-item @if (request()->path() === 'facturas') disabled @endif"
                                                    hidden>Facturas</a></li>
                                        </ul>
                                    @endif
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Incidentes
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-dark">
                                        <li><a href="{{ url('/reporte') }}"
                                                class="dropdown-item @if (request()->path() === 'reporte') disabled @endif"
                                                hidden>Reportar</a></li>
                                        <li><a href="{{ url('/myreport') }}"
                                                class="dropdown-item @if (request()->path() === 'myreport') disabled @endif">Mis
                                                reportes</a></li>
                                    </ul>
                                </li>
                                @if (Auth::user()->role === 0)
                                    <li class="nav-item">
                                        <a href="{{ url('/admin') }}"
                                            class="nav-link @if (request()->path() === 'admin') disabled @endif"
                                            aria-current="page">Administrador</a>
                                    </li>
                                @endif
                            @endif
                        @endauth
                        <li class="nav-item">
                            <a id="contact" href="{{ url('/contact') }}"
                                class="nav-link @if (request()->path() === 'contact') disabled @endif"
                                aria-current="page">Contacto</a>
                        </li>
                    </ul>
                    <div id="content-btnlg" class="d-flex">
                        <div id="login"></div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main class="container">
        @yield('maincontent')
    </main>
    <footer class="text-center border-top">
        <div class="container-fluid mt-4">
            <div class="row">
                <div class="col-md text-center align-items-center justify-content-center">
                    <h3>Contacto</h3>
                    <i class="bi bi-telephone"></i> Número de contacto: (04) 2017466<br>
                    <i class="bi bi-envelope"></i> asociacion.codesol@gmail.com <br>
                    <ul id="icon-contact"
                        class="list-group list-group-horizontal text-center align-items-center justify-content-center">
                        <li id="foot-icon" class="list-group-item">
                            <a href="https://api.whatsapp.com/send?phone=593967523408"
                                class="btn-social btn-outline"target="_blank"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="16" height="16"fill="currentColor" class="bi bi-whatsapp"
                                    viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                </svg></a>
                        </li>
                    </ul>
                </div>
                <div class="col-md footer-col text-center align-items-center justify-content-center">
                    <h3>Dirección</h3>
                    <iframe id="maps-footer"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d249.19697684495475!2d-79.93924298284107!3d-2.0949400315216393!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x902d0dccd2ef26eb%3A0xe38acf77390a1294!2sColina%20del%20Sol!5e0!3m2!1ses!2sec!4v1639504616414!5m2!1ses!2sec"
                        width="300" height="150" allowfullscreen="" loading="lazy"></iframe>
                    <br><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z" />
                    </svg> Kilómetro 12 ½ vía a Daule<br>
                </div>
            </div>
            <p class="mt-1 text-muted">Asociación Colina del Sol | 2021 - 2022 | asociacioncodesol © | <a
                    href="#" data-bs-toggle="modal" data-bs-target="#acercade">Acerca de</a></p>
        </div>
    </footer>

    <!-- Modal de acerca -->

    <div class="modal fade mt-5" id="acercade" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Acerca del Desarrollador</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center" style="margin-left: auto; margin-right:auto">
                    <b>Proyecto de practicas pre-profesionales<br>
                        Universidad Agraria del Ecuador</b><br>
                    <b>Supervisado por:</b> Ing. Paola Grijalva <br>
                    <b>Estudiante practicante:</b> Jeremy Ponce Diaz<br>
                    <b>contacto:</b> jeremyponce2016@gmail.com
                </div>
            </div>
        </div>
    </div>
    @vite('resources/js/global.js')
</body>

</html>
