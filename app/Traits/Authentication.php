<?php

namespace App\Traits;
use Config;

trait Authentication
{

    public function authorization()
    {

        $this_url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $this_url);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Basic ' . $this->getCredentials()));

        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $curl_response = curl_exec($curl);

        curl_close($curl);

        return json_decode($curl_response)->access_token;
    }

    public function getCredentials(){

        return base64_encode(trim(Config::get('apiCredentials.safaricom_payment_service.consumer_key')) . ":" . trim(Config::get('apiCredentials.safaricom_payment_service.consumer_secret')));
    }

}