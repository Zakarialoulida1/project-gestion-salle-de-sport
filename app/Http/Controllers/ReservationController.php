<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Member;
use App\Models\Course;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        $members = Member::all();
        $courses = Course::all();
        return view('reservations.create', compact('members', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:users,id',
            'course_id' => 'required|exists:courses,id',
            'reservation_date' => 'required|date',
        ]);

        // Check if reservation already exists
        $existingReservation = Reservation::where('member_id', $request->member_id)
            ->where('course_id', $request->course_id)
            ->where('reservation_date', $request->reservation_date)
            ->first();

        if ($existingReservation) {
            return redirect()->route('dashboard')->with('error', 'Reservation already exists.');
        }

        Reservation::create($request->all());

        return redirect()->route('dashboard')->with('success', 'Reservation created successfully.');
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $members = Member::all();
        $courses = Course::all();
        return view('reservations.edit', compact('reservation', 'members', 'courses'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'reservation_date' => 'required|date',
        ]);
    
        // Check if reservation already exists
        $existingReservation = Reservation::where('member_id', $reservation->member_id)
            ->where('course_id', $request->course_id)
            ->where('reservation_date', $request->reservation_date)
            ->where('id', '!=', $reservation->id) // Exclude the current reservation being updated
            ->first();
    
        if ($existingReservation) {
            return redirect()->route('reservations.index')->with('error', 'Reservation already exists.');
        }
    
        $reservation->update([
            'course_id' => $request->course_id,
            'reservation_date' => $request->reservation_date,
        ]);
    
        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }
    

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }
}
