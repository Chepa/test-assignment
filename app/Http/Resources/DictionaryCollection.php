<?php

namespace App\Http\Resources;

use App\Enums\Language;
use App\Models\Theme;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class DictionaryCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        /** @var Theme $resource */
        return $this->collection
                ->map(fn(DictionaryResource $resource) => [
                    'theme' => __($resource->name),
                    'words' => $resource->words
                        ->sortBy(fn(Word $word) => array_search($word->language, Language::toArray()))
                        ->map(fn(Word $word) => $word->only('language', 'word'))
                ])->toArray();
    }
}
