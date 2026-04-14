<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('order')->latest();

        if ($request->q) {
            $query->whereHas('order', fn($q) => $q->where('customer_name', 'like', '%' . $request->q . '%'));
        }
        if ($request->date_debut)
            $query->whereDate('created_at', '>=', $request->date_debut);
        if ($request->date_fin)
            $query->whereDate('created_at', '<=', $request->date_fin);

        $payments = $query->paginate(20)->withQueryString();

        // $payments = Payment::with('order')
        //     ->orderByDesc('payment_date')
        //     ->paginate(20);

        $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount');

        $dailyRevenue = Payment::whereDate('payment_date', today())
            ->sum('amount');

        $totalPayments = Payment::count();
        $averageBasket = (float) Payment::avg('amount');

        return view('admin.payments.index', compact(
            'payments',
            'monthlyRevenue',
            'dailyRevenue',
            'totalPayments',
            'averageBasket'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            // 'amount' => 'required|numeric|min:0',
            'amount_paid' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string|max:255',
        ], [
            'amount.required' => 'The amount is required.',
            'amount.min' => 'The amount must be positive.',
        ]);

        $order = Order::findOrFail($request->order_id);
        if ($order->total_amount > $request->amount_paid) {
            return back()->withErrors(['error' => 'Le montant du paiement doit être au moins égal au montant total de la commande. ']);
        }

        if ($order->payment) {
            return back()->withErrors(['error' => 'Cette commande a déjà été payée.']);
        }

        if ($order->status !== Order::STATUS_READY) {
            return back()->withErrors(['error' => 'La commande doit être prête avant d’enregistrer un paiement.']);
        }

        Payment::create([
            'order_id' => $order->id,
            'amount_paid' => $request->amount_paid,
            'amount' => $order->total_amount,
            'payment_method' => 'cash',
            'payment_date' => now(),
            'notes' => $request->notes,
        ]);

        // Mark order as paid
        $order->update(['status' => Order::slugToLabel('Payee')]);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', "Payment of {$request->amount} recorded. Order marked as paid!");
    }
}