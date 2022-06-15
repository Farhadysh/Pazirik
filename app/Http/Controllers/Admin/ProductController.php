<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = new Product();
        $products = $product
            ->orderBy('level', 'asc')
            ->paginate(10);

        $products_count = $product->count();

        return view(\request()->route()->getName())->with([
            'products' => $products,
            'products_count' => $products_count
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view(\request()->route()->getName());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->merge([
            'price' => str_replace(',', '', $request->input('price'))
        ]);

        $request->validate([
        'level' => 'required',
        'name' => 'required|string|max:255',
        'price' => 'required|integer',
        'unit' => 'required'
    ]);
        $product = new Product();
        $product->level = $request->input('level');
        $product->name = $request->input('name');
        $product->price = str_replace(',','',$request->input('price'));
        $product->unit = $request->input('unit');
        $product->save();

        alert()->success('با موفقیت ثبت شد.');

        return redirect(route('admin.products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view(\request()->route()->getName())->with([
            'product' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->merge([
            'price' => str_replace(',', '', $request->input('price'))
        ]);

        $request->validate([
            'level' => 'required',
            'name' => 'required|string|max:255',
            'price' => 'required|integer',
            'unit' => 'required'
        ]);


        $product->level = $request->input('level');
        $product->name = $request->input('name');
        $product->price = str_replace(',','',$request->input('price'));
        $product->unit = $request->input('unit');
        $product->save();

        alert()->success('با موفقیت ویرایش شد.');

        return redirect(route('admin.products.index'));
    }

    public function product_active($id, $active)
    {
        $product = new Product();
        $product = $product->where('id', $id);

        $product->update([
            'active' => $active
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
