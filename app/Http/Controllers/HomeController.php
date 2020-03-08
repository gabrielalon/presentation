<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

class HomeController extends Controller
{
    /**
     * HomeController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @return Renderable
     */
    public function images()
    {
        return view('images');
    }
}
