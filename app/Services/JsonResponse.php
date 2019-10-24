<?php

namespace App\Services;

class JsonResponse implements \JsonSerializable
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize()
    {
        return $this->data;
    }

    public function __get($name)
    {
        return $this->data->$name;
    }

    public function __isset($name)
    {
        return isset($this->data->$name);
    }

    public function __set($name, $value)
    {
        $this->data->$name = $value;
    }
}
