<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calendar;
use App\Models\Customer;

class CalendarController extends Controller
{
    public function index()
    {
        $events = Calendar::with('customer')->get();
        return view('calendar.index', compact('events'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('calendar.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'customer_id' => 'required|exists:customers,id',
        ]);

        Calendar::create($request->all());

        return redirect()->route('calendar.index')->with('success', 'Event added successfully.');
    }

    public function edit(Calendar $calendar)
    {
        $customers = Customer::all();
        return view('calendar.edit', compact('calendar', 'customers'));
    }

    public function update(Request $request, Calendar $calendar)
    {
        $calendar->update($request->all());
        return redirect()->route('calendar.index')->with('success', 'Event updated successfully');
    }


    public function destroy(Calendar $calendar)
    {
        $calendar->delete();

        return redirect()->route('calendar.index')->with('success', 'Event deleted successfully.');
    }
}
