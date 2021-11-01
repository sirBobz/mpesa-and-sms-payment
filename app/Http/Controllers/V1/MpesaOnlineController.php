<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Authentication;

class MpesaOnlineController extends Controller
{
    use Authentication;

    public function index(){

        return view('v1.payments.index');
    }
   
}
