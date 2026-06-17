<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

trait RespondsWithWebOrJson
{
    protected function jsonOrRedirect(
        Request $request,
        string $message,
        array $data = [],
        int $status = 201,
        mixed $redirect = null,
        string $flashKey = 'status',
    ): JsonResponse|RedirectResponse {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                ...$data,
            ], $status);
        }

        return redirect($redirect ?? back())->with($flashKey, $message);
    }
}
