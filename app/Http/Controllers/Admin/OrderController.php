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

        $commandes = $query->paginate(10);

        // Counts keyed by UI slugs
        $counts = [
            'En attente' => Order::where('status', Order::STATUS_PENDING)->count(),
            'En preparation' => Order::where('status', Order::STATUS_PREPARING)->count(),
            'Prete' => Order::where('status', Order::STATUS_READY)->count(),
            'Payee' => Order::where('status', Order::STATUS_PAID)->count(),
        ];

        $total = Order::count();

        return view('admin.orders.index', compact('commandes', 'counts', 'total'));
    }

    public function show(Order $order)
    {
        $order->load(['items.burger', 'payment']);
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', [
                Order::STATUS_PENDING,
                Order::STATUS_PREPARING,
                Order::STATUS_READY,
                Order::STATUS_PAID,
            ]),
        ]);

        $oldStatus = $order->status; // stored label (e.g. 'En attente')
        $newStatus = $request->status; // incoming label

        // Prevent going backward
        $orderMap = [
            Order::STATUS_PENDING => 1,
            Order::STATUS_PREPARING => 2,
            Order::STATUS_READY => 3,
            Order::STATUS_PAID => 4,
        ];

        if (($orderMap[$newStatus] ?? 0) < ($orderMap[$oldStatus] ?? 0)) {
            return back()->withErrors(['statut' => 'Impossible de revenir à un statut précédent.']);
        }

        // If marking as "Payee" without a payment → reject
        if ($newStatus === Order::STATUS_PAID && !$order->payment) {
            return back()->withErrors(['statut' => 'Enregistrer le paiement avant de marquer comme payée.']);
        }

        $order->update(['status' => $newStatus]);
        $justSetToPrete = false;
        // If marking as "Prete" → provide invoice link
        if ($newStatus === Order::STATUS_READY) {
            $justSetToPrete = true;
            return redirect()->route('admin.orders.show', $order)
                ->with([
                    'success' => "Commande #{$order->id} marquée Prête ! La facture PDF est disponible.",
                    'justSetToPrete' => true,   // <-- ici on indique que le statut vient juste d'être mis à Prete
                ]);
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

        return redirect()->route('admin.orders.index')
            ->with('success', "Commande #{$order->id} annulée et stock restauré.");
    }
}