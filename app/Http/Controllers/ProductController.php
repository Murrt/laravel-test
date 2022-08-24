<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Auth\Events\Validated;
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

        // valideer request
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:255',
        ]);
 
        // Wanneer de validatie faalt return een message
        if ($validator->fails()) {
            return redirect('/products')->with('statusBad', 'Name was already used!');
        }
        

        // haal de gevalideerde data op
        $validated = $validator->validated();

        DB::insert("INSERT INTO products (name) VALUES ('".$validated['name']."')");

        return redirect('/products')->with('status', 'Product saved');
    }

    public function delete(Request $request)
    {

         // valideer request
         $validator = Validator::make($request->all(), [
            'id' => 'integer',
        ]);
 
        // Wanneer de validatie faalt return een message
        if ($validator->fails()) {
            return redirect('/products')->with('statusBad', 'Er ging iets mis!');
        }
        

        // haal de gevalideerde data op
        $validated = $validator->validated();


        DB::delete("DELETE FROM products WHERE id = ".$validated['id']);

        return redirect('/products')->with('status', 'Product was deleted');
    }
}
