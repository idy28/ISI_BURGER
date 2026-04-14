<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request)
    {
        $query = Burger::where('available', true);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $burgers = $query->orderBy('name')->paginate(15)->withQueryString();
        $maxPrice = Burger::where('available', true)->max('price');

        return view('client.catalogue', compact('burgers', 'maxPrice'));
    }

    public function show(int $id)
    {
        $burger = Burger::where('available', true)->findOrFail($id);

        $related = Burger::where('available', true)
            ->where('id', '!=', $id)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('client.burger-show', compact('burger', 'related'));
    }
}