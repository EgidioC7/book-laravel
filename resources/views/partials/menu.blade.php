<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Laravel</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon">
            <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
             @if(Route::is('book.*') == false)
                @forelse($genres as $id => $name)
                    <a class="nav-link" href="{{url('genre', $id )}}">{{$name}}</a>
                @empty
                    <li>Aucun genre</li>
                @endforelse
            @endif
        </span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            @if(isset($genres))
                @forelse($genres as $id => $name)
                    <li><a class="nav-link" href="{{url('genre', $id )}}">{{$name}}</a></li>
                @empty
                    <li>Aucun genre</li>
                @endforelse
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            {{-- renvoie true si vous êtes connecté --}}
            @if(Auth::check())
                <li><a class="nav-link" href="{{route('book.index')}}">Dashboard</a></li>
                <li>
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}
                    </a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            @else
                <li class="nav-item">
                    <a class="nav-link" href="{{route('login')}}">Login</a>
                </li>
            @endif
            <li class="nav-item"> <a class="nav-link" href="">Nb de livres : {{\App\Http\Controllers\FrontController::getNbBook()}}</a></li>
            <li class="nav-item"> <a class="nav-link" href="">Nb d'auteurs : {{\App\Http\Controllers\FrontController::getNbAuthor()}}</a></li>
        </ul>
    </div>
</nav>
