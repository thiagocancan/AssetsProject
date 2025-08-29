@vite(['resources/css/app.css', 'resources/js/app.js'])

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body class="font-poppins text-gray-800 min-h-screen flex flex-col bg-zinc-100">
    <header class="bg-zinc-700 text-amber-50 dark:black">
        <div class="mx-auto max-w-6xl flex justify-between items-center py-4">
            <a href="{{ route('home') }}">
                <h1 class="text-4xl">AssetsHub</h1>
            </a>
            <div class="flex items-center border rounded-md overflow-hidden">
                <input 
                type="text" 
                placeholder="Buscar..." 
                autocomplete="nope" 
                class="flex-1 px-4 py-1 focus:outline-none"/>
                <button class="px-3">
                    🔍
                </button>
            </div>
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <ul class="flex gap-4 text-sm items-center">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="#">Wishlist</a></li>
                <li><a href="{{ route('assets.upload-asset-form') }}">Upload</a></li>
                @if (auth()->check())
                    <a href="{{ route('profile.profile-page', Auth::user()->id) }}">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" alt="Avatar" class="w-8 h-8 rounded-full">
                    </a>
                @else
                    <li class="bg-orange-600/90 p-2 rounded-lg"><a href="{{ route('login') }}">Sign in</a></li>
                @endif
            </ul>
        </div>
    </header>

    <main class="min-h-screen">
        @if (session('success'))
            <div 
                x-data="{ show: true }" 
                x-init="setTimeout(() => show = false, 5000)" 
                x-show="show"
                x-transition
                class="p-3 mb-3 rounded bg-green-100 text-green-800"
            >
                {{ session('success') }}
            </div>
        @endif
        <div class="mx-auto max-w-6xl">
            {{ $slot }}
        </div>
    </main>

    <footer>
        <div class="bg-zinc-800 text-amber-50 p-[100px] mt-10">
            <div class="mx-auto max-w-6xl px-4 flex justify-between items-center">
                <div class="flex flex-col gap-4 w-2/3">
                    <h2 class="text-4xl mb-8">AssetsHub</h2>
                    <p>“Training morning to night, once you have polished it to perfection, 
                        you will achieve an independent freedom, naturally also acquire wondrous abilities, 
                        and have mysterious, limitless power. This is the spirit of the practice we undertake as warriors.” — Miyamoto Musashi</p>
                    <p>&copy; 2025 AssetsHub. All reserved rights.</p>
                </div>
                <ul class="flex gap-4 text-sm">
                    <li><a href="#" class="hover:underline">Privacy Policy</a></li>
                    <li><a href="#" class="hover:underline">Terms of Service</a></li>
                    <li><a href="#" class="hover:underline">Contact</a></li>
                </ul>
            </div>
        </div>
    </footer>
    
@livewireScripts
@vite('resources/js/app.js')
</body>
</html>
