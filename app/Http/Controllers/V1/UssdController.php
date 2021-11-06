<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\UssdTrait;
use Exception;

class UssdController extends Controller
{
    use UssdTrait;

    public $counter;

    public function __construct()
    {
        $this->counter = 1;
    }
    public  function index(Request $request)
    {
        try {
            $session_id   = $request->get('sessionId');
            $service_code = $request->get('serviceCode');
            $phone_number = $request->get('phoneNumber');
            $text         = $request->get('text');

            $ussd_string_exploded = explode("*", $text);

            $this->validateUserInput($ussd_string_exploded);

            $level = count($ussd_string_exploded);
            $current_input = $ussd_string_exploded[sizeof($ussd_string_exploded) - 1];
            $previous_input = $ussd_string_exploded[sizeof($ussd_string_exploded) - 2] ?? $text;
            $pre_previous_input = $ussd_string_exploded[sizeof($ussd_string_exploded) - 3] ?? $text;
            $forth_pre_previous_input = $ussd_string_exploded[sizeof($ussd_string_exploded) - 4] ?? $text;

            if ($text == '') {
                $response = "CON What league would you want to bet on \n";
                foreach ($this->getLeagues() as $league) {
                    $response .= $league->id . ". " . $league->name . " \n";
                }
            } elseif ($level == 1 && !empty($text)) { //2 league id
                $response = "CON What game would you want to bet on \n";
                foreach ($this->getGames($current_input) as $game) {
                    $response .= $game->id . ". " . $game->home_team . " vs " . $game->away_team . " \n";
                }
            } elseif ($level == 2 && !empty($text)) { //3 game id
                $response = "CON What category would you want to bet on \n";
                foreach ($this->getCategoryName($current_input) as $category) {
                    $response .= $this->counter . " " . $category['name'] . " \n";
                    $this->counter++;
                }
            } elseif ($level == 3 && !empty($text)) { //4 select win 
                $response = "CON Pick your selection \n";

                foreach ($this->getSelections($current_input, $previous_input) as $key => $value) {
                    $response .= $this->counter . ". " . $this->getKeyFromData($key) . " " . $value . " \n";
                    $this->counter++;
                }
            } elseif ($level == 4 && !empty($text)) { //1000
                $response = "CON How much do you wish to spend \n";
            } elseif ($level == 5 && !empty($text)) { //

                $response = "END Total possible win is: \n";
                $response .= $this->calculatePossibleWin($current_input, $previous_input, $pre_previous_input, $forth_pre_previous_input, $phone_number) . " \n";
                $response .= "You will get an M-PESA prompt. \n";
            }

            header('Content-type: text/plain');
            echo $this->validateResponse($response);
        } catch (Exception $exception) {
            exit('Please enter a valid option');
        }
    }

    private function validateUserInput($input)
    {
        foreach ($input as $number) {
            if (!preg_match("/^\d*$/", $number)) {
                header('Content-type: text/plain');

                exit('Please enter a valid option');
            }
        }
    }

    public function validateResponse($response)
    {
        if (empty($response)) {
            exit('Please enter a valid option');
        }

        return $response;
    }
}
