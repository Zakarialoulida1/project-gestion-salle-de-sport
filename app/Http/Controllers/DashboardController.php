<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch necessary data for the dashboard
        $courses = Course::all(); // Example: Fetching courses

        return view('dashboard', compact('courses'));
    }
}
