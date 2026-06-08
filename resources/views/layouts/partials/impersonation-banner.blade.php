@if(is_impersonating())
<div style="background:#b02a37;color:#fff;padding:.55rem 1rem;text-align:center;font-size:.95rem;position:sticky;top:0;z-index:1050;">
    <svg class="icon me-1" style="vertical-align:-3px;"><use xlink:href="/assets/icons/free.svg#cil-user"></use></svg>
    您正以 <strong>{{ auth()->user()->name }}</strong> 的身分操作（原帳號：{{ impersonator_name() }}）
    <form method="POST" action="{{ route('impersonate.leave') }}" class="d-inline ms-2">
        @csrf
        <button type="submit" class="btn btn-sm btn-light fw-semibold">返回原帳號</button>
    </form>
</div>
@endif
