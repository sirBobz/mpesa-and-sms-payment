<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsType
 * 
 * @property int $id
 * @property string $sms_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|SmsTransaction[] $sms_transactions
 *
 * @package App\Models
 */
class SmsType extends Model
{
	protected $table = 'sms_types';

	protected $fillable = [
		'sms_type'
	];

	public function sms_transactions()
	{
		return $this->hasMany(SmsTransaction::class);
	}
}
