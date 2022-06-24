<?php

namespace Frisbee\core\model;

class RequestProcessor
{
    private $attributes = [];
    private $attributesValue = [];
    private $tableName;
    private $keyField;


    public function __construct(object $object, string $keyField = '')
    {
        if ($keyField) {
            $this->keyField = [$keyField => $object->$keyField];
        }
        $array = explode('\\', get_class($object));
        $this->tableName = $array[count($array) - 1];

        $this->attributes = array_keys(get_object_vars($object));
        $this->attributesValue = array_values(get_object_vars($object));
    }


    public function addProcessor(): void
    {
        DB::add($this->tableName, $this->attributes, $this->attributesValue);
    }


    public function getProcessor(): array
    {
        if (!isset($this->attributes[0])) {
            $this->attributes[0] = '';
            $this->attributesValue[0] = '';
        }
        return DB::get($this->tableName, $this->attributes[0], $this->attributesValue[0]);
    }


    public function updateProcessor(string $keyField = ''): void
    {
        DB::update($this->tableName, $this->attributes, $this->attributesValue, $this->keyField);
    }


    public function deleteProcessor(): void
    {
        DB::delete($this->tableName, $this->attributes, $this->attributesValue);
    }
}
