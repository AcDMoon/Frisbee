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
        $receivedData = DB::request('get', $this); //массивы с данными объекта
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
        if (count($objectsInfo) === 1) {
            return $objectsInfo[0];
        }
        return $objectsInfo;

    }


    public function deleteObject()
    {
        DB::request('delete', $this);
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
        DB::request('update', $this, $keyFiled);
    }


    public function addInfo()
    {
        DB::request('add', $this);
    }
}
