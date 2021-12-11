<?php
class Auth
{
    function __construct()
    {
    }

    function isHost(): bool
    {
        // echo var_dump($_SERVER["REMOTE_ADDR"]);
        // echo "<br/>";
        // echo var_dump($this->getHostIP());
        // if ($_SERVER["REMOTE_ADDR"] == $this->getHostIP())
        if($_SERVER["REMOTE_ADDR"]=="::1")
            return true;
        else
            return false;
    }
    // Get Host IP Address
    function getHostIP()
    {
        $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
        socket_connect($sock, "8.8.8.8", 53);
        socket_getsockname($sock, $name);
        return $name;
    }
}
