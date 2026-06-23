<!DOCTYPE html>
<html lang="en" class="h-full bg-dots">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — EMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm relative">
            <div class="sticker mx-auto flex h-16 w-16 items-center justify-center border-2 border-black bg-gradient-to-br from-blue-400 to-blue-700 shadow-[4px_4px_0px_0px_#000]">
                <span class="text-3xl font-black text-white">E</span>
            </div>
            <div class="absolute -top-3 -right-2 text-2xl text-blue-500 font-black -rotate-12 select-none">✦</div>
            <h2 class="mt-6 text-center text-3xl font-black tracking-tighter text-ink uppercase">
                <span class="highlight px-2">Admin Login</span>
            </h2>
            <p class="mt-2 text-center text-sm font-extrabold text-ink/60 uppercase tracking-widest">Event Management System</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="border-2 border-black bg-white p-8 shadow-[6px_6px_0px_0px_#000,_12px_12px_0px_0px_rgba(192,132,252,.5)]">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="sticker inline-block text-sm font-extrabold text-ink uppercase tracking-wider border-2 border-ink px-2 py-0.5 bg-gradient-to-r from-blue-400 to-blue-700 text-white mb-2">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="mt-2 block w-full border-2 border-black px-4 py-3 text-sm font-bold bg-blue-50 focus:bg-blue-100 focus:outline-none transition-all {{ $errors->has('email') ? 'border-coral bg-coral/20' : '' }}"
                            placeholder="admin@ems.test" required autofocus>
                        @error('email')
                            <p class="mt-1.5 text-sm font-bold text-coral">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="sticker inline-block text-sm font-extrabold text-ink uppercase tracking-wider border-2 border-ink px-2 py-0.5 bg-gradient-to-r from-blue-400 to-blue-700 text-white mb-2">Password</label>
                        <input type="password" name="password" id="password"
                            class="block w-full border-2 border-black px-4 py-3 text-sm font-bold bg-blue-50 focus:bg-blue-100 focus:outline-none transition-all {{ $errors->has('password') ? 'border-coral bg-coral/20' : '' }}"
                            placeholder="••••••••" required>
                        @error('password')
                            <p class="mt-1.5 text-sm font-bold text-coral">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 border-2 border-black accent-electric">
                        <label for="remember" class="text-sm font-bold text-ink/70">Ingat saya</label>
                    </div>

                    <button type="submit" class="sticker flex w-full items-center justify-center border-2 border-black bg-gradient-to-r from-blue-400 to-blue-700 px-4 py-3.5 text-sm font-extrabold text-white uppercase tracking-wider shadow-[4px_4px_0px_0px_#000] hover:shadow-[2px_2px_0px_0px_#000] hover:translate-x-[2px] hover:translate-y-[2px] transition-all">
                        Masuk
                    </button>
                </form>
            </div>

            <p class="mt-8 text-center text-xs font-extrabold text-ink/25 uppercase tracking-widest">EMS v1.0 &mdash; Laravel {{ app()->version() }}</p>
        </div>
    </div>
</body>
</html>
