<?php

namespace App\Traits;
global $json_model_encoding_active;

trait JsonModel
{
    abstract public function toArray() /*: array*/ ;

    /**
     * Convert DateTime to milliseconds from epoc, for easier js implementation
     */
    public function jsonSerialize(): array
    {
        global $json_model_encoding_active;
        $json_model_encoding_active = true;
        $values = parent::jsonSerialize();
        $json_model_encoding_active = false;
        return $values;
    }

    protected function serializeDate(\DateTimeInterface $date) {
        global $json_model_encoding_active;
        if ($json_model_encoding_active) {
            return $date->getTimestamp() * 1000;
        }
        return parent::serializeDate($date);
    }
}
