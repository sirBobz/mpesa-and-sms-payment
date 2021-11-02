<?php

namespace App\Http\Controllers\V1;

use App\DataTables\PaymentDataTable;
use App\Http\Controllers\Controller;
use App\Jobs\SendSms;
use App\Models\PaymentTransaction;

class MpesaOnlineController extends Controller
{

    public function index(PaymentDataTable $dataTable)
    {

        return $dataTable->render('v1.payments.index');
    }

    public function apiResult()
    {

        $request = json_decode(trim(file_get_contents('php://input')));

        foreach ($request->Body->stkCallback->CallbackMetadata->Item ?? [] as $item) {
            if ($item->Name == "MpesaReceiptNumber") {
                $MpesaReceiptNumber = $item->Value;
            }
        }

        $transaction = PaymentTransaction::where('CheckoutRequestID', '=', $request->Body->stkCallback->CheckoutRequestID)->first();

        if (!$transaction) {
            response()->json(['ResultCode' => 400, 'ResultDesc' => "Validation failed"], 400)->send();
        }

        $transaction->ResultCode = ($request->Body->stkCallback->ResultCode == 0) ? 200 : 400;
        $transaction->ResultDesc = $request->Body->stkCallback->ResultDesc;
        $transaction->CheckoutRequestID = $MpesaReceiptNumber ?? $request->Body->stkCallback->CheckoutRequestID;
        $transaction->CustomerMessage = $request->Body->stkCallback->CustomerMessage ?? '';
        $transaction->save();

        if ($request->Body->stkCallback->ResultCode == 0) {
            //Send Sms
            $message = "Payment received. Thank you for trusting us.";
        } else {
            //Send Sms
            $message = "Payment failed, please try again. Thank you.";
        }

        SendSms::dispatch((object) $this->formatMessage($message, $transaction));

    }

    private function formatMessage($message, $transaction){
        return [
            'from' => "Tanda_Agent",
            'phone' => $transaction->PartyA,
            'message' => $message,
            'payment_id' => $transaction->id,
        ];
    }

}
