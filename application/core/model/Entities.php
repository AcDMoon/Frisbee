<?php

namespace Frisbee\core\model;

abstract class Entities
{
    public function __construct($data)
    {
        foreach ($data as $field => $value) {
            $value = self::remakeTheValueToProtectFromInjections($value);
            $this->$field = $value;
        }
    }

    private static function remakeTheValueToProtectFromInjections($value)
    {
        $value = str_replace("&", '&#38;', $value);
        $value = str_replace(':', '&#58;', $value);
        $value = str_replace('"', '&quot;', $value);
        $value = str_replace("'", '&#39;', $value);
        $value = str_replace('<', '&lt;', $value);
        return str_replace('>', '&gt;', $value);
    }


    public function getData(array $attributes = []): array
    {
        $RequestProcessor = new RequestProcessor($this, $this->tableName);
        $receivedData = $RequestProcessor->getProcessor();
        if ([] === $attributes) {
            return $receivedData;
        }
        $objectsData = [];
        foreach ($receivedData as $object) {
            $objectData = [];
            foreach ($attributes as $attribute) {
                $objectData[] = $object[$attribute];
            }
            $objectsData[] = $objectData;
        }
        if (count($objectsData) === 1) {
            return $objectsData[0];
        }
        return $objectsData;
    }


    public function deleteObject()
    {
        $RequestProcessor = new RequestProcessor($this, $this->tableName);
        $RequestProcessor->deleteProcessor();
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
        $RequestProcessor = new RequestProcessor($this, $this->tableName, $keyFiled);
        $RequestProcessor->updateProcessor();
    }


    public function addData()
    {
        $RequestProcessor = new RequestProcessor($this, $this->tableName);
        $RequestProcessor->addProcessor();
    }
}
