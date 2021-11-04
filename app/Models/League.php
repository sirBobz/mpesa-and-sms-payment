<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class League
 * 
 * @property int $id
 * @property string $name
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|Team[] $teams
 *
 * @package App\Models
 */
class League extends Model
{
	protected $table = 'leagues';

	protected $fillable = [
		'name'
	];

	public function teams()
	{
		return $this->hasMany(Team::class);
	}
}
