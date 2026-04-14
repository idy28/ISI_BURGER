<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    public function index(Request $request)
    {
        $query = Burger::query();

        // if ($request->filled('search')) {
        //     $query->where('name', 'like', '%' . $request->search . '%');
        // }

        // Recherche par nom
        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        // Filtre par statut
        if ($request->filled('statut')) {
            if ($request->statut === 'disponible') {
                $query->where('available', true);
            } elseif ($request->statut === 'indisponible') {
                $query->where('available', false);
            }
        }

        $burgers = $query->orderBy('name')->paginate(15);

        return view('admin.burgers.index', compact('burgers'));
    }

    public function create()
    {
        return view('admin.burgers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'stock' => 'required|integer|min:0',
            'available' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'name.required' => 'The burger name is required.',
            'price.required' => 'The price is required.',
            'stock.required' => 'The stock quantity is required.',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('burgers', 'public');
        }

        $data['available'] = $request->boolean('available', true);

        Burger::create($data);

        return redirect()->route('admin.burgers.index')
            ->with('success', 'Burger added successfully!');
    }

    public function edit(Burger $burger)
    {
        return view('admin.burgers.edit', compact('burger'));
    }

    public function update(Request $request, Burger $burger)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'stock' => 'required|integer|min:0',
            'available' => 'boolean',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($burger->image) {
                Storage::disk('public')->delete($burger->image);
            }
            $data['image'] = $request->file('image')->store('burgers', 'public');
        }

        $data['available'] = $request->boolean('available', true);

        // If stock becomes > 0, set available to true
        if ($data['stock'] > 0 && !$burger->available) {
            $data['available'] = true;
        }

        $burger->update($data);

        return redirect()->route('admin.burgers.index')
            ->with('success', 'Le burger a été mis à jour avec succès.');
    }

    public function destroy(Burger $burger)
    {
        if ($burger->image) {
            Storage::disk('public')->delete($burger->image);
        }

        $burger->delete();

        return redirect()->route('admin.burgers.index')
            ->with('success', 'Le burger a été supprimé avec succès.');
    }

    public function toggleAvailable(Burger $burger)
    {
        $burger->update(['available' => !$burger->available]);

        $status = $burger->available ? 'activé' : 'désactivé';
        return back()->with('success', "Le burger a été {$status}.");
    }
}