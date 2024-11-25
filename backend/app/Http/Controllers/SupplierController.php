<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SupplierController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Request $request)
    {
        $suppliers = Supplier::getAll();

        if ($request->get('search')) {
            $suppliers = collect($suppliers)->filter(function ($supplier) use ($request) {
                return Str::contains(Str::lower($supplier['name']), Str::lower($request->get('search')));
            })->values()->all();
        }

        return response()->json($suppliers, 200);
    }
}
