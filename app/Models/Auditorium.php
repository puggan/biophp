<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Auditorium
 * @package App\Models
 * @property int id
 * @property string name
 * @property int seats_total
 * @property Cinema cinema
 */
class Auditorium extends Model
{
    protected $fillable = ['name', 'seats_total'];

    // override default: auditoria
    protected $table = 'auditoriums';

    /**
     * @return BelongsTo
     */
    public function cinema(): BelongsTo
    {
        return $this->belongsTo(Cinema::class);
    }
}
