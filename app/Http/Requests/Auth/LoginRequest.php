<?php

namespace App\Http\Requests\Auth;

use App\Models\Family;
use App\Services\FamilyAuthService;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    protected ?Family $family = null;

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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'family_code' => ['required', 'string'],
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

        //        if (!Auth::attempt($this->only('email', 'password'), $this->boolean('remember'))) {
        //            RateLimiter::hit($this->throttleKey());
        //
        //            throw ValidationException::withMessages([
        //                'email' => trans('auth.failed'),
        //            ]);
        //        }
        $service = new FamilyAuthService();
        $family = $service->authenticateByFamilyCode($this->input('family_code'));
        if (!$family) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        $user = $service->authenticateMember($family, $this->input('email'), $this->input('password'));

        if (!$user) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => trans('auth.failed'),
            ]);
        }

        // ユーザーが家族のメンバーかを再確認
        if ($user->family_id !== $family->id) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => 'この家族のメンバーではありません。',
            ]);
        }

        Auth::login($user, $this->boolean('remember'));
        $this->setFamilySession($family);
        $this->family = $family;

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
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
        $email = Str::transliterate(Str::lower($this->input('email')));
        $family_code = Str::upper($this->input('family_code'));

        return $email . '|' . $family_code . '|' . $this->ip();
    }

    /**
     * 家族情報をセッションに設定
     */
    protected function setFamilySession(?Family $family): void
    {
        if (!$family) {
            return;
        }

        session([
            'family_id' => $family->id,
            'family_name' => $family->name,
            'family_code' => $family->code,
            'family_role' => Auth::user()->family_role,
        ]);
    }

    /**
     * Get the authenticated family.
     */
    public function getFamily(): ?Family
    {
        return $this->family;
    }
}
