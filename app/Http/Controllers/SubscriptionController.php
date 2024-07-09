<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = Subscription::all();
        return view('subscriptions.index', compact('subscriptions'));
    }

    public function create()
    {
        $members = Member::all();
        return view('subscriptions.create', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'number_of_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

    if(Auth::user()->role =='member'){
        $existingSubscription = Subscription::where('user_id', $request->member_id)
            
            ->first();

        if ($existingSubscription) {
            return redirect()->route('dashboard')->with('error', 'Subscription already exists.');
        }
    }
        // Calculate end date based on start date and number of months
        $endDate = date('Y-m-d', strtotime($request->start_date . ' + ' . $request->number_of_months . ' months'));

        Subscription::create([
            'user_id' => $request->member_id,
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'status' => 'notvalid', // Default status
            'price' => $request->price,
            'number_of_months' => $request->number_of_months,
        ]);

        return redirect()->route('dashboard')->with('success', 'Subscription created successfully.');
    }

    public function show(Subscription $subscription)
    {
        return view('subscriptions.show', compact('subscription'));
    }

    public function edit(Subscription $subscription)
    {
        $members = Member::all();
        return view('subscriptions.edit', compact('subscription', 'members'));
    }

    public function update(Request $request, Subscription $subscription)
    {
        $request->validate([
            
            'start_date' => 'required|date',
            'number_of_months' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // Check if subscription already exists
        $existingSubscription = Subscription::where('user_id', $request->member_id)
            ->where('start_date', $request->start_date)
            ->where('id', '!=', $subscription->id) // Exclude the current subscription being updated
            ->first();

        if ($existingSubscription) {
            return redirect()->route('subscriptions.index')->with('error', 'Subscription already exists.');
        }

        // Calculate end date based on start date and number of months
        $endDate = date('Y-m-d', strtotime($request->start_date . ' + ' . $request->number_of_months . ' months'));

        $subscription->update([
          
            'start_date' => $request->start_date,
            'end_date' => $endDate,
            'price' => $request->price,
            'number_of_months' => $request->number_of_months,
        ]);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription updated successfully.');
    }

    public function destroy(Subscription $subscription)
    {
        $subscription->delete();
        return redirect()->route('subscriptions.index')->with('success', 'Subscription deleted successfully.');
    }
  public function validateSubscription(Subscription $subscription)
    {
        $subscription->update(['status' => 'valid']);
        return redirect()->route('subscriptions.index')->with('success', 'Subscription validated successfully.');
    }

    public function invalidateSubscription(Subscription $subscription)
    {
        $subscription->update(['status' => 'notvalid']);
        return redirect()->route('subscriptions.index')->with('success', 'Subscription invalidated successfully.');
    }

    public function deleteExpired()
    {
        $expiredSubscriptions = Subscription::where('end_date', '<', now())->get();
        foreach ($expiredSubscriptions as $subscription) {
            $subscription->delete();
        }

        return redirect()->route('subscriptions.index')->with('success', 'Expired subscriptions deleted successfully.');
    }
}
