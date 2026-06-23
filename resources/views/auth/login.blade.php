<!DOCTYPE html>
<html lang="en" class="h-full bg-warm">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login — EMS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="mx-auto flex h-14 w-14 items-center justify-center border-2 border-black bg-sun shadow-[3px_3px_0px_0px_#000]">
                <span class="text-2xl font-extrabold text-ink">E</span>
            </div>
            <h2 class="mt-6 text-center text-3xl font-extrabold tracking-tighter text-ink uppercase">Admin Login</h2>
            <p class="mt-2 text-center text-sm font-bold text-ink/50">Event Management System</p>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-sm">
            <div class="border-2 border-black bg-white p-8 shadow-[6px_6px_0px_0px_#000]">
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-extrabold text-ink uppercase tracking-wider mb-1.5">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="mt-1 block w-full border-2 border-black px-4 py-2.5 text-sm font-bold shadow-[3px_3px_0px_0px_#000] focus:outline-none focus:shadow-[1px_1px_0px_0px_#000] focus:translate-x-[2px] focus:translate-y-[2px] transition-all {{ $errors->has('email') ? 'border-coral bg-red-50' : '' }}"
                            placeholder="admin@ems.test" required autofocus>
                        @error('email')
                            <p class="mt-1.5 text-sm font-bold text-coral">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-sm font-extrabold text-ink uppercase tracking-wider">Password</label>
                        </div>
                        <input type="password" name="password" id="password"
                            class="block w-full border-2 border-black px-4 py-2.5 text-sm font-bold shadow-[3px_3px_0px_0px_#000] focus:outline-none focus:shadow-[1px_1px_0px_0px_#000] focus:translate-x-[2px] focus:translate-y-[2px] transition-all {{ $errors->has('password') ? 'border-coral bg-red-50' : '' }}"
                            placeholder="••••••••" required>
                        @error('password')
                            <p class="mt-1.5 text-sm font-bold text-coral">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="remember" id="remember" class="h-4 w-4 border-2 border-black accent-sun">
                        <label for="remember" class="text-sm font-bold text-ink/60">Ingat saya</label>
                    </div>

                    <button type="submit" class="flex w-full items-center justify-center border-2 border-black bg-sun px-4 py-3 text-sm font-extrabold text-ink uppercase tracking-wider shadow-[4px_4px_0px_0px_#000] hover:shadow-none hover:translate-x-[4px] hover:translate-y-[4px] transition-all">
                        Masuk
                    </button>
                </form>
            </div>

            <p class="mt-6 text-center text-xs font-bold text-ink/30">EMS v1.0 — Laravel {{ app()->version() }}</p>
        </div>
    </div>
</body>
</html>
