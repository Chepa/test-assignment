<?php
namespace App\Services\OxfordDictionaries;

abstract class BasicResult
{
    protected array $result = [];

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    abstract public function get();
}
