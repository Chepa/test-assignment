<?php

namespace App\Services\OxfordDictionaries;

use App\Enums\Language;
use App\Exceptions\TranslateException;
use App\Models\Example;
use App\Models\Word;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

readonly final class TranslateService
{
    public function __construct(
        private OxfordWrapper $oxfordWrapper
    ) {
    }

    /**
     * @throws TranslateException
     * @throws Exception
     */
    public function updateOrCreate(
        string $word,
        int $themeId,
        string $languageTo,
        string $languageFrom = Language::EN->value
    ): Word {
        $translate = $this->oxfordWrapper->lookFor($word)
            ->from($languageFrom)
            ->to($languageTo)
            ->translate();
        $examples = array_slice($translate->getExamples(), 0, 3);

        $sourceWord = Word::whereThemeId($themeId)->whereLanguage($languageFrom)->whereWord(mb_ucfirst($word))->first();

        if (!$sourceWord) {
            $sourceWord = $this->storeWord($word, $themeId, $languageFrom);
        }
        $translatedWord = $this->storeWord(
            mb_ucfirst($translate->get()[0] ?? ''),
            $themeId,
            $languageTo,
            $sourceWord->id
        );

        foreach ($examples as $sourceExample => $translatedExamples) {
            $sourceExample = $this->storeExample($sourceExample, $sourceWord->id, $languageFrom);

            foreach ($translatedExamples as $example) {
                $this->storeExample($example, $translatedWord->id, $languageTo, $sourceExample->id);
            }
        }

        return $sourceWord;
    }

    /**
     * @throws TranslateException
     */
    public function translate(string $query)
    {
        try {
            $word = $this->search($query);

            return $word->translations->first()?->word;
        } catch (Throwable) {
            $translate = $this->oxfordWrapper->lookFor($query)
                ->from(Language::EN->value)
                ->to(app()->getLocale())
                ->translate();

            return $translate->get()[0] ?? '';
        }
    }

    /**
     * @throws Exception
     */
    public function search(string $query): Word|null
    {
        try {
            return Word::with('translations', 'translations.examples')
                ->where('word', 'like', $query)
                ->whereHas('translations')
                ->whereLanguage(Language::EN->value)
                ->firstOrFail();
        } catch (ModelNotFoundException) {
            throw new Exception(__('Word not found'));
        }
    }

    private function storeWord(string $word, int $themeId, string $language, int $sourceId = null): Word
    {
        $attributes = [
            'theme_id' => $themeId,
            'word' => mb_ucfirst($word),
            'language' => $language,
        ];

        if ($sourceId) {
            $attributes['source_word_id'] = $sourceId;
        }

        return Word::updateOrCreate($attributes);
    }

    private function storeExample(string $example, int $wordId, string $language, int $sourceId = null): Example
    {
        $attributes = [
            'word_id' => $wordId,
            'sentence' => mb_ucfirst($example),
            'language' => $language,
        ];

        if ($sourceId) {
            $attributes['source_example_id'] = $sourceId;
        }

        return Example::updateOrCreate($attributes);
    }
}
