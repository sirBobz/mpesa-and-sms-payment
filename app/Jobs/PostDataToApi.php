<?php

namespace App\Jobs;

use App\Jobs\SendSms;
use App\Models\PaymentTransaction;
use App\Traits\Authentication;
use App\Traits\PostData;
use Config;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class PostDataToApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Authentication, PostData;

    public $data;
    public $timestamp;
    public $confirmation_url;
    public $short_code;
    public $pass_key;
    public $AccountReference;
    public $post_url;
    public $partyB;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->timestamp = preg_replace('/\D/', '', date('Y-m-d H:i:s'));
        $this->confirmation_url = "https://5401-197-248-198-135.ngrok.io/api/payment";
        $this->short_code = "709345";
        $this->pass_key = trim(Config::get('apiCredentials.safaricom_payment_service.passkey'));
        $this->AccountReference = Str::random(10);
        $this->post_url = "https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest";
        $this->partyB = "600000";
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        // save transaction
        $payment = new PaymentTransaction();
        $payment->Amount = $this->data->amount;
        $payment->PartyA = "254" . substr($this->data->phone_number, -9);
        $payment->AccountReference = $this->AccountReference;
        $payment->BusinessShortCode = $this->short_code;
        $payment->partyB = $this->short_code;
        $payment->save();

        //Send Sms
        $data = [
            'from' => "Tanda",
            'phone' => "254" . substr($this->data->phone_number, -9),
            'message' => "Please check your phone for a Push activation. Input your PIN to enable payment.",
            'payment_id' => $payment->id,
        ];

        SendSms::dispatch((object) $data);

        // send api call
        $apiResponse = $this->sendPostRequest($this->formatData(), $this->authorization(), $this->post_url);

        // save api response
        $this->saveApiResponse($apiResponse, $payment);

    }

    private function formatData()
    {
        // format post data
        return
            [
            'BusinessShortCode' => $this->short_code,
            'Password' => base64_encode($this->short_code . $this->pass_key . $this->timestamp),
            'Timestamp' => $this->timestamp,
            'TransactionType' => 'CustomerPayBillOnline',
            'Amount' => $this->data->amount,
            'PartyA' => "254" . substr($this->data->phone_number, -9),
            'PartyB' => $this->short_code,
            'PhoneNumber' => "254" . substr($this->data->phone_number, -9),
            'CallBackURL' => $this->confirmation_url,
            'AccountReference' => $this->AccountReference,
            'TransactionDesc' => 'Online Payment',
        ];
    }

    public function saveApiResponse($result, $payment)
    {

        $result = json_decode($result['response']);

        $payment->CheckoutRequestID = $result->CheckoutRequestID ?? $result->requestId ?? '';
        $payment->ResponseCode = $result->ResponseCode ?? $result->errorCode ?? '';
        $payment->ResponseDescription = $result->ResponseDescription ?? $result->errorMessage ?? '';
        $payment->save();
    }

}
