<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SmsTransaction
 * 
 * @property int $id
 * @property string $from
 * @property string $phone
 * @property string $message
 * @property string $webhook
 * @property string $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class SmsTransaction extends Model
{
	protected $table = 'sms_transactions';

	protected $fillable = [
		'from',
		'phone',
		'message',
		'webhook',
		'status'
	];
}
