<?php

namespace App\Traits;

use Config;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

trait Authentication
{

    public function authorization()
    {
        if (Cache::has('safaricom_current_token_for_the_period')) {
            return Cache::get('safaricom_current_token_for_the_period');
        } else {
            Cache::add('safaricom_current_token_for_the_period', $token = $this->generateToken(), Carbon::now()->addMinutes(15));
            return $token;
        }
    }

    private function generateToken()
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

    public function getCredentials()
    {
        return base64_encode(trim(Config::get('apiCredentials.safaricom_payment_service.consumer_key')) . ":" . trim(Config::get('apiCredentials.safaricom_payment_service.consumer_secret')));
    }

}
