<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UssdController extends Controller
{
   public  function index(Request $request)
   {
       //Initial request
       if ($request->text === '') {
           // first question
           $response = "CON What league would you want to bet on \n";
           //leagues options concatenated
           $response .= "1. EPL \n";
           $response .= "2. League 1";
           //end of first session

           //second option pick
       }elseif ($request->text === '1') {
           // second menu first question
           $response = "CON What game would you want to bet on \n";
           //game options concatenated
           $response .= "1. Man Utd vs Arsenal \n";
           $response .= "2. Man City vs Liverpool ";
           //end of second session
       }elseif ($request->text == '1*1'){
           // fourth menu first question
           $response = "CON What option would you want to bet on \n";
           //game options concatenated
           $response .= "1. Who to win \n";
           $response .= "2. Who to score \n";
           $response .= "3. Number of goals \n";
           //end of fourth session
       }elseif ($request->text == '1*1*1'){
           // fifth menu fifth question
           $response = "CON place your bet \n";
           //game options concatenated
           $response .= "1. Home team odds \n";
           $response .= "2. Draw  odds \n";
           $response .= "3. Away team odds \n";
           //end of fifth session
       }

   }

}
