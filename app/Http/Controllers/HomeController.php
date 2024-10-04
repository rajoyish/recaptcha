<?php

namespace App\Http\Controllers;

use App\Notifications\SendContactForm;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function contact()
    {
        return view('contact');
    }

    public function thanks()
    {
        return view('thanks');
    }

    public function sendEmail(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email:rfc,dns', 'max:100'],
            'phone' => ['required', 'string'],
            'message' => ['required', 'string', 'max:255'],
        ]);

        \Notification::route('mail', 'rajesh@huesarrays.com')->notify(new SendContactForm($data));

        return redirect()->route('thanks');
    }
}
