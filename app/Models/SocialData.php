<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\SocialData
 *
 * @property int $id
 * @property int $user_id
 * @property string $social_id
 * @property string $social_name
 * @property string $social_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData query()
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereSocialId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereSocialName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereSocialType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SocialData whereUserId($value)
 * @mixin \Eloquent
 */
class SocialData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'social_id',
        'social_name',
        'social_type',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
