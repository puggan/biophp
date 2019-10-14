<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as C;

/**
 * Class Auditorium
 * @package App\Models
 * @property int id
 * @property string name
 * @property int seats_total
 * @property int cinema_id
 * @property Cinema cinema
 * @property C|Show[] shows
 */
class Auditorium extends Model
{
    protected $fillable = ['name', 'seats_total'];
    public $timestamps = false;

    // override default: auditoria
    protected $table = 'auditoriums';

    /**
     * @return BelongsTo
     */
    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }

    /**
     * @return HasMany
     */
    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
