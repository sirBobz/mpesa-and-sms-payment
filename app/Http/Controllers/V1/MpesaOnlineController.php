<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PaymentDataTable;

class MpesaOnlineController extends Controller
{

    public function index(PaymentDataTable $dataTable){

        return $dataTable->render('v1.payments.index');
    }
   
}
