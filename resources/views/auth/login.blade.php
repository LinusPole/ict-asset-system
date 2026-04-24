<x-guest-layout>

<style>
    body {
        background: url('/images/kilifi-bg.jpg') no-repeat center center fixed;
        background-size: cover;
    }

    .login-card {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(10px);
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }

    .logo {
        width: 90px;
        margin: 0 auto;
    }

    .title {
        font-weight: bold;
        color: #0d3b66;
    }

    .subtitle {
        font-size: 13px;
        color: #666;
    }
</style>

<div class="flex justify-center items-center min-h-screen">

    <div class="w-full max-w-md login-card">

        <!-- LOGO -->
        <div class="text-center mb-4">
            <img src="{{ asset('images/kilifi-logo.jpeg') }}" class="logo" alt="Kilifi Logo">

            <h3 class="title mt-3">Kilifi County Government</h3>
            <p class="subtitle">ICT Asset Management System</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- FORM -->
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email"
                              class="block mt-1 w-full"
                              type="email"
                              name="email"
                              :value="old('email')"
                              required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password"
                              class="block mt-1 w-full"
                              type="password"
                              name="password"
                              required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember -->
            <div class="mt-4 flex items-center">
                <input type="checkbox" name="remember" class="mr-2">
                <span class="text-sm text-gray-600">Remember me</span>
            </div>

            <!-- BUTTON -->
            <div class="mt-6 flex justify-between items-center">

                <a class="text-sm text-gray-600 underline"
                   href="{{ route('password.request') }}">
                    Forgot password?
                </a>

                <x-primary-button>
                    Login
                </x-primary-button>

            </div>

        </form>

        <!-- FOOTER -->
        <div class="text-center mt-6 text-xs text-gray-500">
            ICT Department • Kilifi County Government
        </div>

    </div>
</div>

</x-guest-layout>