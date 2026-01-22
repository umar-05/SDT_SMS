<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $role = auth()->user()->role;

        return match($role) {
            'it_staff' => redirect()->route('admin.dashboard'),
            'lecturer' => redirect()->route('lecturer.courses'),
            'student'  => redirect()->route('student.dashboard'),
            default    => redirect('/'),
        };
    }
}
