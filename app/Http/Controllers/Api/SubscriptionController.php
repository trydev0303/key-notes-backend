<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SubscriptionController extends Controller
{
  public function purchaseSubscription(Request $request) {
    $data = json_decode($request->getContent(), true);
    $validator = Validator::make($data, [
        'subscription_date'    => 'required',
        'order_id'             => 'required',
        // 'plan_validity' => 'required',
        'user_membership_from' => 'required',
    ]);

    if ($validator->fails()) {
        return errorHandle($validator);       
    }

    $user = User::where('id', Auth::id())->update([
        'subscription_date'    => $request->subscription_date,
        'order_id'             => $request->order_id,
        'plan_validity'        => $request->plan_validity,
        'user_membership_from' => $request->user_membership_from,
    ]);
    return successRes(200,'Subscription purchased successfully');
} 
}
