<?php

class Explorer
{
    private $scanArray = [];
    private $filterArray = [];
    // private $scanout = array("");

    function scanDirectory(string $scanPath = '')
    {
        if (empty($scanPath)) $scanPath = $_SERVER["DOCUMENT_ROOT"];

        // echo $scanPath . "<br>";
        // is directory valid
        if (is_dir($scanPath)) {
            $this->scanArray = scandir($scanPath);
            return $this->scanArray;
        } else {
            return false;
        }

        // return $scanArray;
        // foreach ($scanarray as $path) {
        //     if (in_array(pathinfo($path, PATHINFO_EXTENSION), $scan_ext)) {
        //         if (!is_dir($path)) {
        //             $scanout[] = $path;
        //         }
        //     }
        // }
    }

    function filterScanArray()
    {
        foreach ($this->scanArray as $path) {
            if (!is_dir($path)) {
                if (file_exists($path)) {
                    array_push($this->filterArray, pathinfo($path));
                } else {
                    $tempArray = pathinfo($path);
                    // array_push(pathinfo($path)$tempArray, ["extension" => "folder"));
                    $tempArray["extension"]="folder";
                    array_push($this->filterArray, $tempArray);
                }
            }
        }
        return $this->filterArray;
    }
}
