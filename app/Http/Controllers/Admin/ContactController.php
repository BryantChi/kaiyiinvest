<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $query = Contact::query()->latest();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->get('filter') === 'unread') {
            $query->unread();
        }

        $contacts = $query->paginate(20)->withQueryString();
        $unreadCount = Contact::unread()->count();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    public function show(Contact $contact): View
    {
        // 開啟即標記為已讀
        if (! $contact->is_read) {
            $contact->update(['is_read' => true]);
        }

        return view('admin.contacts.show', compact('contact'));
    }

    public function markRead(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => ! $contact->is_read]);

        flash_success($contact->is_read ? '已標記為已讀' : '已標記為未讀');

        return redirect()->back();
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        flash_success('聯絡訊息已刪除');

        return redirect()->route('admin.contacts.index');
    }
}
