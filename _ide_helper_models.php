<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\BitcoinAddress
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $total_received
 * @property int $balance
 * @property int $total_sent
 * @property mixed $private
 * @property mixed $wif
 * @property mixed $public
 * @property string $address
 * @property int|null $trade_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BitcoinTransaction[] $transactions
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereTotalReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereTotalSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinAddress whereWif($value)
 */
	class BitcoinAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BitcoinTransaction
 *
 * @property int $id
 * @property int $address_id
 * @property string $type
 * @property string|null $output_address
 * @property int|null $value
 * @property int|null $fees
 * @property string|null $hash
 * @property int|null $double_spend
 * @property int|null $confirmations
 * @property string|null $preference
 * @property string|null $received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BitcoinAddress $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereConfirmations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereDoubleSpend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereOutputAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction wherePreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BitcoinTransaction whereValue($value)
 */
	class BitcoinTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DashAddress
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $total_received
 * @property int $balance
 * @property int $total_sent
 * @property mixed $private
 * @property mixed $public
 * @property mixed $wif
 * @property string $address
 * @property int|null $trade_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DashTransaction[] $transactions
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereTotalReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereTotalSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashAddress whereWif($value)
 */
	class DashAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DashTransaction
 *
 * @property int $id
 * @property int $address_id
 * @property string $type
 * @property string|null $output_address
 * @property int|null $value
 * @property int|null $fees
 * @property string|null $hash
 * @property int|null $double_spend
 * @property int|null $confirmations
 * @property string|null $preference
 * @property string|null $received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DashAddress $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereConfirmations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereDoubleSpend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereOutputAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction wherePreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DashTransaction whereValue($value)
 */
	class DashTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DogecoinAddress
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $total_received
 * @property int $balance
 * @property int $total_sent
 * @property mixed $private
 * @property mixed $public
 * @property mixed $wif
 * @property string $address
 * @property int|null $trade_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DogecoinTransaction[] $transactions
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereTotalReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereTotalSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinAddress whereWif($value)
 */
	class DogecoinAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DogecoinTransaction
 *
 * @property int $id
 * @property int $address_id
 * @property string $type
 * @property string|null $output_address
 * @property int|null $value
 * @property int|null $fees
 * @property string|null $hash
 * @property int|null $double_spend
 * @property int|null $confirmations
 * @property string|null $preference
 * @property string|null $received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\DogecoinAddress $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereConfirmations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereDoubleSpend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereOutputAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction wherePreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DogecoinTransaction whereValue($value)
 */
	class DogecoinTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailComponent
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $header
 * @property string|null $footer
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailComponent whereFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailComponent whereHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailComponent whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EmailComponent whereUpdatedAt($value)
 */
	class EmailComponent extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EthereumAddress
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $total_received
 * @property int $balance
 * @property int $total_sent
 * @property mixed $private
 * @property mixed $wif
 * @property mixed $public
 * @property string $address
 * @property int|null $trade_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EthereumTransaction[] $transactions
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereTotalReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereTotalSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumAddress whereWif($value)
 */
	class EthereumAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EthereumTransaction
 *
 * @property int $id
 * @property int $address_id
 * @property string $type
 * @property string|null $output_address
 * @property int|null $value
 * @property int|null $fees
 * @property string|null $hash
 * @property int|null $double_spend
 * @property int|null $confirmations
 * @property string|null $preference
 * @property string|null $received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EthereumAddress $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereConfirmations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereDoubleSpend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereOutputAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction wherePreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\EthereumTransaction whereValue($value)
 */
	class EthereumTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LitecoinAddress
 *
 * @property int $id
 * @property int|null $user_id
 * @property int $total_received
 * @property int $balance
 * @property int $total_sent
 * @property mixed $private
 * @property mixed $public
 * @property mixed $wif
 * @property string $address
 * @property int|null $trade_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LitecoinTransaction[] $transactions
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress wherePrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress wherePublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereTotalReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereTotalSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinAddress whereWif($value)
 */
	class LitecoinAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LitecoinTransaction
 *
 * @property int $id
 * @property int $address_id
 * @property string $type
 * @property string|null $output_address
 * @property int|null $value
 * @property int|null $fees
 * @property string|null $hash
 * @property int|null $double_spend
 * @property int|null $confirmations
 * @property string|null $preference
 * @property string|null $received
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\LitecoinAddress $address
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereConfirmations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereDoubleSpend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereFees($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereHash($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereOutputAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction wherePreference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereReceived($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\LitecoinTransaction whereValue($value)
 */
	class LitecoinTransaction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ModerationActivity
 *
 * @property int $id
 * @property int $user_id
 * @property string $moderator
 * @property string $activity
 * @property string|null $comment
 * @property string|null $link
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereActivity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereModerator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ModerationActivity whereUserId($value)
 */
	class ModerationActivity extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NotificationSetting
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property int|null $email
 * @property int|null $database
 * @property int|null $sms
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereDatabase($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereSms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationSetting whereUserId($value)
 */
	class NotificationSetting extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NotificationTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $level
 * @property string|null $subject
 * @property string|null $intro_line
 * @property string|null $action
 * @property string|null $channels
 * @property string|null $outro_line
 * @property string|null $message
 * @property int $action_editable
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereActionEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereChannels($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereIntroLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereOutroLine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\NotificationTemplate whereUpdatedAt($value)
 */
	class NotificationTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Offer
 *
 * @property int $id
 * @property string $token
 * @property string $type
 * @property string $coin
 * @property string $currency
 * @property int $user_id
 * @property int $status
 * @property float $min_amount
 * @property float $max_amount
 * @property float $profit_margin
 * @property string $payment_method
 * @property array $tags
 * @property string|null $trade_instruction
 * @property string|null $terms
 * @property string|null $label
 * @property int $phone_verification
 * @property int $email_verification
 * @property int $trusted_offer
 * @property int $deadline
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereCoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereEmailVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereMaxAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereMinAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer wherePhoneVerification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereProfitMargin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereTradeInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereTrustedOffer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Offer withToken($flag = true)
 */
	class Offer extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentMethod
 *
 * @property int $id
 * @property int $payment_method_category_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\PaymentMethodCategory $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod wherePaymentMethodCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethod whereUpdatedAt($value)
 */
	class PaymentMethod extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentMethodCategory
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentMethod[] $payment_methods
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethodCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethodCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethodCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentMethodCategory whereUpdatedAt($value)
 */
	class PaymentMethodCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Profile
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $picture
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $bio
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereBio($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile wherePicture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Profile whereUserId($value)
 */
	class Profile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Trade
 *
 * @property int $id
 * @property string $token
 * @property string $type
 * @property string $coin
 * @property int $user_id
 * @property int $partner_id
 * @property int|null $offer_id
 * @property string $currency
 * @property float $fee
 * @property int $amount
 * @property float $rate
 * @property string|null $offer_terms
 * @property string|null $instruction
 * @property string|null $label
 * @property string|null $dispute_by
 * @property string|null $dispute_comment
 * @property int $confirmed
 * @property int $deadline
 * @property string $status
 * @property string $payment_method
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BitcoinAddress $bitcoin_address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TradeChat[] $chats
 * @property-read \App\Models\DashAddress $dash_address
 * @property-read \App\Models\DogecoinAddress $dogecoin_address
 * @property-read \App\Models\LitecoinAddress $litecoin_address
 * @property-read \App\Models\Offer|null $offer
 * @property-read \App\Models\User $partner
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereCoin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereConfirmed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereDeadline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereDisputeBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereDisputeComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereInstruction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereOfferId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereOfferTerms($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePartnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Trade withToken($flag = true)
 */
	class Trade extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TradeChat
 *
 * @property int $id
 * @property int|null $trade_id
 * @property string $content
 * @property string $type
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Trade|null $trade
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TradeChat whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TradeChat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TradeChat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TradeChat whereTradeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TradeChat whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TradeChat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\TradeChat whereUserId($value)
 */
	class TradeChat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $presence
 * @property string|null $last_seen
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $timezone
 * @property string $currency
 * @property string $status
 * @property int $verified_phone
 * @property string $password
 * @property string|null $google2fa_secret
 * @property string|null $token
 * @property string|null $token_expiry
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $verified
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BitcoinAddress[] $bitcoin_addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BitcoinTransaction[] $bitcoin_transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $contacts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DashAddress[] $dash_addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DashTransaction[] $dash_transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DogecoinAddress[] $dogecoin_addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DogecoinTransaction[] $dogecoin_transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EthereumAddress[] $ethereum_addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\EthereumTransaction[] $ethereum_transactions
 * @property-read mixed $average_rating
 * @property-read mixed $sum_rating
 * @property-read mixed $user_average_rating
 * @property-read mixed $user_sum_rating
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LitecoinAddress[] $litecoin_addresses
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LitecoinTransaction[] $litecoin_transactions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ModerationActivity[] $moderation_activities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\NotificationSetting[] $notification_settings
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Offer[] $offers
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \App\Models\Profile $profile
 * @property-read \Illuminate\Database\Eloquent\Collection|\willvincent\Rateable\Rating[] $ratings
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \App\Models\UserSetting $setting
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Trade[] $trades
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGoogle2faSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastSeen($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePresence($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTokenExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVerified($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereVerifiedPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User withToken($flag = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserSetting
 *
 * @property int $id
 * @property int $user_id
 * @property int $google2fa_status
 * @property int $user_login_2fa
 * @property int $outgoing_transfer_2fa
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSetting whereGoogle2faStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSetting whereOutgoingTransfer2fa($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSetting whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSetting whereUserLogin2fa($value)
 */
	class UserSetting extends \Eloquent {}
}

