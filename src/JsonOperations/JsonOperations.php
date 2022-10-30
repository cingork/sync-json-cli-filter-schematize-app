<?php
namespace App\JsonOperations;

use App\ArrayOperations\ArrayIterator;

class JsonOperations {
    public ReadJsonFile
        $jsonReader;

    public array
        $filterParams= [],
        $jsonKeys= [];

    public function __construct(ReadJsonFile $jsonArray)
    {
        $this->jsonReader= $jsonArray;
    }

    public function setFilterParams($filterParams):self
    {
        $this->filterParams=$filterParams;
        return $this;
    }

    public function operateJson($type) : void
    {
        $iterateArray = new ArrayIterator($this->jsonReader->jsonArray);
        while ($iterateArray->valid()){
            switch ($type) {
                case "keys":
                    $this->getDistinctArrayKeys($iterateArray);
                    break;
                case "schematize":
                    $this->schematizeJsonArray($iterateArray);
                    break;
                case "applyFilter":
                    $this->filterArray($iterateArray);
            }
            $iterateArray->next();
        }
    }

    private function getDistinctArrayKeys(ArrayIterator $iterator): self
    {
        $this->jsonKeys= array_merge($this->jsonKeys,array_diff(array_keys($iterator->current()),$this->jsonKeys));
        return $this;
    }

    private function schematizeJsonArray(ArrayIterator $iterator): self
    {
        if(empty($this->jsonKeys))
            $this->operateJson("keys");
        foreach($this->jsonKeys as $key)
        {
            if(!array_key_exists($key,$iterator->current()))
            {
                $this->jsonReader->jsonArray[$iterator->key()]=array_merge($iterator->current(),[$key => "NULL"]);
            }

        }
        return $this;
    }

    private function filterArray(ArrayIterator $iterator): self
    {
        if(!isset($iterator->current()[$this->filterParams[0]]) || $iterator->current()[$this->filterParams[0]]<$this->filterParams[1] || (isset($this->filterParams[2]) && $iterator->current()[$this->filterParams[0]]>$this->filterParams[2] ))
            unset($this->jsonReader->jsonArray[$iterator->key()]);
        return $this;
    }

}