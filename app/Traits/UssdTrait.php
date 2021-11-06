<?php

namespace App\Traits;

use App\Models\Game;
use App\Models\League;
use App\Models\Market;
use App\Jobs\PostDataToApi;

trait UssdTrait
{
    public function getLeagues()
    {
        return League::orderBy('id')->get();
    }

    public  function getGames($league_id)
    {
        return Game::where('league_id', $league_id)->orderBy('id')->get();
    }

    public  function  getCategoryName($game_id)
    {
        return Market::where('game_id', $game_id)->value('markets');
    }

    public function getSelections($latest_input, $game_id)
    {

        foreach ($this->getCategoryName($game_id) as $categoryName) {

            if ($this->counter == $latest_input) {
                return $categoryName['selections'];
            }
            $this->counter++;
        }
    }

    public function calculatePossibleWin($current_input, $last_input, $pre_previous_input, $game_id, $phone_number)
    {
        $total_win = 0;

        foreach ($this->getSelections($pre_previous_input, $game_id) as $key => $value) {
            if ($this->counter == $last_input) {
                $total_win = $value * $current_input;
                continue;
            }
            $this->counter++;
        }

        //Dispatch data to queue
        PostDataToApi::dispatch((object) ['amount' => $total_win, 'phone_number' => $phone_number]);

        return $total_win;
    }

    public function getKeyFromData($data)
    {
        $key_value =
            [
                '1' => 'home team win odds',
                'x' => 'draw odds',
                '2' => 'away team win odds',
                'ng' => 'no goal odds',
                'gg' => 'goal goal odds',
                'o2.5' => 'over two point five odds',
                'u.2.5' => 'under two point five odds'
            ];

        return $key_value[$data];
    }
}
