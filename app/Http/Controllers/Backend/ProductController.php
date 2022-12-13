<?php

namespace App\Http\Controllers\Backend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ProductGallery;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['categories:id,name'])->select('id', 'title', 'slug', 'image', 'status', 'created_at')->orderBy('id', 'desc')->paginate(20);
        return view('backend.product.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('backend.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $galleries = $request->file('gallery');
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
            'sku_code' => 'required',
            'short_description' => 'required',
            'price' => 'required|integer',
            'sale_price' => 'nullable|integer',
            'description' => 'nullable',
            'add_info' => 'nullable',
            'image' => 'required|mimes:png,jpg,jpeg,webp|max:512',
            'currency' => 'required',
            'gallery.*' => 'nullable|mimes:png,jpg,jpeg,webp|max:512',
        ]);


    

        if($request->file('image')){

            $preview_img = Str::uuid().'.'.$request->image->extension();
            Image::make($request->image)->crop(800,609)->save(public_path('storage/product/'.$preview_img));
            
            $product = Product::create([
                "title" => $request->title,
                "user_id" => auth()->user()->id,
                "sku_code" => $request->sku_code,
                "short_description" => $request->short_description,
                "price" => $request->price,
                "sale_price" => $request->sale_price,
                "description" => $request->description,
                "add_info" => $request->add_info,
                "image" => $preview_img,
                "currency" => $request->currency,
            ]);

            $product->categories()->attach($request->category_id);

            if($galleries){
                foreach($galleries as $img){
                    $gallery_img = Str::uuid().'.'.$img->extension();
                    Image::make($request->image)->crop(800,609)->save(public_path('storage/product/'.$gallery_img));
                    ProductGallery::create([
                        'product_id' => $product->id,
                        'image' => $gallery_img ,
                    ]);
                }
            }

            return back()->with('success', "Product Insert Successfull!");
        
        }else{
            return back()->with('error', "Image Not uploaded!");
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}


