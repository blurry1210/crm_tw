<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerDocumentController extends Controller
{
    public function index(Customer $customer)
    {
        $documents = $customer->tasks->pluck('documents')->flatten()->filter();

        return view('customers.documents', compact('customer', 'documents'));
    }
}
