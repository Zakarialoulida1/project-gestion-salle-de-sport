<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::all();
        return view('members.index', compact('members'));
    }
    public function create()
{
    return view('members.create');
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:members',
        'password' => 'required|string|min:8|confirmed',
        'role' => 'required|in:admin,user',
    ]);

    Member::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role,
    ]);

    return redirect()->route('members.index')->with('success', 'Member created successfully.');
}

public function show(Member $member)
{
    return view('members.show', compact('member'));
}
public function edit(Member $member)
{
    return view('members.edit', compact('member'));
}
public function update(Request $request, Member $member)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:members,email,' . $member->id,
        'password' => 'nullable|string|min:8|confirmed',
        'role' => 'required|in:admin,user',
    ]);

    $member->update([
        'name' => $request->name,
        'email' => $request->email,
        'password' => $request->password ? bcrypt($request->password) : $member->password,
        'role' => $request->role,
    ]);

    return redirect()->route('members.index')->with('success', 'Member updated successfully.');
}

public function destroy(Member $member)
{
    // Supprimer toutes les réservations associées
    $member->reservations()->delete();

    // Ensuite, supprimer le membre
    $member->delete();

    return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
}

    
}
