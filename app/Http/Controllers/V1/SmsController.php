<?php

namespace App\Http\Controllers\V1;

use App\DataTables\SmsDataTable;
use App\Http\Controllers\Controller;
use App\Models\SmsTransaction;
use Illuminate\Http\Request;

class SmsController extends Controller
{

    public function index(SmsDataTable $dataTable)
    {

        return $dataTable->render('v1.sms.index');
    }

    public function apiResult(Request $request)
    {

        $transaction = SmsTransaction::where('message_id', $request->id)->first();

        if ($transaction) {
            $transaction->status = $request->status;
            $transaction->delivered_at = $request->sent_at;
            $transaction->delivery_payload = $request->all();
            $transaction->save();
        }

    }

}
