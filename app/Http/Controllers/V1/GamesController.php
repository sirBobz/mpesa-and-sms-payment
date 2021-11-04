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

        $request = json_decode(trim(file_get_contents('php://input')), true, 512, JSON_THROW_ON_ERROR);
        $i = 0;
        foreach($request['leagues'] as $league => $games) {

            foreach ($games as $game) {
                foreach ($game as $value) {
                    //echo $value['home'] . " " . $value['away'] . "<\n>";

                    foreach ($value['markets'] as $market){
                        foreach ($market->selections as $selections){
                            
                        }
                    }
                }
            }

        }
    }
}
