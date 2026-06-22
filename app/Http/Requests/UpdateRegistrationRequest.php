<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $registrationId = $this->route('registration');

        return [
            'event_id' => ['required', 'exists:events,id'],
            'participant_id' => ['required', 'exists:participants,id'],
            'event_id' => [
                Rule::unique('registrations')
                    ->where('participant_id', $this->participant_id)
                    ->ignore($registrationId),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'event_id.required' => 'Event wajib dipilih.',
            'event_id.exists' => 'Event tidak ditemukan.',
            'event_id.unique' => 'Peserta sudah terdaftar di event ini.',
            'participant_id.required' => 'Peserta wajib dipilih.',
            'participant_id.exists' => 'Peserta tidak ditemukan.',
        ];
    }
}
