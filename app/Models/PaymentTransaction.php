<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentTransaction
 * 
 * @property int $id
 * @property string $BusinessShortCode
 * @property string $Amount
 * @property string $PartyA
 * @property string $PartyB
 * @property string $AccountReference
 * @property string|null $MerchantRequestID
 * @property string|null $CheckoutRequestID
 * @property string|null $ResponseDescription
 * @property string|null $ResponseCode
 * @property string|null $CustomerMessage
 * @property string|null $ResultCode
 * @property string|null $ResultDesc
 * @property string|null $Balance
 * @property string|null $MpesaReceiptNumber
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 * @property Collection|SmsTransaction[] $sms_transactions
 *
 * @package App\Models
 */
class PaymentTransaction extends Model
{
	protected $table = 'payment_transactions';

	protected $fillable = [
		'BusinessShortCode',
		'Amount',
		'PartyA',
		'PartyB',
		'AccountReference',
		'MerchantRequestID',
		'CheckoutRequestID',
		'ResponseDescription',
		'ResponseCode',
		'CustomerMessage',
		'ResultCode',
		'ResultDesc',
		'Balance',
		'MpesaReceiptNumber'
	];

	public function sms_transactions()
	{
		return $this->hasMany(SmsTransaction::class, 'payment_id');
	}
}
