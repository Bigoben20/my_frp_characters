<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function dashboard() {
        $characters = Character::where("user_id", Auth::user()->id)->orderBy("id","DESC")->get();

        return Inertia::render('Dashboard',compact("characters"));
    }
}
