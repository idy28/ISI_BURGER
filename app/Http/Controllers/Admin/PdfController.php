<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generate(Order $order)
    {
        if (!$order->isReady()) {
            return back()->withErrors([
                'pdf' => 'La facture est disponible uniquement lorsque la commande est prête.'
            ]);
        }

        $order->load(['items', 'payment']);

        $pdf = Pdf::loadView('admin.facture', compact('order'))
            ->setPaper('a4', 'portrait');

        $filename = "facture-commande-{$order->id}.pdf";

        return $pdf->download($filename);
    }
}