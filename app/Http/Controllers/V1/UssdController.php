<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UssdTrait;

class UssdController extends Controller
{
    use UssdTrait;

    public $counter;

    public function __construct(){
        $this->counter = 0;
    }
   public  function index(Request $request)
   {
       $session_id   = $request->get('sessionId');
       $service_code = $request->get('serviceCode');
       $phone_number = $request->get('phoneNumber');
       $text         = $request->get('text');

       $ussd_string_exploded = explode("*", $text);
       $level = count($ussd_string_exploded);
       $last_input = $ussd_string_exploded [sizeof($ussd_string_exploded) - 1];
       $previous_input = $ussd_string_exploded [sizeof($ussd_string_exploded) - 2];

       if ($text == '') {
           $response = "CON What league would you want to bet on \n";
          foreach ($this->getLeagues() as $league){
              $response .= $league->id . ". " . $league->name . " \n";
          }

       }elseif ($level == 1 && !empty($text)) {
           $response = "CON What game would you want to bet on \n";
           foreach ($this->getGames($text) as $game){
               $response .= $game->id . ". " . $game->home_team . " vs " . $game->away_team . " \n";
           }

       }elseif ($level == 2 && !empty($text)){
           $response = "CON What category would you want to bet on \n";
          foreach ($this->getCategoryName($last_input) as $category){
              $response .= $this->counter . " " . $category['name'] . " \n";
              $this->counter ++;
          }

       }elseif ($level == 3 && !empty($text)){
           // fifth menu fifth question
           $response = "CON Pick your category \n";
          foreach(json_decode($this->getSelections($last_input, $previous_input), true) as $selections){
            $response .= $this->counter . " " . $selections['name'] . " \n";
            $this->counter ++;
          }
       }

       header('Content-type: text/plain');
      echo $response;
   }

}
