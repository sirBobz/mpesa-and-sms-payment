<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 * 
 * @property int $id
 * @property string $name
 * @property int $league_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property League $league
 * @property Collection|Game[] $games
 *
 * @package App\Models
 */
class Team extends Model
{
	protected $table = 'teams';

	protected $casts = [
		'league_id' => 'int'
	];

	protected $fillable = [
		'name',
		'league_id'
	];

	public function league()
	{
		return $this->belongsTo(League::class);
	}

	public function games()
	{
		return $this->hasMany(Game::class, 'home_team_id');
	}
}
