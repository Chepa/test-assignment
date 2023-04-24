<?php

namespace App\Http\Resources;

use App\Models\Example;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Word $resource */
class SearchResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'word' => $this->resource->translations->first()?->word,
            'examples' => $this->examples()
        ];
    }

    private function examples(): array
    {
        return $this->resource
                ->translations
                ->first()
                ?->examples
                ->map(fn (Example $example) => $example->sentence)
                ->toArray();
    }
}
