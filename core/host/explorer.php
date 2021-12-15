<?php

class Explorer
{
    private $scanArray = [];
    private $filterArray = [];
    private $scanPath = '';

    function scanDirectory(string $scanPath = '')
    {
        // fetch data
        $data = getData();
        // is path available 
        // data.json path available
        if (empty($scanPath))
            if ($data->explorer->currentPath == '')
                $this->scanPath = $_SERVER["DOCUMENT_ROOT"];
            else
                $this->scanPath = $data->explorer->currentPath;
        else
            $this->scanPath = $scanPath;

        // is directory valid
        if (is_dir($this->scanPath)) {
            $this->scanArray = scandir($this->scanPath);
            // update new scan path
            $data->explorer->currentPath = $this->scanPath;
            setData($data);

            return $this->getScanArray();
        } else {
            return false;
        }
    }
    function getScanArray()
    {
        return $this->scanArray;
    }
    function getScanPath()
    {
        $data = getData();
        $this->scanPath = $data->explorer->currentPath;
        return $this->scanPath;
    }

    function getFilterScanArray()
    {
        return $this->filterArray;
    }
    function filterScanArray()
    {
        $tempArray = [];
        $num = count($this->scanArray);
        // check all path
        for ($i = 2; $i < $num; $i++) {
            // store path info in a temp array
            $tempArray = pathinfo($this->scanArray[$i]);
            $tempArray["dirname"] = $this->scanPath . "\\" . $this->scanArray[$i];

            // check is folder or file
            if (!is_file($this->scanPath . "\\" . $this->scanArray[$i]))
                $tempArray["extension"] = "folder";
            array_push($this->filterArray, $tempArray);
        }

        return $this->getFilterScanArray();
    }
}

function getData()
{
    return json_decode(file_get_contents(__DIR__ . "/./data.json"));
}
function setData($data)
{
    file_put_contents(__DIR__ . "/./data.json", json_encode($data));
}
