<?php

require 'vendor/autoload.php';
// \Stripe\Stripe::setApiKey('c2tfdGVzdF9RQndTR2tWS3JZRWNqOWpqcEN6Sk1Na1EwMGJsOTk2WW1HOg==');

// TEST FOR MULTIPLE ITEMS
function create_session($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);

        $checkout_session = $stripe->checkout->sessions->create([
            'success_url' => 'http://localhost/CamelDev/DIY/views/test-checkout.html',
            'cancel_url' => 'http://localhost/CamelDev/DIY/views/test-checkout.html',
            'payment_method_types' => ['card'],
            'mode' => $data->mode,
            'line_items' => json_decode(json_encode($data->line_items))
        ]);
        return ["status"=>true,"response"=>$checkout_session,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}

// CREATE CHECKOUT SESSION
function create_checkout_session($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);

        $checkout_session = $stripe->checkout->sessions->create([
            'customer' => $data->customer,
            'success_url' => $data->success_url.'?session_id={CHECKOUT_SESSION_ID}&customer='.$data->customer,
            'cancel_url' => $data->cancel_url,
            'payment_method_types' => ['card'],
            'mode' => 'subscription',
            'line_items' => [
                [
                    'price' => $data->price,
                    // For metered billing, do not pass quantity
                    'quantity' => 1,
                ]
            ],
            'allow_promotion_codes' => true
            // 'metadata' => ['name'=>$data->name, 'email'=>$data->account_name, 'site_name'=>$data->site_name, 'account_name'=>$data->account_name]
            // 'subscription_data' => ['metadata' => ['name'=>$data->name, 'email'=>$data->account_name, 'site_name'=>$data->site_name, 'account_name'=>$data->account_name]]
    ]);
        return ["status"=>true,"response"=>$checkout_session,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}

// RETRIEVE CHECKOUT SESSION OBJECT
function retrieve_session($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);

        $session = $stripe->checkout->sessions->retrieve(
            $data->session_id
        );
        return ["status"=>true,"response"=>$session,"request"=>__FUNCTION__];
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
            'email' => $data->account_name,
            'name' => $data->name,
            'id' => $data->site_name
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


// RETRIEVE A SUBSCRIPTION
function retrieve_subscription($subscription_id){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);
        $subscription = $stripe->subscriptions->retrieve(
            $subscription_id
        );
        return ["status"=>true,"response"=>$subscription,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}

// UPDATE A SUBSCRIPTION
function update_subscription($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);
        $subscription = $stripe->subscriptions->update(
            $data->subscription,
            ['metadata' => ['name'=>$data->metadata->name, 'email'=>$data->metadata->account_name, 'site_name'=>$data->metadata->site_name, 'account_name'=>$data->metadata->account_name]]
        );
        return ["status"=>true,"response"=>$subscription,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}

// CANCEL A SUBSCRIPTION
function cancel_subscription($subscription_id){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);
        $subscription = $stripe->subscriptions->cancel(
            $subscription_id
        );
        return ["status"=>true,"response"=>$subscription,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}


// CANCEL A SUBSCRIPTION
function billing_portal($data){
    try{
        $stripe = new \Stripe\StripeClient(STRIPE_API_SK);
        $session = $stripe->billingPortal->sessions->create([
            'customer' => $data->customer,
            'return_url' => $data->return_url
        ]);
        return ["status"=>true,"response"=>$session,"request"=>__FUNCTION__];
    } catch(Exception $e){
        return ["status"=>false,"response"=>$e->getMessage(),"request"=>__FUNCTION__];
    }
}

?>