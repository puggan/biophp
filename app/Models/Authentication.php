<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Authentication
 * @package App\Models
 * @property int id
 * @property string servise
 * @property string identyfier
 * @property string secret
 * @property int user_id
 * @property User user
 */
class Authentication extends Model
{
    protected $fillable = ['servise', 'identyfier'];
    protected $hidden = ['secret'];
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
