<?php
namespace App\JsonOperations;

use App\ArrayOperations\ArrayIterator;

class ReadJsonFile {
    private string
        $path;
    public array
        $jsonArray;


    public function __construct($path)
    {
        $this->path=$path;
        try {
            $this->checkFileExists()
                 ->readJsonFile();
        }
        catch (JsonReaderException $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * @throws JsonReaderException
     */
    public function checkFileExists(): self
    {
        if(!file_exists($this->path)){
            throw new JsonReaderException("File not found");
        }
        return $this;
    }

    function readJsonFile(): self
    {
        $json = file_get_contents($this->path);
        $this->jsonArray = (array)json_decode($json, true);
        return $this;
    }

    /**
     * TODO: Make this class works with sub-levels of JSON array.
     */

    function useSubLevelJsonArray($array): self
    {
        $this->jsonArray = $array;
        return $this;
    }



}