<?php

namespace App\Http\Controllers;

use App\Enums\V1\PaymentStatus;
use App\Models\Customer;
use App\Models\Deposit;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

use Illuminate\Http\Request;

class PayPalController extends Controller
{
    public function handlePayment(Request $request)
    {
        $deposit = Deposit::where([
            ['temporary_token', $request->temp_token],
            ['payment_status', PaymentStatus::PENDING->value]
        ])->first();

        if (!$deposit) {
            return to_route('paypal.payment.message')->with('message', 'Invaild URL !');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.payment.success'),
                "cancel_url" => route('paypal.payment.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $deposit->amount
                    ],

                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    $deposit->update(['paypal_order_id' => $response['id']]);
                    return redirect()->away($links['href']);
                }
            }
        } else {
            return to_route('paypal.payment.cancel');
        }
    }

    public function successPayment(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $deposit = Deposit::where('paypal_order_id', $request['token'])->first();
            $customerId = $deposit->customer_id;
            $customerDepositAmount = $deposit->amount;
            $deposit->update(['payment_status' => PaymentStatus::COMPLETED->value]);
            $customer = Customer::findOrFail($customerId);
            $customer->update(['balance' => $customerDepositAmount + $customer->balance]);

            return to_route('paypal.payment.message')->with('message', 'Transaction complete.');
        } else {
            return to_route('paypal.payment.message')->with('message',  $response['message'] ?? 'Something went wrong.');
        }
    }

    public function cancelledPayment(Request $request)
    {
        $deposit = Deposit::where('paypal_order_id', $request['token'])->first();

        if (!$deposit) {
            return to_route('paypal.payment.message')->with('message', 'Invaild URL !');
        }

        $deposit->update([
            'paypal_order_id' => null,
            'temporary_token' => null
        ]);

        return to_route('paypal.payment.message')->with('message', 'You have canceled the transaction.');
    }

    public function messagePayment()
    {
        return view('payment_paypal');
    }
}
