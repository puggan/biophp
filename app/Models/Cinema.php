<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection as C;

/**
 * Class Cinema
 * @package App\Models
 * @property int id
 * @property string name
 * @property string location
 * @property C|Auditorium[] auditoriums
 */
class Cinema extends Model
{
    protected $fillable = ['name', 'location'];
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function auditoriums(): HasMany
    {
        return $this->hasMany(Auditorium::class);
    }
}
