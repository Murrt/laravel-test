<?php

namespace App\Services;

use Illuminate\Support\ServiceProvider;
use App\Product;
use App\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ProductService
{


    public function new(Request $request)
    {

        // valideer request
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products|max:64',
            'description' => 'required|max:255',
            'tags' => 'max:255',
        ]);

        // Wanneer de validatie faalt return een message
        if ($validator->fails()) {
            return redirect('/products')->with('statusBad', 'Name was already used!');
        }


        // haal de gevalideerde data op
        $validated = $validator->validated();

        DB::insert("INSERT INTO products (name, description) VALUES ('" . $validated['name'] . "','" . $validated['description'] . "')");

        $this->TagCheck($validated['tags'], $validated['name']);

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


        DB::delete("DELETE FROM products WHERE id = " . $validated['id']);

        return redirect('/products')->with('status', 'Product was deleted');
    }


    public function tagCheck($tagNames, $productName)
    {
        // haal lijstje komma gescheiden tags op en explode ze in een array.
        $exploded_arr = explode("/\,/", $tagNames);

        foreach ($exploded_arr as $tag) {
            // Als de tag nog niet bestaat even aanmaken.
            $this->tagExists($tag);

            // product en tag id ophalen voor de many to many table

            $product_id = DB::table('products')->select('id')->where('name', '=', $productName)->get();
            $tag_id = DB::table('tags')->select('id')->where('name', '=', $tag)->get();



            // voeg ze toe in de many to many table
            DB::insert("INSERT INTO product_tags (tag_id, product_id) VALUES ('" . $product_id[0]->id . "', '" . $tag_id[0]->id . "')");
        }
    }

    public function tagExists($tagName)
    {

        // Select query om te kijken of tag al bestaat
        if (DB::table('tags')->select('name')->where('name', '=', $tagName)->exists()) {
            return true;
        } else {

            // Tag bestaat nog niet dus even aanmaken.
            $insert = DB::insert("INSERT INTO tags (name) VALUES ('" . $tagName . "')");

            error_log($insert);
            return false;
        }
    }
}
