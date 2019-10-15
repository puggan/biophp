<?php

namespace App\Traits;

trait JsonModel
{
    private $json_encoding_active = false;
    abstract public function toArray() /*: array*/ ;

    /**
     * Convert DateTime to milliseconds from epoc, for easier js implementation
     */
    public function jsonSerialize(): array
    {
        $this->json_encoding_active = true;
        $values = parent::jsonSerialize();
        $this->json_encoding_active = false;
        return $values;
    }

    protected function serializeDate(\DateTimeInterface $date) {
        if ($this->json_encoding_active) {
            return $date->getTimestamp() * 1000;
        }
        return parent::serializeDate($date);
    }
}
