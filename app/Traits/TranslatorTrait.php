<?php
namespace App\Traits;

use App\Exceptions\TranslateException;
use App\Services\OxfordDictionaries\TranslatorParser;
use Exception;
use Illuminate\Support\Facades\Storage;
use Throwable;

trait TranslatorTrait
{
    protected ?string $from;

    protected ?string $to;

    /**
     * Source language
     *
     * @param $from
     * @return $this
     */
    public function from($from): static
    {
        $this->from = $from;
        return $this;
    }

    /**
     * Target language
     *
     * @param $to
     * @return $this
     */
    public function to($to): static
    {
        $this->to = $to;
        return $this;
    }

    /**
     * Reset translator
     */
    protected function resetTranslator(): void
    {
        $this->from = null;
        $this->to = null;
        $this->reset();
    }

    /**
     * Translate
     *
     * @return TranslatorParser
     * @throws TranslateException
     */
    public function translate(): TranslatorParser
    {
        try {
            $response = $this->getStoredResponse();

            if ($response) {
                return new TranslatorParser(json_decode($response)->results);
            }

            $this->result = $this->client->get(
                "{$this->base}/translations/{$this->from}/{$this->to}/{$this->word}?strictMatch=false"
            );

            if ($this->result->getStatusCode() == 200) {
                $content = $this->result->getBody()->getContents();
                $this->storeResponse($content);
                $this->resetTranslator();

                return (
                    new TranslatorParser(json_decode($content)->results)
                );
            }

            throw new Exception('An error occurred', 500);
        } catch (Throwable $e) {
            throw new TranslateException($e->getCode());
        }
    }

    private function getStoredResponse(): string
    {
        $filePath = storage_path('app/responses') . strtolower("/translations-$this->from-$this->to-$this->word.json");

        if (file_exists($filePath)) {
            return file_get_contents($filePath);
        }

        return '';
    }

    private function storeResponse($content): bool|string
    {
        return Storage::put(strtolower("responses/translations-$this->from-$this->to-$this->word.json"), $content);
    }
}
