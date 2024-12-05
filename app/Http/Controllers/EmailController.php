<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function create()
    {
        // Retrieve customers who have opted in to receive emails
        $customers = Customer::where('email_opt_in', true)->get();

        return view('emails.create', compact('customers'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
            'customers' => 'required|array'
        ]);

        $customers = Customer::whereIn('id', $request->customers)->get();

        foreach ($customers as $customer) {
            Mail::raw($request->body, function ($message) use ($customer, $request) {
                $message->to($customer->email)
                        ->subject($request->subject);
            });
        }

        return redirect()->back()->with('success', 'Emails sent successfully!');
    }
}

