<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Post as Repository;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {   $data = [
        'posts' => $this->getRepository()->setResultOrder('created_at', 'DESC')->getPaginated(),
        'user'  => Auth::user()
    ];
        return view('home', $data);
    }

    protected function getRepository()
    {
        return new Repository;
    }
}
