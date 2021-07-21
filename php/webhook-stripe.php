<?php

// init
require('init.php');

\Stripe\Stripe::setApiKey(STRIPE_API_SK);

$payload = @file_get_contents('php://input');
$data = json_decode($payload);

if (gettype($data) !== 'object') die(json_encode(["status"=>false,"response"=>"Data is not an object"]));

$event_type = $data->type;
$object = $data->data->object;

switch($event_type){
    // PUBLISH SITE
    case 'checkout.session.completed': 
        $site = publishSite($object);
        printResponse($site);
    break;

    // GRANT ACCESS
    case 'invoice.payment_succeeded':
        $site_access = grantSiteAccess($object);
        printResponse($site_access);
    break;

    // UNPUBLISH SITE, REMOVE ACCESS
    case 'customer.subscription.deleted':
        $site = unpublishSite($object);
        $site_access = removeSiteAccess($object);
        printResponse($site_access);
    break;

    // REMOVE ACCESS
    case 'invoice.payment_failed':
        $site_access = removeSiteAccess($object);
        printResponse($site_access);
    break;

    default:
        die(json_encode(["status"=>false, "response"=>"Not listening to event type: - ".$data->event_type]));
    break;

}


?>