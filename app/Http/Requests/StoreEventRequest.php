<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'event_date' => ['required', 'date', 'after:now'],
            'location' => ['required', 'string', 'max:255'],
            'quota' => ['required', 'integer', 'min:1'],
            'status' => ['required', 'in:upcoming,ongoing,completed,cancelled'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'category_id' => ['nullable', 'exists:categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Judul event wajib diisi.',
            'event_date.required' => 'Tanggal event wajib diisi.',
            'event_date.after' => 'Tanggal event harus setelah hari ini.',
            'location.required' => 'Lokasi event wajib diisi.',
            'quota.required' => 'Kuota peserta wajib diisi.',
            'quota.integer' => 'Kuota harus berupa angka.',
            'quota.min' => 'Kuota minimal 1 peserta.',
            'status.required' => 'Status event wajib dipilih.',
            'image.image' => 'File harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPEG, PNG, atau WebP.',
            'image.max' => 'Ukuran gambar maksimal 5 MB.',
        ];
    }
}
