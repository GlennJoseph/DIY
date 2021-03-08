<?php

function getTemplates(){
  
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => DUDA_ROUTE.DUDA_ENDPOINT,
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



?>