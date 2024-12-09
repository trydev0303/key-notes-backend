<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Carbon\Carbon;

class SubscriptionController extends Controller
{
  public function purchaseSubscription(Request $request) {

    $data = json_decode($request->getContent(), true);

    $validator = Validator::make($data, [
        'amount'               => 'required',
        'order_id'             => 'required',
        'token'                => 'required',
    ]);

    if ($validator->fails()) {
        return errorHandle($validator);
    }

    Stripe::setApiKey(env('STRIPE_SECRET'));

    try {

        $token = $request->input('token'); // Token from Google Pay

        // Create a Payment Intent
        $paymentIntent = PaymentIntent::create([
            'amount' => $request->amount,
            'currency' => 'usd',
            'payment_method_data' => [
                'type' => 'card',
                'card' => [
                    'token' => $token,
                ],
            ],
            'confirmation_method' => 'automatic',
            'confirm' => true,
        ]);


        $currentDateTime = Carbon::now();

        $plan_validity;

        if($request->order_id == 0){
            $plan_validity = $currentDateTime->copy()->addMonth();
        }else if($request->order_id == 1){
            $plan_validity = $currentDateTime->copy()->addYear();
        }else {
            $plan_validity = $currentDateTime->copy()->addYears(12);
        }

        $user = User::where('id', Auth::id())->update([
            'subscription_date'    => $currentDateTime,
            'order_id'             => $request->order_id,
            'plan_validity'        => $plan_validity,
            'user_membership_from' => $currentDateTime
        ]);

        return response()->json([
            'success' => true,
            'paymentIntent' => $paymentIntent,
        ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

}
