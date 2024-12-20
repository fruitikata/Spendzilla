<x-layout>

    <div>
        <h1 class="title text-center font-bold text-2xl mb-4">
            SPENDZILLA: Track your expenses so you can finally stop saying, "I swear I had more money yesterday!"
        </h1>
        <h2 class="text-center text-lg">
            What are you waiting for? Let's destroy those disorganized expenses.💸🦖
    </div>


    <h1 class="title mt-10">Create a new account</h1>

    <div class="mx-auto max-w-screen-sm card">
        <form action="{{ route('signup') }}" method="post">
            @csrf

            {{-- Username --}}
            <div class="mb-4">
                <label for="username">Username</label>
                <input type="text" name="username" value="{{ old('username') }}"
                class="input
                @error('username') ring-red-900 @enderror">
                @error('username')
                    <p class="error">{{ $message }}</p>
                @enderror
            </div>

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

            {{-- Confirm Password --}}
            <div class="mb-8">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="input">
            </div>

            {{-- Submit Button --}}
            <div class="mb-3">
                <button class="btn">Sign Up</button>
            </div>
        </form>

    </div>
</x-layout>