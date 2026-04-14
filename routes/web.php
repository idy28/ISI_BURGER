<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\CatalogueController;
use App\Http\Controllers\Client\OrderController as ClientCommandeController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BurgerController;
use App\Http\Controllers\Admin\OrderController as AdminCommandeController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PdfController;

// ══════════════════════════════════════════════════════════
//  ESPACE CLIENT — Public, aucune authentification requise
// ══════════════════════════════════════════════════════════

// Route::get('/', function () {
//     return view('welcome');
// })->name('home');
Route::get('/', [CatalogueController::class, 'index'])->name('catalogue');
Route::post('/commande', [ClientCommandeController::class, 'store'])->name('orders.store');
Route::get('/commande/confirmation/{order}', [ClientCommandeController::class, 'confirmation'])->name('orders.confirmation');
Route::get('/burgers/{id}', [CatalogueController::class, 'show'])->name('burger.show');

// ══════════════════════════════════════════════════════════
//  ESPACE ADMIN — Protégé par middleware
// ══════════════════════════════════════════════════════════

Route::get('/admin/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.post');
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->name('admin.')->middleware('admin.auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Gestion des Burgers
    Route::get('/burgers', [BurgerController::class, 'index'])->name('burgers.index');
    Route::get('/burgers/create', [BurgerController::class, 'create'])->name('burgers.create');
    Route::post('/burgers', [BurgerController::class, 'store'])->name('burgers.store');
    Route::get('/burgers/{burger}/edit', [BurgerController::class, 'edit'])->name('burgers.edit');
    Route::put('/burgers/{burger}', [BurgerController::class, 'update'])->name('burgers.update');
    Route::delete('/burgers/{burger}', [BurgerController::class, 'destroy'])->name('burgers.destroy');
    Route::patch('/burgers/{burger}/toggle', [BurgerController::class, 'toggleAvailable'])->name('burgers.toggle');

    // Gestion des Commandes (noms de routes francisés pour les vues)
    Route::get('/commandes', [AdminCommandeController::class, 'index'])->name('orders.index');
    Route::get('/commandes/{order}', [AdminCommandeController::class, 'show'])->name('orders.show');
    Route::patch('/commandes/{order}/statut', [AdminCommandeController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/commandes/{order}', [AdminCommandeController::class, 'destroy'])->name('orders.destroy');

    // Paiements (aligné avec les vues)
    Route::post('/paiements', [PaymentController::class, 'store'])->name('payments.store');
    Route::get('/paiements', [PaymentController::class, 'index'])->name('payments.index');

    // Facture PDF
    Route::get('/facture/{order}', [PdfController::class, 'generate'])->name('pdf.generate');

    // Stats API pour Chart.js
    Route::get('/stats/commandes-par-mois', [DashboardController::class, 'ordersByMonth'])->name('stats.orders');
    Route::get('/stats/produits-par-mois', [DashboardController::class, 'productsByMonth'])->name('stats.products');
});
