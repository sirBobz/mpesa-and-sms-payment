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
 * @property Carbon $date_of_play
 * @property int $home_team_id
 * @property int $away_team_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Team $team
 * @property Collection|Market[] $markets
 *
 * @package App\Models
 */
class Game extends Model
{
	protected $table = 'games';

	protected $casts = [
		'home_team_id' => 'int',
		'away_team_id' => 'int'
	];

	protected $dates = [
		'date_of_play'
	];

	protected $fillable = [
		'date_of_play',
		'home_team_id',
		'away_team_id'
	];

	public function team()
	{
		return $this->belongsTo(Team::class, 'home_team_id');
	}

	public function markets()
	{
		return $this->hasMany(Market::class);
	}
}
