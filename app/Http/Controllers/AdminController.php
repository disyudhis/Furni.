<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    public function view_category()
    {
        if (Auth::id()) {

            $data = Category::all();
            return view('admin.category', compact('data'));
        } else {
            return redirect('login');
        }
    }

    public function add_category(Request $request)
    {
        $data = new Category;

        $data->category_name = $request->category;

        $data->save();

        return redirect()->back()->with('message', 'Category added successfully');
    }

    public function delete_category($id)
    {
        $data = Category::find($id);

        $data->delete();
        return redirect()->back()->with('message', 'Category deleted successfully!');
    }

    public function view_product()
    {
        $category = Category::all();
        $product = Product::orderBy('updated_at', 'desc')->get();
        return view('admin.product', compact('category', 'product'));
    }

    public function add_product(Request $request)
    {
        $product = new Product;
        $product->title = $request->title;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->discount_price = $request->discount_price;
        $product->category = $request->category;
        $image = $request->image;
        $imagename = time() . '.' . $image->getClientOriginalExtension();
        $request->image->move('product', $imagename);
        $product->image = $imagename;
        $product->save();

        Alert::success("Product added successfully", 'We have added your product');
        return redirect()->back();
    }

    public function delete_product($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect()->back()->with('message', 'Product deleted successfully!');
    }


    public function update_product($id)
    {
        $product = Product::find($id);
        $category = Category::all();

        return view('admin.update_product', compact('product', 'category'));
    }

    public function update_product_confirm(Request $request, $id)
    {
        if (Auth::id()) {
            $product = Product::find($id);
            $product->title = $request->title;
            $product->quantity = $request->quantity;
            $product->category = $request->category;
            $product->price = $request->price;
            $product->discount_price = $request->discount_price;
            $image = $request->image;
            if ($image) {

                $imagename = time() . '.' . $image->getClientOriginalExtension();
                $request->image->move('product', $imagename);
                $product->image = $imagename;
            }
            $product->save();
            Alert::success("Product updated successfully", "We have updated your product");
            return redirect('view_product');
        } else {
            return redirect('login');
        }
    }

    public function order()
    {
        $order = Order::orderBy('updated_at', 'desc')->get();
        return view('admin.order', compact('order'));
    }

    public function searchdata(Request $request)
    {
        $searchText = $request->search;
        $order = Order::whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($searchText) . '%'])
            ->orWhereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($searchText) . '%'])
            ->orWhereRaw('LOWER(product_title) LIKE ?', ['%' . strtolower($searchText) . '%'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('admin.order', compact('order'));
    }

    public function delivered($id)
    {
        $order = Order::find($id);
        $order->delivery_status = 'Delivered';
        $order->payment_status = 'Paid';
        $order->save();

        return redirect()->back();
    }
}
