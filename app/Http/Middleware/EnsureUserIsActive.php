<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * 已登入但帳號遭停用者，於下一個請求即時登出並導回登入頁。
 * 與登入時的阻擋（LoginController）相輔，達成「停用即時生效」。
 */
class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && ! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['login' => '此帳號已被停用，請聯絡管理員。']);
        }

        return $next($request);
    }
}
