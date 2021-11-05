<?php

namespace App\Traits;
use App\Models\Game;
use App\Models\League;
use App\Models\Market;

trait UssdTrait
{
    public function getLeagues(){
        return League::orderBy('id')->get();
    }

    public  function getGames($league_id){
        return Game::where('league_id', $league_id)->orderBy('id')->get();
    }

    public  function  getSelections($game_id){
        $markets_data = Market::where('game_id', $game_id)->value('markets');

        if ($markets_data) {

        }


    }

    private  function getDataFromSelection($data){
        foreach ($value['markets'] as $market) {

            $market_name = $market['name'];
            $market_code = $market['code'];

            if ($market['name'] === 'Who to win') {

                foreach ($market['selections'] as $selections_key => $selections_value) {
                    $market_name = $market['name'];
                    if ($selections_key == '1'){
                        $home_team_win_odds = $selections_value;
                    }elseif ($selections_key == 'x'){
                        $draw_odds = $selections_value;
                    }elseif ($selections_key == '2'){
                        $away_win_odds = $selections_value;
                    }

                }
            }
            if ($market['name'] === 'Who to score') {

                foreach ($market['selections'] as $selections_key => $selections_value) {
                    if ($selections_key == 'ng'){
                        $no_goal = $selections_value;
                    }elseif ($selections_key == 'gg'){
                        $goal_goal = $selections_value;
                    }
                }
            }

            if ($market['name'] === 'Number of goals') {

                foreach ($market['selections'] as $selections_key => $selections_value) {
                    if ($selections_key == 'o2.5'){
                        $over_two_point_five = $selections_value;
                    }elseif ($selections_key == 'u.2.5'){
                        $under_two_point_five = $selections_value;
                    }
                }
            }
        }
    }
}
