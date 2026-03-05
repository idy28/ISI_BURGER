<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function generate(Order $commande)
    {
        if (!$commande->isReady()) {
            return back()->withErrors([
                'pdf' => 'La facture est disponible uniquement lorsque la commande est prête.'
            ]);
        }

        $commande->load(['items', 'payment']);

        $pdf = Pdf::loadView('admin.facture', compact('commande'))
            ->setPaper('a4', 'portrait');

        $filename = "facture-commande-{$commande->id}.pdf";

        return $pdf->download($filename);
    }
}