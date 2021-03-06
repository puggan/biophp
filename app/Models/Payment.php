<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\JsonModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * Class Payment
 * @package App\Models
 * @property int id
 * @property Carbon payed_at
 * @property int amount
 * @property string refernece
 * @property int reservation_id
 * @property Reservation reservation
 */
class Payment extends Model
{
    use JsonModel;

    protected $fillable = ['payed_at', 'amount', 'refernece'];
    protected $dates = ['payed_at'];
    const CREATED_AT = 'payed_at';
    const UPDATED_AT = null;

    /**
     * @return BelongsTo
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
