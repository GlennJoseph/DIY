<?php

require 'vendor/autoload.php';
// \Stripe\Stripe::setApiKey('c2tfdGVzdF9RQndTR2tWS3JZRWNqOWpqcEN6Sk1Na1EwMGJsOTk2WW1HOg==');

// CREATE CHECKOUT SESSION
function create_checkout_session($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);

        $checkout_session = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost/CamelDev/DIY/views/checkout.html',
            'cancel_url' => 'http://localhost/CamelDev/DIY/views/checkout.html',
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [
            [
                'price' => 'starter',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ],
            [
                'price' => 'price_1IWLCBHdOsfAiyOEmFlklSqw',
                // For metered billing, do not pass quantity
                'quantity' => 1,
            ]
        ],
    ]);
        return ["status"=>true,"response"=>$checkout_session,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}

// CREATE CUSTOMER
function create_customer($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);
        
        $customer = $stripe->customers->create([
            'description' => 'DIY Customer',
            'source' => $data->source,
            'email' => $data->email,
            'name' => $data->name,
            'metadata' => ['name'=>$data->name, 'email'=>$data->email]
        ]);

        return ["status"=>true,"response"=>$customer,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}

// CREATE A CHARGE
function create_charge($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);

        $charge = $stripe->charges->create([
            'amount' => $data->amount,
            'currency' => $data->currency,
            'source' => $data->source,
            'description' => $data->description
        ]);

        return ["status"=>true,"response"=>$charge,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}


// CREATE A SUBSCRIPTION
function create_subscription($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);
        $subscription = $stripe->subscriptions->create([
            'customer' => $data->customer,
            'items' => [
                ['price' => $data->price],
            ],
        ]);

        return ["status"=>true,"response"=>$subscription,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}


?>