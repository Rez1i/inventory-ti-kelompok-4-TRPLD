<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Models\Notifikasi; // Sesuaikan dengan model dan namespace yang benar

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        // Ambil notifikasi dari database
        if (auth()->check()) {
            $notifications = Notifikasi::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')// Batasi jumlah notifikasi yang diambil
                ->simplepaginate(5);

            // Bagikan data notifikasi ke semua view
            View::share('notifications', $notifications);
        }

        return $next($request);
    }
}
