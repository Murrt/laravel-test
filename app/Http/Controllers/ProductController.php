<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function new(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'unique:products',
        ]);
 
        if ($validator->fails()) {
            return redirect('/products')->with('statusBad', 'Name was already used!');
        }
        
        
        DB::insert("INSERT INTO products (name) VALUES ('".$request->name."')");

        return redirect('/products')->with('status', 'Product saved');
    }

    public function delete(Request $request)
    {
        DB::delete("DELETE FROM products WHERE id = ".$request->id);

        return redirect('/products')->with('status', 'Product was deleted');
    }
}
