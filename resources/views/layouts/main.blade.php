<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" ng-app='todoApp'>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>@yield('title')</title>

        <!-- CSS Bootstrap -->
        <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap4.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
        
        <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
        
        <!-- CSS da aplicação -->
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        
    </head>
    <body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
          <div class="collapse navbar-collapse" id="navbar">
            <a href="/" class="navbar-brand">
              {{--<img src="/img/hdcevents_logo.svg" alt="HDC Events">--}}
            </a>
            <ul class="navbar-nav">
              <li class="nav-item">
                <a href="{{ route('orcamentos.create') }}" class="nav-link">Criar Orçamentos</a>
              </li>
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
