<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Session;

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
    {
        $menu = 'home';
        $sub_menu = 'null';
        $item_menu = 'null';
        return view('pages.admin.dashboard.index', compact('menu', 'sub_menu', 'item_menu'));
    }

    public function logout()
    {
        try {
            Session::flush();
            Auth::logout();
        } catch (QueryException $e) {
            Alert::error('Gagal', $e->errorInfo);
        }
    }
}
