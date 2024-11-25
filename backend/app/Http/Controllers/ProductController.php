<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request, string $id)
    {
        $products = Product::getAll();

        $products = collect($products['data'])->where('supplierId', $id)->values()->all();

        if ($request->get('search')) {
            $products = collect($products)->map(function ($product) use ($request) {
                $searchTerm = Str::lower($request->get('search'));

                $filteredChildProducts = collect($product['childProducts'])->filter(function ($childProduct) use ($searchTerm) {
                    return Str::contains(Str::lower($childProduct['name']), $searchTerm);
                })->values()->all();

                $product['childProducts'] = $filteredChildProducts;

                return $product;
            })->filter(function ($product) use ($request) {
                $searchTerm = Str::lower($request->get('search'));

                $productMatches = Str::contains(Str::lower($product['name']), $searchTerm);

                $childProductMatches = !empty($product['childProducts']);

                return $productMatches || $childProductMatches;
            })->values()->all();
        }

        return response()->json($products, 200);
    }
}
