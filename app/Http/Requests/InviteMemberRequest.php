<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InviteMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->currentTeam !== null;
    }

    public function rules(): array
    {
        $team = auth()->user()->currentTeam;

        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
                function ($attribute, $value, $fail) use ($team) {
                    if ($team && $team->members()->where('email', $value)->exists()) {
                        $fail('Este usuario ya es miembro del equipo.');
                    }
                },
            ],
            'role' => ['in:member,admin'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Debe ser un email válido.',
            'email.unique' => 'Ya existe un usuario con este email.',
            'role.in' => 'El rol debe ser miembro o administrador.',
        ];
    }
}
