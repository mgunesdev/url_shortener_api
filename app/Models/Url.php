<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 *
 * @property int $id
 * @property string $link
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Url extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'urls';

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'name',
        'link',
        'slug'
    ];

    /**
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * A short URL can be visited many times.
     *
     * @return HasMany<UrlVisit>
     */
    public function visits(): HasMany
    {
        return $this->hasMany(UrlVisit::class, 'url_id');
    }

    /**
     * A short URL can be visited many times.
     *
     * @return int
     */
    public function visitCount(): int
    {
        return $this->hasMany(UrlVisit::class, 'url_id')->count();
    }

    /**
     * @param string $slug
     * @return Url|null
     */
    public static function findBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->first();
    }

    /**
     * @param string $link
     * @return Collection<int, Url>
     */
    public static function findByLink(string $link): Collection
    {
        return self::where('link', $link)->get();
    }
}
