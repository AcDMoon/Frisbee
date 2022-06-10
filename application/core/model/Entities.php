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
        $RequestProcessor = new RequestProcessor($this);
        $receivedData = $RequestProcessor->getProcessor();
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
        $RequestProcessor = new RequestProcessor($this);
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
        $RequestProcessor = new RequestProcessor($this, $keyFiled);
        $RequestProcessor->updateProcessor();
    }


    public function addInfo()
    {
        $RequestProcessor = new RequestProcessor($this);
        $RequestProcessor->addProcessor();
    }
}
