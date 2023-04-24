<?php

namespace App\Models;

use App\Enums\Language;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * App\Models\Example
 *
 * @property int $id
 * @property string $sentence
 * @property int $word_id
 * @property int $source_example_id
 * @property string $language
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection<int, Example> $translations
 * @method static Builder|Example newModelQuery()
 * @method static Builder|Example newQuery()
 * @method static Builder|Example query()
 * @method static Builder|Example whereCreatedAt($value)
 * @method static Builder|Example whereId($value)
 * @method static Builder|Example whereLanguage($value)
 * @method static Builder|Example whereSentence($value)
 * @method static Builder|Example whereUpdatedAt($value)
 * @method static Builder|Example whereWordId($value)
 * @mixin Builder
 */
final class Example extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'sentence',
        'language',
        'word_id',
        'source_example_id'
    ];

    /**
     * @var array<string>
     */
    protected $casts = [
        'language' => Language::class
    ];

    public function word(): BelongsTo
    {
        return $this->belongsTo(Word::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(Example::class, 'source_example_id')->whereLanguage(app()->getLocale());
    }
}
