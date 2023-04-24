<?php
namespace App\Services\OxfordDictionaries;

use App\Traits\TranslatorTrait;
use GuzzleHttp\Client;

class OxfordWrapper
{
    use TranslatorTrait;

    protected Client $client;

    protected ?string $word;

    protected string $base = 'api/v2';

    protected $result;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * The word to look for
     *
     * @param $word
     * @return $this
     */
    public function lookFor($word): static
    {
        $this->word = $word;
        return $this;
    }

    /**
     * Reset the parameters
     */
    protected function reset(): void
    {
        $this->word = null;
    }
}
