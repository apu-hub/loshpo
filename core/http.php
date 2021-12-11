<?php
class HttpPHP
{
    public $body = [];
    private $params = [];

    function __construct()
    {
        $this->fetch_body();
        $this->fetch_params();
    }
    function send(int $code = 500, string $message = 'Internal Server Error', bool $close = true, $data = null)
    {
        $response = ["code" => $code, "message" => $message];

        if ($data != null) $response = array_merge($response, ["data" => $data]);

        echo json_encode($response);

        if ($close) exit();
    }
    function fetch_body()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        // Add a senitizer
        if ($data != null) $this->body = $data;
    }
    function fetch_params()
    {
    }
}
