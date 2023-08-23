<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
        $category = Category::all();
        $product = Product::orderBy('updated_at', 'desc')->get();

        if ($usertype == '1') {

            return view('admin.product', compact('category', 'product'));
        } else {
            $product = Product::paginate(10);
            return view('home.userpage', compact('product'));
        }
    }

    public function index()
    {
        $product = Product::paginate(10);
        return view('home.userpage', compact('product'));
    }
}
