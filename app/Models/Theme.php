<?php

namespace App\Models;

use App\Enums\Language;
use Database\Factories\ThemeFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Theme
 *
 * @property int $id
 * @property string $word_id
 * @property Language $language
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static ThemeFactory factory($count = null, $state = [])
 * @method static Builder|Theme newModelQuery()
 * @method static Builder|Theme newQuery()
 * @method static Builder|Theme query()
 * @method static Builder|Theme whereCreatedAt($value)
 * @method static Builder|Theme whereId($value)
 * @method static Builder|Theme whereLanguage($value)
 * @method static Builder|Theme whereName($value)
 * @method static Builder|Theme whereUpdatedAt($value)
 * @mixin Builder
 */
final class Theme extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'word_id',
        'language',
    ];

    /**
     * @var array<string>
     */
    protected $casts = [
        'language' => Language::class
    ];

    public function words(): HasMany
    {
        return $this->hasMany(Word::class, 'theme_id');
    }
}
