<?php

namespace App\Services\OxfordDictionaries;

class TranslatorParser extends BasicResult
{
    protected array $translations = [];

    protected array $examples = [];

    /**
     * Get the translation from result
     *
     * @return array
     */
    public function get(): array
    {
        if (! $this->isEmptyTranslation()) {
            return $this->translations;
        }

        $senses = $this->result[0]
            ->lexicalEntries[0]
            ->entries[0]
            ->senses;
        $words = [];

        foreach ($senses as $sens) {
            if (property_exists($sens, 'subsenses')) {
                foreach ($sens->subsenses as $subsense) {
                    if (property_exists($subsense, 'translations')) {
                        foreach ($subsense->translations as $translation) {
                            $words[] = $translation->text;
                        }
                    }
                }
            }

            if (property_exists($sens, 'translations')) {
                foreach ($sens->translations as $translation) {
                    $words[] = $translation->text;
                }
            }
        }
        return ($this->translations = array_unique($words));
    }

    /**
     * Get examples from result
     *
     * @return array
     */
    public function getExamples(): array
    {
        if (! $this->isEmptyExample()) {
            return $this->examples;
        }
        $senses = $this->result[0]
            ->lexicalEntries[0]
            ->entries[0]
            ->senses;
        $examples = [];

        foreach ($senses as $sens) {
            if (property_exists($sens, 'examples')) {
                foreach ($sens->examples as $example) {
                    $examples[$example->text] = [];
                    foreach ($example->translations as $translation) {
                        $examples[$example->text][] = $translation->text;
                    }
                }
            }
        }
        return ($this->examples = $examples);
    }

    /**
     * Check if the array of translations is empty
     *
     * @return bool
     */
    protected function isEmptyTranslation(): bool
    {
        return count($this->translations) == 0;
    }

    /**
     * Check if the array of examples is empty
     *
     * @return bool
     */
    protected function isEmptyExample(): bool
    {
        return count($this->examples) == 0;
    }
}
