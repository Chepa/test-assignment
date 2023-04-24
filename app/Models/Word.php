<?php

namespace App\Models;

use App\Enums\Language;
use Database\Factories\WordFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Word
 *
 * @property int $id
 * @property string $word
 * @property int $source_word_id
 * @property string $language
 * @property int $theme_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Word newModelQuery()
 * @method static Builder|Word newQuery()
 * @method static Builder|Word query()
 * @method static Builder|Word whereCreatedAt($value)
 * @method static Builder|Word whereId($value)
 * @method static Builder|Word whereLanguage($value)
 * @method static Builder|Word whereThemeId($value)
 * @method static Builder|Word whereUpdatedAt($value)
 * @method static Builder|Word whereWord($value)
 * @property-read Collection<int, Example> $examples
 * @property-read int|null $examples_count
 * @property-read Word|null $source
 * @property-read Theme $theme
 * @property-read Collection<int, Word> $translations
 * @property-read int|null $translations_count
 * @method static WordFactory factory($count = null, $state = [])
 * @method static Builder|Word whereSourceWordId($value)
 * @mixin Builder
 */
final class Word extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'word',
        'source_word_id',
        'theme_id',
        'language',
    ];

    /**
     * @var array<string>
     */
    protected $casts = [
        'language' => Language::class
    ];

    public function source(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class, 'theme_id');
    }

    public function examples(): HasMany
    {
        return $this->hasMany(Example::class, 'word_id');
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Word::class, 'source_word_id')->whereLanguage(app()->getLocale());
    }
}
