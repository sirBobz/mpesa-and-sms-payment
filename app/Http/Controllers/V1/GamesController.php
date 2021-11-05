<?php
namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;
use App\Models\League;
use App\Models\Game;
use App\Models\Market;

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
                    $home_team = $value['home'];
                    $away_team = $value['away'];
                    $date_of_play = $value['time'];

                    foreach ($value['markets'] as $market) {
                        //market

                    }
                }
            }

            $league = League::updateOrCreate(['name' =>  $league]);

            $game = Game::updateOrCreate([
                'league_id' => $league->id,
                'date_of_play' => $date_of_play,
                'home_team' => $home_team,
                'away_team' => $away_team
            ]);

            $market = Market::updateOrCreate([
                'markets' => $market,
                'game_id' => $game->id,
            ]);


        }
    }

}

