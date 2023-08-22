<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function redirect()
    {
        $usertype = Auth::user()->usertype;

        if ($usertype == '1') {

            return view('admin.home');
        } else {

            return view('home.userpage');
        }
    }

    public function index()
    {
        return view('home.userpage');
    }
}
