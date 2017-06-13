<?php

namespace App\Http\Controllers;

use Stripe\Charge;
use Stripe\Customer;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function store()
    {
        $customer = Customer::create([
            'email' => request('stripeEmail'),
            'source' => request('stripeToken')
        ]);
        try {
            Charge::create([
                'customer' => $customer->id,
                'amount' => 2000,
                'currency' => 'sek'
            ]);
        } catch (\Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
        return ['status' => 'Thank you for your purchase.'];
    }
}
