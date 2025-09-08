<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'family' =>
                    $user && $user->family_id
                        ? [
                            'id' => session('family_id'),
                            'name' => session('family_name'),
                            'code' => session('family_code'),
                            'role' => session('family_role'),
                            'is_owner' => $user->family && $user->family->owner_id === $user->id,
                        ]
                        : null,
            ],
            'appName' => config('app.name'),
            'ziggy' => fn() => [...(new Ziggy())->toArray(), 'location' => $request->url()],
            'flash' => [
                'message' => fn() => $request->session()->get('message'),
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
            ],
        ];
    }
}
