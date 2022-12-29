<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return ProductModel::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'slug' => 'required',
            'price' => 'required',
        ]);
        $prod = ProductModel::create($request->all());
        
        return Response([
            'item' => $prod,
            'msg' => 'Item Created!',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return ProductModel::find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $prod = ProductModel::find($id);
        $prod->update($request->all());
        
        return Response([
            'item' => $prod,
            'msg' => 'Item Updated',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $prod = ProductModel::destroy($id);
        return Response([
            'item' => $prod,
            'msg' => 'Item Deleted!',
        ], 201);
    }

    public function search($name) 
    {
        $prod = ProductModel::where('name', 'like', '%'.$name.'%')->get();
        return Response([
            'item' => $prod,
            'msg' => 'Search Result',
            'count' => $prod->count(),
        ]);
    }
}
