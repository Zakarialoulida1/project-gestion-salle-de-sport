<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required',
            'instructor' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('images', 'public') : null;

        Course::create([
            'name' => $request->name,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'instructor' => $request->instructor,
            'image' => $imagePath,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'instructor' => 'required|string|max:255',
            'image' => 'nullable|image',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }

            $imagePath = $request->file('image')->store('images', 'public');
            $course->image = $imagePath;
        }

        $course->update([
            'name' => $request->name,
            'description' => $request->description,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'instructor' => $request->instructor,
            'image' => $course->image,
        ]);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function register(Course $course)
    {
        // Check if the user is authenticated
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Check if the user is already registered for the course
        $existingReservation = Reservation::where('member_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if ($existingReservation) {
            return redirect()->route('courses.show', $course)->with('error', 'Vous êtes déjà inscrit à ce cours.');
        }

        // Create a new reservation for the authenticated user
        Reservation::create([
            'member_id' => $user->id,
            'course_id' => $course->id,
            'reservation_date' => now(),
        ]);

        return redirect()->route('courses.show', $course)->with('success', 'Vous êtes inscrit à ce cours.');
    }
}
