<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductSearchRequest;
use App\ORM\Product;

class ProductController extends Controller
{

    /**
     * @SWG\Get(
     *     path="/api/products",
     *     summary="商品一覧取得",
     *     description="商品一覧取得する",
     * 　　consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Product"},
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="products",
     *                 type="array",
     *                 @SWG\Items(ref="#/definitions/product")
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             )
     *         )
     *     )
     * )
     */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return response()->json([
            compact('products')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * @SWG\Get(
     *     path="/api/products/{id}",
     *     summary="商品取得",
     *     description="指定したIDの商品を取得する",
     * 　　consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Product"},
     *   　@SWG\Parameter(
     *         name="id",
     *         description="商品ID",
     *         in="path",
     *         type="integer",
     *         required=true
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="product",
     *                 type="object",
     *                 ref="#/definitions/product"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     )
     * )
     */

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json(compact('product'), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

     /**
     * @SWG\POST(
     *     path="/api/products/search",
     *     summary="商品一覧検索",
     *     description="商品一覧検索する",
     * 　　consumes={"application/json"},
     *     produces={"application/json"},
     *     tags={"Product"},
     * 　　@SWG\Parameter(
     *         name="Request",
     *         description="商品検索情報",
     *         in="body",
     *         required=true,
     *         @SWG\Property(
     *              ref="#/definitions/ProductSearchRequest"
     * 　　　　 )
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Success",
     *         @SWG\Schema(
     *             @SWG\Property(
     *                 property="products",
     *                 type="array",
     *                 @SWG\Items(ref="#/definitions/product")
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=401,
     *         description="Unauthorized",
     *         @SWG\Schema(
     *             @SWG\Property(property="message", type="string", description="Unauthenticated.")
     *         )
     *     ),
     *     @SWG\Response(
     *         response=422,
     *         description="Unprocessable Entity",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="messages",
     *                 type="array",
     *                 description="エラーメッセージ一覧",
     *                 @SWG\Items(type="string")
     *             )
     *         )
     *     )
     * )
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  ProductSearchRequest  ProductSearchRequest
     * @return \Illuminate\Http\Response
     */
    public function search(ProductSearchRequest $request)
    {
        $products = Product::where('id', $request->id)->get();
        return response()->json([
            compact('products')
        ]);
    }
}
