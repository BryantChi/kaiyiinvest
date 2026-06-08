<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $query = User::with('roles');

        // 搜尋
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // 角色篩選
        if ($request->filled('role')) {
            $query->role($request->role);
        }

        // 非工程師看不到工程師帳號
        if (! auth()->user()->isEngineer()) {
            $query->whereDoesntHave('roles', fn ($q) => $q->where('name', User::ENGINEER_ROLE));
        }

        $users = $query->latest()->paginate(15);
        $roles = $this->assignableRoles();

        return view('admin.users.index', compact('users', 'roles'));
    }

    /** 可在 UI 顯示/指派的角色（隱藏 engineer 內部角色） */
    protected function assignableRoles()
    {
        return Role::where('name', '!=', User::ENGINEER_ROLE)->get();
    }

    /** 保護：非工程師不可檢視/編輯工程師帳號 */
    protected function guardEngineer(User $user): void
    {
        abort_if($user->isEngineer() && ! auth()->user()->isEngineer(), 403, '此帳號受保護');
    }

    /** 同步角色：一般情況剔除 engineer；目標本為工程師則保留 engineer */
    protected function resolveRoles(array $roles, User $user): array
    {
        $roles = collect($roles)->reject(fn ($r) => $r === User::ENGINEER_ROLE);
        if ($user->exists && $user->isEngineer()) {
            $roles->push(User::ENGINEER_ROLE);
        }
        return $roles->unique()->values()->all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $roles = $this->assignableRoles();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_active' => $request->boolean('is_active'),
        ]);

        $user->syncRoles($this->resolveRoles($validated['roles'] ?? [], $user));

        flash_success('用戶建立成功');

        return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        $this->guardEngineer($user);
        $user->load(['roles', 'permissions']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        $this->guardEngineer($user);
        $roles = $this->assignableRoles();
        $user->load('roles');
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $this->guardEngineer($user);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'is_active' => 'boolean',
        ]);

        $attributes = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        // 不可把自己停用（避免自鎖）；僅在編輯他人時套用啟用狀態
        if ($user->id !== auth()->id()) {
            $attributes['is_active'] = $request->boolean('is_active');
        }

        $user->update($attributes);

        if (!empty($validated['password'])) {
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);
        }

        if (isset($validated['roles'])) {
            $user->syncRoles($this->resolveRoles($validated['roles'], $user));
        }

        flash_success('用戶更新成功');

        return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        if ($user->isEngineer()) {
            flash_error('工程師帳號受保護，無法刪除');
            return redirect()->back();
        }

        if ($user->id === auth()->id()) {
            flash_error('無法刪除目前登入的用戶');
            return redirect()->back();
        }

        $user->delete();

        flash_success('用戶刪除成功');

        return redirect()->route('admin.users.index');
    }

    /**
     * 啟用 / 停用帳號。停用後該用戶無法登入，且在線 session 於下個請求即時登出。
     */
    public function toggleActive(User $user): RedirectResponse
    {
        $this->guardEngineer($user);

        if ($user->id === auth()->id()) {
            flash_error('無法停用目前登入的帳號');
            return redirect()->back();
        }

        $user->update(['is_active' => ! $user->is_active]);

        flash_success($user->is_active ? "已啟用「{$user->name}」" : "已停用「{$user->name}」");

        return redirect()->back();
    }
}
