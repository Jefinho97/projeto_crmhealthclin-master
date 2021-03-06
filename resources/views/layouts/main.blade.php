<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app='todoApp'>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        <!-- CSS Bootstrap -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.12.1/b-2.2.3/date-1.1.2/sb-1.3.3/datatables.min.css"/>
        
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
        
 
        <!-- CSS da aplicação -->
        <link rel="stylesheet" href="/css/styles.css">
        
        <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ asset('moment/moment.min.js') }}"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.12.1/b-2.2.3/date-1.1.2/sb-1.3.3/datatables.min.js"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('toastr/toastr.min.js') }}"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.8.2/angular.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.js"></script>
    </head>
    <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="collapse navbar-collapse" id="navbar">
            <a href="/" class="navbar-brand"><img src="" alt=""></a>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="{{ route('orcamentos.dashboard') }}" class="nav-link">Orçamentos</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('materiais.dashboard') }}" class="nav-link">Materiais</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('diarias.dashboard') }}" class="nav-link">Diarias</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('equipes.dashboard') }}" class="nav-link">Profissionais</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('dietas.dashboard') }}" class="nav-link">Dietas</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('equipamentos.dashboard') }}" class="nav-link">Equipamentos</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('medicamentos.dashboard') }}" class="nav-link">Medicamentos</a>
              </li>
              <li class="nav-item">
                <a href="{{ route('medicos.dashboard')}}" class="nav-link">Medicos</a>
              </li>
              <li class="nav-item">
                <form action="/logout" method="POST">
                  @csrf
                  <a href="/logout" class="nav-link" 
                    onclick="event.preventDefault();
                      this.closest('form').submit();">
                      Sair
                  </a>
                </form>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <main>
        <div class="container-fluid">
          @if(session('msg'))
            <p class="msg">{{ session('msg') }}</p>
          @endif
          @yield('content')
        </div>
      </main>
      <footer>
        <p>CRM Health Clin &copy; 2021</p>
      </footer>
    </body>
</html>
