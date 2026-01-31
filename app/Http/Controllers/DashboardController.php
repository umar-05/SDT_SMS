<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // helper auth() or facade Auth::user() both work
        $role = auth()->user()->role; 

        return match($role) {
            // FIX: Changed 'lecturer.courses' to 'lecturer.dashboard'
            'lecturer' => redirect()->route('lecturer.dashboard'),
            
            // These should match your route names in web.php
            'it_staff' => redirect()->route('admin.dashboard'),
            'student'  => redirect()->route('student.dashboard'),
            default    => redirect('/'),
        };
    }
}