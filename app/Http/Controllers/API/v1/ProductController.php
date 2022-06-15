<?php

namespace App\Http\Controllers\API\v1;

use App\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product as ProductResource ;
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
        $products = new Product();
        $products = $products->orderBy('level','asc')->get();

        return ProductResource::collection($products);
    }
}
