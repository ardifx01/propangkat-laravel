<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nip' => ['required', 'string', 'size:18'], // NIP with 18 digits
            'password' => ['required', 'string'],
            'role' => ['required', 'string', 'in:admin,operator,operator-sekolah,pegawai'],
            'captcha' => ['required', 'string'],
            'captchaCode' => ['required', 'string', 'same:captcha'],
        ];
    }
    
    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nip.required' => 'NIP wajib diisi.',
            'nip.size' => 'NIP harus terdiri dari 18 digit.',
            'captcha.required' => 'Kode captcha wajib diisi.',
            'captchaCode.same' => 'Kode captcha tidak valid.',
            'role.required' => 'Silakan pilih jenis pengguna.',
            'role.in' => 'Jenis pengguna tidak valid.',
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        $input = $this->validated();
        
        // Set up credentials using NIP
        $credentials = [
            'nip' => $input['nip'],
            'password' => $input['password']
        ];

        // Get remember value
        $remember = $this->remember ?? false;
        
        if (! Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'nip' => trans('auth.failed'),
            ]);
        }

        // Store selected role in session for later use in authorization
        session(['user_role' => $input['role']]);

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->validated('nip')).'|'.request()->ip());
    }
}
