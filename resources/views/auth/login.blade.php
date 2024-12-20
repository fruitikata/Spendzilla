<x-layout>

    <div>
        <h1 class="title text-center font-bold text-2xl mb-4">
            SPENDZILLA: Track your expenses so you can finally stop saying, "I swear I had more money yesterday!"
        </h1>
        <h2 class="text-center text-lg">
            Destroy those disorganized expenses.💸🦖
    </div>

    <h1 class="title mt-10">Welcome back! Log in to your account</h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('login') }}" method="post">
            @csrf

            {{-- Email --}}
            <div class="mb-4">
                <label for="email">Email</label>
                <input type="text" name="email" value="{{ old('email') }}"
                class="input">

                @error('email')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label for="password">Password</label>
                <input type="password" name="password" class="input">
                
                @error('password')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Checkbox --}}
            <div class="mb-4 flex items-center gap-2">
                <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-pink-900 rounded focus:ring focus:ring-pink-300">
                <label for="remember" class="text-sm text-pink-900">Remember me</label>
            </div>

            @error('failed')
                    <p class="error">{{ $message }}</p>
                @enderror

            {{-- Submit Button --}}
            <div class="mb-3">
                <button class="btn">Log in</button>
            </div>
        </form>

    </div>
</x-layout>