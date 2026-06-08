<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Faq;

class PageController extends Controller
{
    /**
     * 首頁。原 HTML 首頁未顯示 footer，故 $hideFooter = true。
     */
    public function home()
    {
        return view('frontend.home', ['hideFooter' => true]);
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function services()
    {
        return view('frontend.services');
    }

    public function industrialDevelopment()
    {
        return view('frontend.industrial-development');
    }

    public function rentalManagement()
    {
        return view('frontend.rental-management');
    }

    public function partners()
    {
        return view('frontend.partners');
    }

    public function faq()
    {
        $faqs = Faq::active()->ordered()->with('translations')->get();
        return view('frontend.faq', compact('faqs'));
    }
}
