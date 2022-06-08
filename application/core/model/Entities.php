<?php

namespace Frisbee\core\model;

abstract class Entities
{
    public function __construct($data)
    {
        foreach ($data as $field => $value) {
            $this->$field = $value;
        }
    }


    public function getInfo(array $attributes = []): array
    {
        $receivedData = newDB::request('get', $this); //массивы с данными объекта
        if ([] === $attributes) {
            return $receivedData;
        }
        $objectsInfo = [];
        foreach ($receivedData as $object) {
            $objectInfo = [];
            foreach ($attributes as $attribute) {
                $objectInfo[] = $object[$attribute];
            }
            $objectsInfo[] = $objectInfo;
        }
        return $objectsInfo;
    }


    public function deleteObject()
    {
        newDB::request('delete', $this);
    }


    public function updateObject()
    {
        $keyFiled = '';
        foreach ($this->uniqueFields as $uniqueField) {
            if (isset($this->$uniqueField)) {
                $keyFiled = $uniqueField;
                break;
            }
        }
        newDB::request('update', $this, $keyFiled);
    }


    public function addInfo()
    {
        newDB::request('add', $this);
    }
}
