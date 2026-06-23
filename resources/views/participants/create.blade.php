@extends('layouts.admin')

@section('title', 'Add Participant')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('admin.participants.index') }}"
           class="inline-flex items-center gap-1.5 text-sm text-ink/50 font-bold hover:text-ink transition-colors">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Back
        </a>
    </div>

    <div class="border-2 border-black bg-white shadow-[5px_5px_0px_0px_#000]">
        <div class="border-b border-black px-6 py-4">
            <h2 class="text-lg font-extrabold text-ink">Add Participant</h2>
            <p class="mt-0.5 text-sm text-ink/50 font-bold">Register a new participant in the system.</p>
        </div>

        <form action="{{ route('admin.participants.store') }}" method="POST" class="px-6 py-5 space-y-5">
            @csrf

            <div>
                <label for="name" class="block text-sm font-bold text-ink mb-1.5">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                       class="block w-full rounded-lg border-black shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('name') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                       placeholder="Enter participant name">
                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-bold text-ink mb-1.5">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                       class="block w-full rounded-lg border-black shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('email') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                       placeholder="email@example.com">
                @error('email')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="nim" class="block text-sm font-bold text-ink mb-1.5">NIM</label>
                <input type="text" name="nim" id="nim" value="{{ old('nim') }}"
                       class="block w-full rounded-lg border-black shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('nim') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                       placeholder="Masukkan NIM">
                @error('nim')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="jurusan" class="block text-sm font-bold text-ink mb-1.5">Jurusan</label>
                <select name="jurusan" id="jurusan"
                        class="block w-full rounded-lg border-black shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('jurusan') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror">
                    <option value="">Pilih Jurusan</option>
                    @foreach(['Teknik Informatika','Sistem Informasi','Manajemen Informatika','Teknik Komputer','Teknologi Informasi'] as $j)
                        <option value="{{ $j }}" {{ old('jurusan') == $j ? 'selected' : '' }}>{{ $j }}</option>
                    @endforeach
                </select>
                @error('jurusan')<p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="phone" class="block text-sm font-bold text-ink mb-1.5">Telepon <span class="text-ink/40 font-normal">(opsional)</span></label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                       class="block w-full rounded-lg border-black shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 text-sm @error('phone') border-red-300 focus:border-red-500 focus:ring-red-200 @enderror"
                       placeholder="Enter phone number">
                @error('phone')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end gap-3 pt-2">
                <a href="{{ route('admin.participants.index') }}"
                   class="rounded-lg border border-black bg-white px-4 py-2 text-sm font-bold text-ink hover:bg-sun/20 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-bold text-white hover:bg-black hover:text-white transition-colors">
                    Save Participant
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
