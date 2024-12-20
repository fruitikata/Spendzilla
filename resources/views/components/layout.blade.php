<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{env('APP_NAME')}}</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-pink-100 text-pink-900">
    <header class="bg-pink-400 text-white shadow-lg">
        <nav>
            <a href="{{route('posts.index')}}" class="nav-link">Home</a>

            @auth
                <div class="relative grid-place-items-center"
                x-data="{ open: false }">
                    {{-- Dropdown menuu button --}}
                    <button @click="open = !open" type="button" class="round-btn">
                        <img src="https://picsum.photos/200" alt="">
                    </button>          
                    
                    {{-- Dropdown Menu --}}
                    <div x-show="open" @click.outside="open=false" class="bg-white shadow-lg absolute top-10 right-0 rounded-lg overflow-hidden font-light">
                        <p class="username text-pink-900 pl-4 pr-8 py-2 mb-1 font light">{{auth()->user()->username}}</p>
                        <a href="{{route('dashboard')}}" class="block hover:bg-pink-100 text-pink-900 pl-4 pr-8 py-2 mb-1">Dashboard</a>



                        <form action="{{route('logout')}}" method="post">
                            @csrf
                            <button class="block w-full text-pink-900 text-left hover:bg-pink-100 pl-4 pr-8 py-2"> Logout</button>
                        </form>

                    </div>
                </div>
            @endauth

            @guest
            <div class="flex items-center gap-4">
                <a href="{{route('login')}}" class="nav-link">Login</a>
                <a href="{{route('signup')}}" class="nav-link">Sign up</a>
            </div>
            @endguest
            
        </nav>
    </header>

    <main class="py-8 px-4 mx-auto max-w-screen-lg">
        {{$slot}}
    </main>
</body>

</html>