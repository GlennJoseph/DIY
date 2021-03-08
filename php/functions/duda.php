<?php

function getTemplates(){

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE."/sites/multiscreen/templates",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Authorization: Basic " . DUDA_API_KEY,
        "Content-Type: application/json"
      ),
    ));

    // CHECK RESPONSE CODE 
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response; 
    
    // if($responseCode == 200 || $responseCode == 204){
    //     return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
    //     // checkpoint
    //     // uniform
    // }else{
    //     return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
    // }

}


function createAccount($ACCOUNT_NAME){

  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE.'/accounts/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "account_name": $ACCOUNT_NAME
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.DUDA_API_KEY,
        'Content-Type: application/json'
      ),
    ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;

}


function getAccount($ACCOUNT_NAME){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => DUDA_ROUTE.'/accounts/'.$ACCOUNT_NAME,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Basic '.DUDA_API_KEY,
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;
  
}


function createSite($TEMPLATE_ID){

  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE.'/sites/multiscreen/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "template_id": $TEMPLATE_ID
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.DUDA_API_KEY,
        'Content-Type: application/json',
      ),
  ));
  
  $response = curl_exec($curl);
  
  curl_close($curl);
  echo $response;

}


function grantSiteAccess($ACCOUNT_NAME, $SITE_NAME, $PERMISSIONS){

  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE.'/accounts/'.$ACCOUNT_NAME.'/sites/'.$SITE_NAME.'/permissions',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
        "permissions": $PERMISSIONS
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.DUDA_API_KEY,
        'Content-Type: application/json'
      ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;

}


function getResetPasswordLink($ACCOUNT_NAME){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => DUDA_ROUTE.'/accounts/reset-password/'.$ACCOUNT_NAME,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Basic '.DUDA_API_KEY,
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;
}

?>