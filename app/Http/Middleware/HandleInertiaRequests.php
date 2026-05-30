<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Setting;

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
    public function version(Request $request): ?string
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
        return [
            ...parent::share($request),
            'auth' => [
                'user' => fn () => $this->sanitizeUtf8($request->user()?->toArray()),
            ],
            'flash' => [
                'mensaje' => fn () => $this->sanitizeUtf8($request->session()->get('mensaje')),
            ],
            'settings' => [
                'registro_habilitado' => fn () => Setting::get('registro_habilitado', false),
                'ranking_acumula_puntos' => fn () => (string) Setting::get('ranking_acumula_puntos', '1'),
                'ranking_template' => fn () => (string) Setting::get('ranking_template', '1'),
            ],
        ];
    }

    /**
     * Recursively ensure every string in the value is valid UTF-8.
     *
     * Strategy:
     *   1. Already valid UTF-8 → return as-is.
     *   2. Not valid UTF-8 → interpret bytes as Windows-1252 (superset of
     *      ISO-8859-1, covers all single-byte values 0x00-0xFF) and re-encode
     *      to UTF-8.  This correctly handles Latin-American names stored with
     *      the wrong DB charset (e.g. "José" stored as Latin-1 bytes).
     *   3. After conversion, strip any remaining invalid sequences with iconv
     *      as a final safety net.
     */
    private function sanitizeUtf8(mixed $value): mixed
    {
        if ($value === null) {
            return null;
        }

        if (is_string($value)) {
            if (mb_check_encoding($value, 'UTF-8')) {
                return $value;
            }

            // Windows-1252 covers all 256 byte values, so this conversion
            // always succeeds and produces valid UTF-8 output.
            $converted = mb_convert_encoding($value, 'UTF-8', 'Windows-1252');

            // iconv final pass: strip any byte that remains invalid.
            $safe = @iconv('UTF-8', 'UTF-8//IGNORE', $converted);

            return $safe !== false ? $safe : $converted;
        }

        if (is_array($value)) {
            return array_map([$this, 'sanitizeUtf8'], $value);
        }

        return $value;
    }
}
