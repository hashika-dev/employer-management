<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function index()
    {
        // Get all users who are 'pending'
        $pendingUsers = User::where('status', 'pending')->get();
        return view('admin.approvals.index', compact('pendingUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'active'; // Activate them
        $user->save();

        return redirect()->back()->with('success', 'User approved successfully!');
    }
}