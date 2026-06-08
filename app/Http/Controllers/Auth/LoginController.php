<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * 顯示登入表單
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * 處理登入請求
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);

        $login = $request->input('login');
        $password = $request->input('password');
        $remember = $request->boolean('remember');

        // 判斷輸入是 email 還是使用者名稱
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        if (Auth::attempt($credentials, $remember)) {
            // 帳號遭停用：登出並回報，不予放行
            if (! Auth::user()->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                throw ValidationException::withMessages([
                    'login' => '此帳號已被停用，請聯絡管理員。',
                ]);
            }

            $request->session()->regenerate();

            flash_success('登入成功');

            return redirect()->intended(route('admin.dashboard'));
        }

        throw ValidationException::withMessages([
            'login' => '提供的憑證與我們的記錄不符。',
        ]);
    }

    /**
     * 登出
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        flash_success('已成功登出');

        return redirect()->route('login');
    }
}
