<?php
namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GamesController extends Controller
{
    /**
     * @throws \JsonException
     */
    public function index(){
        $request = json_decode(trim(file_get_contents('php://input')) , true, 512, JSON_THROW_ON_ERROR);

        foreach ($request['leagues'] as $league => $games) {

            foreach ($games as $game) {
                foreach ($game as $value) {
                    //echo $value['home'] . " " . $value['away'] . "<\n>";
                    foreach ($value['markets'] as $market) {

                        if ($market['name'] === 'Who to win') {

                            foreach ($market['selections'] as $selections_key => $selections_value) {
                               if ($selections_key === '1') {
                                   $home_team_win_odds = $selections_value;
                               }elseif ($selections_key === 'x'){
                                  $draw_odds = $selections_value;
                               }elseif ($selections_key === '2'){
                                 $away_win_odds = $selections_key;
                               }
                            }
                        }
                        if ($market['name'] === 'Who to score') {

                            foreach ($market['selections'] as $selections) {

                            }
                        }

                        if ($market['name'] === 'Number of goals') {

                            foreach ($market['selections'] as $selections) {

                            }
                        }
                    }
                }
            }
        }
    }

}

