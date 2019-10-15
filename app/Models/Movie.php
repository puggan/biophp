<?php
declare(strict_types=1);

namespace App\Models;

use App\Traits\JsonModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection as C;

/**
 * Class Movie
 * @package App\Models
 * @property int id
 * @property string title
 * @property string category
 * @property int length
 * @property int age_limit
 * @property string description
 * @property string language
 * @property Carbon premiere
 * @property C|Show[] shows
 */
class Movie extends Model
{
    use JsonModel;

    protected $fillable = ['title', 'category', 'length', 'age_limit', 'description', 'language', 'premiere'];
    protected $dates = ['premiere'];
    public $timestamps = false;

    /**
     * @return HasMany
     */
    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
