<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureQualificationComplete
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var User|null $user */
$user = Auth::user();

        if (!$user->isQualificationComplete()) {

            return redirect()
                ->route('dashboard')
                ->with(
                    'warning',
                    'Silakan lengkapi Kualifikasi terlebih dahulu sebelum menggunakan fitur Perangkingan.'
                );
        }

        return $next($request);
    }
}
