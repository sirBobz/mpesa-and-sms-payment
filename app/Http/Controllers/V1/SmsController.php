<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SmsDataTable;
use App\Models\SmsTransaction;

class SmsController extends Controller
{

        public function index(SmsDataTable $dataTable){

            return $dataTable->render('v1.sms.index');
        }

        public function apiResult(Request $request){

          $transaction = SmsTransaction::where('message_id', $request->id)->first();

          if($transaction){
            $transaction->status = $request->status;
            $transaction->delivered_at = $request->sent_at;
            $transaction->save();
          }
              
        }

}
