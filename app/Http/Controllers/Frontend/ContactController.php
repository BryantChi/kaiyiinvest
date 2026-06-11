<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreContactRequest;
use App\Mail\ContactReceived;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function show(): View
    {
        return view('frontend.contact');
    }

    public function store(StoreContactRequest $request): RedirectResponse
    {
        // 蜜罐：正常使用者不會填隱藏的 website 欄位；有值即視為機器人灌水，
        // 靜默回應成功（不入庫、不寄信、不顯示錯誤，避免讓 bot 察覺被擋）。
        if ($request->filled('website')) {
            return redirect()
                ->back()
                ->with('success', __('感謝您的來信，我們將盡快與您聯繫。'));
        }

        $contact = Contact::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'subject' => $request->input('subject'),
            'message' => $request->input('message'),
            'locale' => app()->getLocale(),
            'ip' => $request->ip(),
        ]);

        // 寄送通知給管理者；寄信失敗不影響已存檔的紀錄
        try {
            $recipient = setting('contact_recipient') ?: config('mail.from.address');
            if ($recipient) {
                Mail::to($recipient)->send(new ContactReceived($contact));
            }
        } catch (\Throwable $e) {
            Log::warning('聯絡表單通知信寄送失敗：' . $e->getMessage());
        }

        return redirect()
            ->back()
            ->with('success', __('感謝您的來信，我們將盡快與您聯繫。'));
    }
}
