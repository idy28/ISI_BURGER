<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items', 'payment'])->orderByDesc('created_at');

        // UI uses 'q' as search parameter in the blades
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('customer_name', 'like', '%' . $request->q . '%')
                    ->orWhere('customer_phone', 'like', '%' . $request->q . '%')
                    ->orWhere('id', $request->q);
            });
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // Filter by status slug coming from the UI (ex: en_attente)
        if ($request->filled('statut')) {
            $label = Order::slugToLabel($request->statut);
            $query->where('status', $label);
        }

        $commandes = $query->paginate(15);

        // Counts keyed by UI slugs
        $counts = [
            'en_attente' => Order::where('status', Order::slugToLabel('en_attente'))->count(),
            'en_preparation' => Order::where('status', Order::slugToLabel('en_preparation'))->count(),
            'prete' => Order::where('status', Order::slugToLabel('prete'))->count(),
            'payee' => Order::where('status', Order::slugToLabel('payee'))->count(),
        ];

        $total = Order::count();

        return view('admin.orders.index', compact('commandes', 'counts', 'total'));
    }

    public function show(Order $commande)
    {
        $commande->load(['items.burger', 'payment']);
        return view('admin.orders.show', compact('commande'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'statut' => 'required|in:en_attente,en_preparation,prete,payee',
        ]);

        $oldSlug = $order->statut;
        $newSlug = $request->statut;

        // Prevent going backward
        $orderMap = [
            'en_attente' => 1,
            'en_preparation' => 2,
            'prete' => 3,
            'payee' => 4,
        ];

        if ($orderMap[$newSlug] < $orderMap[$oldSlug]) {
            return back()->withErrors(['statut' => 'Impossible de revenir à un statut précédent.']);
        }

        // If marking as "payee" without a payment → reject
        if ($newSlug === 'payee' && !$order->payment) {
            return back()->withErrors(['statut' => 'Enregistrer le paiement avant de marquer comme payée.']);
        }

        $order->update(['status' => Order::slugToLabel($newSlug)]);

        // If marking as "prete" → provide invoice link
        if ($newSlug === 'prete') {
            return redirect()->route('admin.commandes.show', $order)
                ->with('success', "Commande #{$order->id} marquée Prête ! La facture PDF est disponible.");
        }

        return back()->with('success', "Statut mis à jour: {$order->status}");
    }

    public function destroy(Order $order)
    {
        if ($order->status === Order::STATUS_PAID) {
            return back()->withErrors(['error' => 'Impossible d\'annuler une commande déjà payée.']);
        }

        // Restore stock
        foreach ($order->items as $item) {
            if ($item->burger) {
                $item->burger->increment('stock', $item->quantity);
                if ($item->burger->stock > 0 && !$item->burger->available) {
                    $item->burger->update(['available' => true]);
                }
            }
        }

        $order->delete();

        return redirect()->route('admin.commandes.index')
            ->with('success', "Commande #{$order->id} annulée et stock restauré.");
    }
}