<?php

namespace App\Traits;

trait PostData
{
 
    public function sendPostRequest($post_data, $authorization, $url)
    {

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER,
                               array('Content-Type:application/json', 
                                     'Authorization:Bearer ' . $authorization));

            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($post_data));

            $response = curl_exec($curl);
            $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curl_errno = curl_errno($curl);
            $curl_error = curl_error($curl);

            curl_close($curl);

           // Check if any error occured
           if($curl_errno)
            {
               return
                    [ 'error_code' => $curl_errno,
                      'error_desc' => $curl_error,
                      'status'  => $status,
                      'request'   => json_encode($post_data),
                      "response"  => $response
                    ];
            }
            else
            {
              return  [
                      "status"    => $status,
                      'authorization' => $authorization,
                      'request'   => json_encode($post_data),
                      "response"  => $response
                     ];
            }


   }
}