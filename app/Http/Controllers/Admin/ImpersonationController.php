<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class ImpersonationController extends Controller
{
    /**
     * 開始模擬登入指定用戶（限 super-admin）。
     */
    public function start(User $user): RedirectResponse
    {
        $me = auth()->user();

        // 工程師或超級管理員可發起
        abort_unless($me->isEngineer() || $me->hasRole('super-admin'), 403);

        if (session()->has('impersonate.by_id')) {
            flash_warning('目前已在模擬狀態，請先返回原帳號');
            return redirect()->back();
        }

        if ($user->id === $me->id) {
            flash_warning('無法模擬自己');
            return redirect()->back();
        }

        // 工程師帳號受保護，任何人都不能模擬
        if ($user->isEngineer()) {
            flash_warning('無法模擬工程師帳號');
            return redirect()->back();
        }

        // 超級管理員只有工程師能模擬；超級管理員彼此不能模擬
        if ($user->hasRole('super-admin') && ! $me->isEngineer()) {
            flash_warning('無法模擬其他超級管理員');
            return redirect()->back();
        }

        // 先記錄原始身分，再切換登入（session 資料會保留）
        session(['impersonate' => ['by_id' => $me->id, 'by_name' => $me->name]]);
        Auth::login($user);

        flash_success("您正在以「{$user->name}」的身分操作");

        return redirect()->route('admin.dashboard');
    }

    /**
     * 結束模擬，返回原始超級管理員帳號。
     * 此動作只需 auth（不需 verified），確保任何情況都能返回。
     */
    public function leave(): RedirectResponse
    {
        $originalId = session('impersonate.by_id');

        if (! $originalId) {
            return redirect()->route('admin.dashboard');
        }

        Auth::loginUsingId($originalId);
        session()->forget('impersonate');

        flash_success('已返回原本的帳號');

        return redirect()->route('admin.users.index');
    }
}
