<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <a class="navbar-brand" href="{{ route('home') }}">AutoEscola</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 mr-5">
                @if(auth()->user()->hasRole('Aluno') || auth()->user()->hasRole('Instrutor'))
                    <a class="nav-link {{request()->routeIs('home') ? 'active' : ''}}" href="{{ route('home') }}">Aulas</a>

                    @if(auth()->user()->hasRole('Aluno'))
                        <a class="nav-link {{request()->routeIs('pagamento-taxa.index') ? 'active' : ''}}" href="{{ route('pagamento-taxa.index') }}">Pagamento Taxas</a>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{request()->routeIs('home') || request()->routeIs('aulas.reagendamento') ? 'active' : ''}}"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Aulas
                        </a>
                        <ul class="dropdown-menu dropdown-menu">
                            <li>
                                <a class="nav-link {{request()->routeIs('home') ? 'active' : ''}}" href="{{ route('home') }}">Agendadas</a>
                            </li>
                            <li>
                                <a class="nav-link {{request()->routeIs('aulas.reagendamento') ? 'active' : ''}}" href="{{ route('aulas.reagendamento') }}">Reagendamentos</a>
                            </li>
                        </ul>
                    </li>
                @endif
                @if(!auth()->user()->hasRole('Aluno') && !auth()->user()->hasRole('Instrutor'))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{request()->routeIs('usuarios.bloqueados') || request()->routeIs('usuarios.index') ? 'active' : ''}}"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Usuários
                        </a>
                        <ul class="dropdown-menu dropdown-menu">
                            <li>
                                <a class="nav-link {{request()->routeIs('usuarios.index') ? 'active' : ''}}" href="{{ route('usuarios.index') }}">Ativos</a>
                            </li>
                            <li>
                                <a class="nav-link {{request()->routeIs('usuarios.bloqueados') ? 'active' : ''}}" href="{{ route('usuarios.bloqueados') }}">Bloqueados</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{request()->routeIs('veiculos.index') || request()->routeIs('revisao.index') ? 'active' : ''}}"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Veículos
                        </a>
                        <ul class="dropdown-menu dropdown-menu">
                            <li>
                                <a class="nav-link {{request()->routeIs('veiculos.index') ? 'active' : ''}}" href="{{ route('veiculos.index') }}">Lista</a>
                            </li>
                            <li>
                                <a class="nav-link {{request()->routeIs('revisao.index') ? 'active' : ''}}" href="{{ route('revisao.index') }}">Revisão Detran</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{request()->routeIs('usuarios.bloqueados') || request()->routeIs('usuarios.index') ? 'active' : ''}}"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Configurações
                        </a>
                        <ul class="dropdown-menu dropdown-menu">
                            <li>
                                <a class="nav-link {{request()->routeIs('configuracoes.index') ? 'active' : ''}}" href="{{ route('configuracoes.index') }}">Expediente</a>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>

            <div class="d-flex" role="search">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ \Illuminate\Support\Facades\Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <form action="{{ route('logout') }}" method="POST" id="logout">
                                    @csrf
                                    <a class="dropdown-item" href="#" onClick="document.getElementById('logout').submit();">Sair</a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
