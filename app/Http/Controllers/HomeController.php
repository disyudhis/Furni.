<?php

namespace App\Http\Controllers;

use Stripe;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function product_details($id)
    {
        $product = Product::find($id);

        return view('home.product_details', compact('product'));
    }

    public function add_cart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userid = $user->id;
            $product = Product::find($id);
            $product_exist_id = Cart::where('product_id', '=', $id)->where('user_id', '=', $userid)->get('id')->first();
            if ($product_exist_id) {
                $cart = cart::find($product_exist_id)->first();
                $quantity = $cart->quantity;
                $cart->quantity = $quantity + $request->quantity;
                if ($product->discount_price != null) {

                    $cart->price = $product->discount_price * $cart->quantity;
                } else {
                    $cart->price = $product->price * $cart->quantity;
                }
                $cart->save();
                Alert::success('Product Added Successfully', 'We have added product to the cart');
                return redirect()->back();
            } else {
                $cart = new Cart;
                $cart->name = $user->name;
                $cart->email = $user->email;
                $cart->phone = $user->phone;
                $cart->address = $user->address;
                $cart->user_id = $user->id;
                $cart->product_title = $product->title;
                if ($product->discount_price != null) {

                    $cart->price = $product->discount_price * $request->quantity;
                } else {
                    $cart->price = $product->price * $request->quantity;
                }
                $cart->image = $product->image;
                $cart->product_id = $product->id;
                $cart->quantity = $request->quantity;
                $cart->save();
                Alert::success('Product Added Successfully', 'We have added product to the cart');
                return redirect('show_cart');
            }
        } else {
            return redirect('login');
        }
    }

    public function show_cart()
    {
        if (Auth::id()) {
            $id = Auth::user()->id;
            $cart = Cart::where('user_id', '=', $id)->get();
            return view('home.cart', compact('cart'));
        } else {
            return redirect('login');
        }
    }

    public function remove_cart($id)
    {
        $cart = Cart::find($id);
        $cart->delete();
        Alert::warning('Product removed', 'You have remove a product from the cart');
        return redirect()->back();
    }

    public function decreaseQuantity($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            if ($cart->quantity > 1) {
                $product = Product::find($cart->product_id);
                $cart->quantity--;
                if ($product->discount_price != null) {
                    $cart->price -= $product->discount_price;
                } else {
                    $cart->price -= $product->price;
                }
                $cart->save();
            } else {
                // Remove item from cart or show an error message
                $cart->delete();
            }
        }

        return redirect()->back(); // Redirect back to the cart page
    }

    public function increaseQuantity($cartId)
    {
        $cart = Cart::find($cartId);

        if ($cart) {
            $product = Product::find($cart->product_id);
            $cart->quantity++;
            if ($product->discount_price != null) {
                $cart->price += $product->discount_price;
            } else {
                $cart->price += $product->price;
            }
            $cart->save();
        }

        return redirect()->back(); // Redirect back to the cart page
    }

    public function cash_order()
    {
        $user = Auth::user();
        $userid = $user->id;
        $data = Cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order;
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;

            $order->payment_status = 'cash on delivery';
            $order->delivery_status = 'processing';

            $order->save();

            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();
        }
        Alert::success('Product(s) have been checkout', 'Thank you for your support!');
        return redirect()->back();
    }

    public function stripe($totalPrice)
    {
        return view('home.stripe', compact('totalPrice'));
    }

    public function stripePost(Request $request, $totalPrice)
    {
        Stripe\Stripe::setApiKey('sk_test_51NfGiQKVBk5Kb9tfHHlyQoK9Rf3vznY5rwP35FXLCEP51MtKQvM8eRpCgQ0MvYs9uCrK0fIJKXZfENDFZlnAYYaI00B6LIMrSh');

        Stripe\Charge::create([
            "amount" => $totalPrice,
            "currency" => "idr",
            "source" => $request->stripeToken,
            "description" => "Thankyou for your support!"
        ]);

        $user = Auth::user();
        $userid = $user->id;
        $data = Cart::where('user_id', '=', $userid)->get();

        foreach ($data as $data) {
            $order = new Order;
            $order->name = $data->name;
            $order->email = $data->email;
            $order->phone = $data->phone;
            $order->address = $data->address;
            $order->user_id = $data->user_id;
            $order->product_title = $data->product_title;
            $order->price = $data->price;
            $order->quantity = $data->quantity;
            $order->image = $data->image;
            $order->product_id = $data->product_id;

            $order->payment_status = 'Paid';
            $order->delivery_status = 'processing';

            $order->save();

            $cart_id = $data->id;
            $cart = Cart::find($cart_id);
            $cart->delete();
        }

        Session::flash('success', 'Payment successful!');

        return redirect('/');
    }

    public function show_order()
    {
        if (Auth::id()) {
            $user = Auth::user();
            $userId = $user->id;
            $order = Order::where('user_id', '=', $userId)->get();
            return view('home.order', compact('order'));
        } else {
            return redirect('login');
        }
    }
}
