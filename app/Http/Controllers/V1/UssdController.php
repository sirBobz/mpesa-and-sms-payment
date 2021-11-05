<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UssdTrait;

class UssdController extends Controller
{
    use UssdTrait;

   public  function index(Request $request)
   {
       $session_id   = $request->get('sessionId');
       $service_code = $request->get('serviceCode');
       $phone_number = $request->get('phoneNumber');
       $text         = $request->get('text');

       $ussd_string_exploded = explode("*", $text);
       $level = count($ussd_string_exploded);
       $last_input = $ussd_string_exploded [sizeof($ussd_string_exploded) - 1];

       if ($text == '') {
           // first question leagues options concatenated
           $response = "CON What league would you want to bet on \n";
          foreach ($this->getLeagues() as $league){
              $response .= $league->id . ". " . $league->name . " \n";
          }

       }elseif ($level == 1 && !empty($text)) {
           // second menu first question
           $response = "CON What game would you want to bet on \n";
           //game options concatenated
           foreach ($this->getGames($text) as $game){
               $response .= $game->id . ". " . $game->home_team . " vs " . $game->away_team . " \n";
           }
           //end of second session
       }elseif ($level == 2 && !empty($text)){
           // fourth menu first question
           $response = "CON What option would you want to bet on \n";
           //game options concatenated
           return $this->getSelections($last_input);
//           foreach ($this->getSelections($last_input) as $selection){
//               $response .= $game->id . ". " . $game->home_team . " vs " . $game->away_team . " \n";
//           }
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

       header('Content-type: text/plain');
      echo $response;
   }

}
