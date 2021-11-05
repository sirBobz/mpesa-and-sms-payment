<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Market
 * 
 * @property int $id
 * @property int $game_id
 * @property array $markets
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Game $game
 *
 * @package App\Models
 */
class Market extends Model
{
	protected $table = 'markets';

	protected $casts = [
		'game_id' => 'int',
		'markets' => 'json'
	];

	protected $fillable = [
		'game_id',
		'markets'
	];

	public function game()
	{
		return $this->belongsTo(Game::class);
	}
}
