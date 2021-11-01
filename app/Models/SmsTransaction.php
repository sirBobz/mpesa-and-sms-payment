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
 * @property int|null $payment_id
 * @property string $from
 * @property string $phone
 * @property string $message
 * @property string|null $message_id
 * @property string|null $delivered_at
 * @property string|null $status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property PaymentTransaction|null $payment_transaction
 *
 * @package App\Models
 */
class SmsTransaction extends Model
{
	protected $table = 'sms_transactions';

	protected $casts = [
		'payment_id' => 'int'
	];

	protected $fillable = [
		'payment_id',
		'from',
		'phone',
		'message',
		'message_id',
		'delivered_at',
		'status'
	];

	public function payment_transaction()
	{
		return $this->belongsTo(PaymentTransaction::class, 'payment_id');
	}
}
