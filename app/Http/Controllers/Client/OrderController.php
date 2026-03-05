<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Burger;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_phone' => 'required|string|max:20',
            'items' => 'required|array|min:1',
            'items.*.name' => 'required|string',
            'items.*.price' => 'required|numeric',
            'items.*.quantity' => 'required|integer|min:1|max:20',
        ], [
            'customer_name.required' => 'Your name is required.',
            'customer_phone.required' => 'Your phone number is required.',
            'items.required' => 'Your cart is empty.',
            'items.min' => 'Add at least one burger to your order.',
        ]);

        // Check stock and calculate total within a transaction
        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $validItems = [];

            foreach ($request->items as $item) {
                // The client sends items with keys: name, price, quantity
                $burger = Burger::lockForUpdate()->where('name', $item['name'])->first();

                if (!$burger) {
                    DB::rollBack();
                    return back()->withErrors([
                        'stock' => "Product \"{$item['name']}\" not found."
                    ])->withInput();
                }

                if ($burger->isOutOfStock()) {
                    DB::rollBack();
                    return back()->withErrors([
                        'stock' => "Sorry, \"{$burger->name}\" is no longer available."
                    ])->withInput();
                }

                if ($burger->stock < $item['quantity']) {
                    DB::rollBack();
                    return back()->withErrors([
                        'stock' => "Insufficient stock for \"{$burger->name}\". Available: {$burger->stock}."
                    ])->withInput();
                }

                $subtotal = $burger->price * $item['quantity'];
                $totalAmount += $subtotal;

                $validItems[] = [
                    'burger' => $burger,
                    'quantity' => $item['quantity'],
                    'price' => $burger->price,
                ];
            }

            // Create the order
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'status' => Order::STATUS_PENDING,
                'total_amount' => $totalAmount,
            ]);

            // Create items and decrease stock
            foreach ($validItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'burger_id' => $item['burger']->id,
                    'burger_name' => $item['burger']->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['price'],
                ]);

                $item['burger']->decreaseStock($item['quantity']);
            }

            DB::commit();

            // Redirect to confirmation page
            return redirect()->route('order.confirmation', ['order' => $order]);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'An error occurred. Please try again.'
            ])->withInput();
        }
    }

    public function confirmation(Order $order)
    {
        $order->load('items');
        return view('client.confirmation', compact('order'));
    }
}