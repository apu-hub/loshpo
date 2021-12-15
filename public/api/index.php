<?php

require __DIR__ . '/../../core/auth/index.php';
require __DIR__ . '/../../core/http.php';

$auth = new Auth();
$httpPHP = new HttpPHP();

$request = $_SERVER['REQUEST_URI'];

// Only Host Router
if ($auth->isHost()) {
    require_once __DIR__ . '/../../core/host/index.php';
    $explorer = new Explorer();
    switch ($request) {
        case "/api/":
            // add all api details
            echo "<pre>" . file_get_contents(__DIR__ . "/./apinfo.json") . "</pre>";
            break;
        case "/api":
            echo "<pre>" . file_get_contents(__DIR__ . "/./apinfo.json") . "</pre>";
            break;
        case "/api/upOneLevel":
            // creating new path
            $newPath = dirname($explorer->getScanPath());

            // scan and filter
            $explorer->scanDirectory($newPath);
            $explorer->filterScanArray();

            $data = array(
                "currentPath" => $explorer->getScanPath(),
                "scanData" => $explorer->getFilterScanArray()

            );

            $httpPHP->send(200, "Scan Directory Successfully", true, $data);
            break;
        case "/api/scanDirectory":
            $newPath = "";
            $body = $httpPHP->fetch_body();

            // check for new path
            //? "/" work on other os
            if (isset($body["newDirectory"]) && !empty($body["newDirectory"]))
                $newPath = trim($explorer->getScanPath()) . "/" . trim($body["newDirectory"]);

            // scan and filter
            $explorer->scanDirectory($newPath);
            $explorer->filterScanArray();

            $data = array(
                "currentPath" => $explorer->getScanPath(),
                "scanData" => $explorer->getFilterScanArray()
            );

            $httpPHP->send(200, "Scan Directory Successfully", true, $data);
            break;
        default:
            $httpPHP->send(404, "Not Found");
            break;
    }
}
// Client Router
switch ($request) {
    case '/api/getfiles/':
        $httpPHP->send(200, "Retrive Files");
        break;
    default:
        $httpPHP->send(404, "Not Found");
        break;
}
