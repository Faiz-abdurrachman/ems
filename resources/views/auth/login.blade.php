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
            <div class="mx-auto flex h-16 w-16 items-center justify-center border-2 border-black bg-gradient-to-br from-blue-400 to-blue-700 shadow-[4px_4px_0px_0px_#000]">
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
                        <label for="email" class="block text-sm font-bold text-ink mb-2 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                            class="mt-2 block w-full border-2 border-black px-4 py-3 text-sm font-bold bg-blue-50 focus:bg-blue-100 focus:outline-none transition-all {{ $errors->has('email') ? 'border-coral bg-coral/20' : '' }}"
                            placeholder="admin@ems.test" required autofocus>
                        @error('email')
                            <p class="mt-1.5 text-sm font-bold text-coral">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-bold text-ink mb-2 uppercase tracking-wider">Password</label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="block w-full border-2 border-black px-4 py-3 pr-12 text-sm font-bold bg-blue-50 focus:bg-blue-100 focus:outline-none transition-all {{ $errors->has('password') ? 'border-coral bg-coral/20' : '' }}"
                                placeholder="••••••••" required>
                            <button type="button" onclick="const p=document.getElementById('password'); p.type=p.type==='password'?'text':'password'; this.innerHTML=p.type==='password'?'<svg class=\'h-5 w-5\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M15 12a3 3 0 11-6 0 3 3 0 016 0z\'/><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z\'/></svg>':'<svg class=\'h-5 w-5\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'currentColor\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.05 10.05 0 015.458-5.911m1.278-1.278A10.052 10.052 0 0112 5c4.478 0 8.268 2.943 9.542 7a10.05 10.05 0 01-2.012 3.44m-2.122 2.122a3 3 0 11-4.243-4.243m6.364 6.364l-14.14-14.14\'/></svg>'" class="absolute inset-y-0 right-0 flex items-center pr-3 text-ink/60 hover:text-ink cursor-pointer">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
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
