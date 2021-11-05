<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Game
 * 
 * @property int $id
 * @property int $league_id
 * @property string|null $date_of_play
 * @property string|null $game_id
 * @property string $home_team
 * @property string $away_team
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property League $league
 * @property Collection|Market[] $markets
 *
 * @package App\Models
 */
class Game extends Model
{
	protected $table = 'games';

	protected $casts = [
		'league_id' => 'int'
	];

	protected $fillable = [
		'league_id',
		'date_of_play',
		'game_id',
		'home_team',
		'away_team'
	];

	public function league()
	{
		return $this->belongsTo(League::class);
	}

	public function markets()
	{
		return $this->hasMany(Market::class);
	}
}
