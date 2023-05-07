<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 *
 * @property int $id
 * @property int $url_id
 * @property string $ip_address
 * @property Carbon $visited_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class UrlVisit extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'url_visits';

    /**
     * @var string[]
     */
    protected $fillable = [
        'url_id',
        'ip_address',
        'visited_at'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'visited_at',
        'created_at',
        'updated_at',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'url_id' => 'integer',
        'visited_at'   => 'datetime',
    ];

    /**
     * @return BelongsTo<Url, UrlVisit>
     */
    public function Url(): BelongsTo
    {
        return $this->belongsTo(Url::class, 'url_id');
    }
}
