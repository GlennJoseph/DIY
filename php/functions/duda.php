<?php

// GET - TEMPLATES
function getTemplates(){

    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE."/sites/multiscreen/templates",
      CURLOPT_RETURNTRANSFER => true,
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

    $resp = curl_exec($curl);
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  
    curl_close($curl);
    
    $response = json_decode($resp);
  
    if($responseCode == 200 || $responseCode == 204){
        return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
    }else{
        return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
    }

}

// POST - CREATE ACCOUNT
function createAccount($data){

  $body_params = ['account_name'=>$data->account_name];

  if (isset($data->first_name)) $body_params['first_name'] = $data->first_name;
  if (isset($data->last_name)) $body_params['last_name'] = $data->last_name;
  if (isset($data->lang)) $body_params['lang'] = $data->lang;
  if (isset($data->email)) $body_params['email'] = $data->email;
  if (isset($data->account_type)) $body_params['account_type'] = $data->account_type;

  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE.'/accounts/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>json_encode($body_params),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.DUDA_API_KEY,
        'Content-Type: application/json'
      ),
    ));

  $resp = curl_exec($curl);
  $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);
  
  $response = json_decode($resp);

  if($responseCode == 200 || $responseCode == 204){
      return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
  }else{
      return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
  }

}


// function getAccount($ACCOUNT_NAME){

//   $curl = curl_init();

//   curl_setopt_array($curl, array(
//     CURLOPT_URL => DUDA_ROUTE.'/accounts/'.$ACCOUNT_NAME,
//     CURLOPT_RETURNTRANSFER => true,
//     CURLOPT_MAXREDIRS => 10,
//     CURLOPT_TIMEOUT => 0,
//     CURLOPT_FOLLOWLOCATION => true,
//     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//     CURLOPT_CUSTOMREQUEST => 'GET',
//     CURLOPT_HTTPHEADER => array(
//       'Authorization: Basic '.DUDA_API_KEY,
//       'Content-Type: application/json'
//     ),
//   ));

//   $response = curl_exec($curl);

//   curl_close($curl);
//   echo $response;
  
// }

// DELETE - ACCOUNT
function deleteAccount($data){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => DUDA_ROUTE.'/accounts/'.$data->account_name,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'DELETE',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Basic '.DUDA_API_KEY,
      'Content-Type: application/json'
    ),
  ));
  
  $resp = curl_exec($curl);
  $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);
  
  $response = json_decode($resp);

  if($responseCode == 200 || $responseCode == 204){
      return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
  }else{
      return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
  }

}

// POST - CREATE SITE
function createSite($data){

  $body_params = ['template_id'=>$data->template_id];

  if (isset($data->default_domain_prefix)) $body_params['default_domain_prefix'] = $data->default_domain_prefix;
  if (isset($data->lang)) $body_params['lang'] = $data->lang;
  if (isset($data->site_data->external_uid)) $body_params['site_data']['external_uid'] = $data->site_data->external_uid;
  if (isset($data->site_data->site_seo->og_image)) $body_params['site_data']['site_seo']['og_image'] = $data->site_data->site_seo->og_image;
  if (isset($data->site_data->site_seo->description)) $body_params['site_data']['site_seo']['description'] = $data->site_data->site_seo->description;
  
  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE.'/sites/multiscreen/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>json_encode($body_params),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.DUDA_API_KEY,
        'Content-Type: application/json',
      ),
  ));
  
  $resp = curl_exec($curl);
  $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);
  
  $response = json_decode($resp);

  if($responseCode == 200 || $responseCode == 204){
      return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
  }else{
      return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
  }

}

// DELETE - SITE
function deleteSite($data){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => DUDA_ROUTE.'/sites/multiscreen/'.$data->site_name,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'DELETE',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Basic '.DUDA_API_KEY,
      'Content-Type: application/json',
    ),
  ));
  
  $resp = curl_exec($curl);
  $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);
  
  $response = json_decode($resp);

  if($responseCode == 200 || $responseCode == 204){
      return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
  }else{
      return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
  }

}

// GET - SSO LINK
function getSSOLink($data){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => DUDA_ROUTE.'/accounts/sso/'.$data->account_name.'/link',
    CURLOPT_RETURNTRANSFER => true,
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
  
    $resp = curl_exec($curl);
    $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  
    curl_close($curl);
    
    $response = json_decode($resp);
  
    if($responseCode == 200 || $responseCode == 204){
        return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
    }else{
        return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
    }
}

// POST - GRANT SITE ACCESS
function grantSiteAccess($data){

    // add predefined permissions
  $body_params = ['permissions'=>['STATS','EDIT','DEV_MODE']];

  if (isset($data->permissions)) $body_params['permissions'] = $data->permissions;

  $curl = curl_init();

  curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE.'/accounts/'.$data->account_name.'/sites/'.$data->site_name.'/permissions',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>json_encode($body_params),
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic '.DUDA_API_KEY,
        'Content-Type: application/json'
      ),
  ));

  $resp = curl_exec($curl);
  $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);
  
  $response = json_decode($resp);

  if($responseCode == 200 || $responseCode == 204){
      return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
  }else{
      return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
  }

}

// GET - RESET PASSWORD LINK
function getResetPasswordLink($data){

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => DUDA_ROUTE.'/accounts/reset-password/'.$data->account_name,
    CURLOPT_RETURNTRANSFER => true,
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

  $resp = curl_exec($curl);
  $responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

  curl_close($curl);
  
  $response = json_decode($resp);

  if($responseCode == 200 || $responseCode == 204){
      return ["status"=>true,"response"=>$response,"request"=>__FUNCTION__];
  }else{
      return ["status"=>false,"response"=>$response->message,"request"=>__FUNCTION__];
  }
}

?>