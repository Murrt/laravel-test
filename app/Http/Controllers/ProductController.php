<?php

namespace App\Http\Controllers;

use App\Product;
use App\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Services\ProductService;


class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function new(Request $request, ProductService $ProductServiceProvider){
        $ProductServiceProvider->new($request);
        
    }

    public function delete(Request $request, ProductService $ProductServiceProvider){
        $ProductServiceProvider->delete($request);
    }

}
