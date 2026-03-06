<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\CustomerTransaction;
use Illuminate\Http\Request;

class CustomerTransactionController extends Controller
{
    public function store(Request $request, Customer $customer)
    {
        // Müşterinin mevcut borcundan (bakiyesinden) fazla tahsilat yapılamaz.
        // Eğer bakiye sıfır veya altındaysa (borcu yoksa) işlem engellenir.
        $maxAmount = $customer->balance > 0 ? $customer->balance : 0;

        $request->validate([
            'amount' => ['required', 'numeric', 'min:0.01', "max:{$maxAmount}"],
            'payment_method' => ['required', 'in:nakit,kart,borc'],
            'description' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ], [
            'amount.max' => 'Tahsilat tutarı, müşterinin güncel borcundan (' . number_format($maxAmount, 2, ',', '.') . ' ₺) fazla olamaz.',
            'amount.min' => 'Tahsilat tutarı sıfırdan büyük olmalıdır.'
        ]);

        $customer->transactions()->create([
            'type' => 'payment',
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'description' => $request->description ?? (($request->payment_method == 'nakit' ? 'Nakit' : 'Kart') . ' Ödemesi'),
            'date' => $request->date,
        ]);

        $customer->recalculateBalance();

        return back()->with('success', 'Ödeme başarıyla kaydedildi.');
    }

    public function destroy(CustomerTransaction $transaction)
    {
        $customer = $transaction->customer;
        $transaction->delete();

        if ($customer) {
            $customer->recalculateBalance();
        }

        return back()->with('success', 'İşlem başarıyla silindi.');
    }
}
