<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SmsDataTable;

class SmsController extends Controller
{

        public function index(SmsDataTable $dataTable){

            return $dataTable->render('v1.sms.index');
        }

}
