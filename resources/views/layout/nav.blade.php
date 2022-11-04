<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <a class="navbar-brand" href="#">Navbar</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{request()->routeIs('home') ? 'active' : ''}}" aria-current="page" href="{{ route('home') }}">Calendario</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{request()->routeIs('usuarios.index') ? 'active' : ''}}" href="{{ route('usuarios.index') }}">Alunos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Veículos</a>
                </li>
            </ul>

            <div class="d-flex" role="search">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <form action="{{ route('logout') }}" method="POST" id="logout">
                                @csrf
                                <li>
                                    <a class="dropdown-item" href="#" onClick="document.getElementById('logout').submit();">Sair</a>
                                </li>
                            </form>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
