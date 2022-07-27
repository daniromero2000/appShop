<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Api\Controller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return view
     */
    public function index(): view
    {
        return view('home');
    }
}
