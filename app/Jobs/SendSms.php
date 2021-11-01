<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Traits\PostData; 
use Config;
use App\Models\SmsTransaction;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, PostData;

    public $data;
    public $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->url = "https://api.mojasms.dev/sendsms";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = [
            'from' =>  $this->data->from,
            'phone' => $this->data->phone,
            'message' => $this->data->message,
        ];

        $sms = new SmsTransaction();
        $sms->from = $this->data->from;
        $sms->phone = $this->data->phone;
        $sms->message = $this->data->message;
        $sms->save();
        

        //get api response
        $apiResponse = $this->sendPostRequest($data, $this->getToken(), $this->url);

        $result = json_decode($apiResponse['response']);

        //save api response
            // $sms->status = $result->status;
            // $sms->message_id = $result->data[0]->message_id;
            // $sms->save(); 
    }


    public function getToken(){

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, 'https://api.mojasms.dev/login');
        curl_setopt($curl, CURLOPT_HTTPHEADER,
                           array('Content-Type:application/json'));

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode([
            'email' => trim(Config::get('apiCredentials.mojagate_sms_service.email')),
            'password' => trim(Config::get('apiCredentials.mojagate_sms_service.password')),
        ]));

        $response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        $curl_errno = curl_errno($curl);
        $curl_error = curl_error($curl);

        curl_close($curl);

        return json_decode($response)->data->token;
    }
}
