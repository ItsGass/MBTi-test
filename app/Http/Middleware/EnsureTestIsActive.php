<?php

namespace App\Http\Middleware;

use App\Enums\SessionStatus;
use App\Models\UserTest;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTestIsActive
{
    /**
     * Guard the mutating test endpoints against completed or timed-out attempts.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userTest = $request->route('userTest');

        if (! $userTest instanceof UserTest) {
            return $next($request);
        }

        if ($userTest->isCompleted()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Tes ini sudah selesai.',
                    'redirect' => route('result.show', $userTest),
                ], 409);
            }

            return redirect()->route('result.show', $userTest);
        }

        if ($userTest->hasExpired()) {
            if ($userTest->status !== SessionStatus::Expired) {
                $userTest->update(['status' => SessionStatus::Expired]);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesi tes sudah kedaluwarsa. Silakan mulai tes baru.',
                    'redirect' => route('test.create'),
                ], 410);
            }

            return response()
                ->view('pages.test.expired', ['userTest' => $userTest], 410);
        }

        return $next($request);
    }
}
