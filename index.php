<?php

if (isset($_GET['fp']) || !empty($_GET['fp'])) {
    $filePath = cleanInput($_GET['fp']);
    $stream = new VideoStream($filePath);

    $stream->start();
}

$filter = "folders";
$scanarry = array("");
$scanout = array("");
$scan_ext = array("");

// This Root Path Only Valid For Android Device 
$rootpath = "/storage/emulated/0/";

$scanpath = $rootpath;
$addpath = "";

// if post request made
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // New Path Checker
    if (!empty($_POST["newpath"])) {
        $scanpath = $_POST["newpath"];
    }

    // Filter Checker
    if (!empty($_POST["filter"])) {
        // In case filter was folders
        if ($_POST["filter"] === "folders") {
            $filter = "folders";
            $scan_ext = array("");
        }
        // In case filter was audios
        if ($_POST["filter"] === "audios") {
            $filter = "audios";
            $scan_ext = array("mp3", "wav");
        }
        // In case filter was videos
        if ($_POST["filter"] === "videos") {
            $filter = "videos";
            $scan_ext = array("mp4", "mkv", "webm", "m4v");
        }
    }
} // POST REQUEST CHECKER END

// is directory valid
if (is_dir($scanpath)) {
    $scanarry = scandir($scanpath);
}

foreach ($scanarry as $path) {
    if (in_array(pathinfo($path, PATHINFO_EXTENSION), $scan_ext)) {
        if (!is_dir($path)) {
            $scanout[] = $path;
        }
    }
}

// Get Server IP Address
function getSIP()
{
    $sock = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_connect($sock, "8.8.8.8", 53);
    socket_getsockname($sock, $name);
    return $name;
}

// Get Path For User
function getPFU()
{
    global $scanpath;
    $sub = substr($scanpath, 20, strlen($scanpath));
    return $sub;
}

#################################           HTML            ######################

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="mt.css">
    <style>
        body {
            height: 100vh;
            width: 100vw;
            background-color: aqua;
        }

        .centerall {
            display: flex;
            justify-content: center;
        }

        .fp {
            width: 100vw;
            display: flex;

        }

        #fname {
            width: 80%;
        }

        <?php
        if ($filter === "folders") {
            echo '#foldersbtn { display: none; }';
        } elseif ($filter === "audios") {
            echo '#audiosbtn { display: none; }';
        } elseif ($filter === "videos") {
            echo '#videosbtn { display: none; }';
        }
        ?>
    </style>
    <title>Local Share Point</title>
</head>

<body>
    <h1 class="centerall" id="header"><u><i> Welcome To LoShPo</i></u></h1>
    <div></div>
    <h3 class="centerall" id="ippot">Host IP & PORT : <?php echo getSIP() . ':' . $_SERVER['SERVER_PORT']; ?></h3>
    <div class="centerall">
        <input id="copybtn" type="button" value="How to Use" onclick="showtutorials()">
    </div>
    <h3><i>From</i> : <?php echo getPFU(); ?>/</h3>
    <form action="" method="post">
        <b>Filter : </b><i><?php echo $filter; ?></i>
        <input type="hidden" name="newpath" value="<?php echo $scanpath; ?>">
        <button name="filter" id="foldersbtn" type="submit" value="folders">Folders</button>
        <button name="filter" id="audiosbtn" type="submit" value="audios">Audios</button>
        <button name="filter" id="videosbtn" type="submit" value="videos">Videos</button>
    </form>
    <?php
    foreach ($scanout as $path) {
        if ($path != "") {
            switch ($filter) {
                case "folders":
                    echo '<form action="" method="post">
                    <button type="submit" name="newpath" value="' . $scanpath . $path . '/">' . $path . '</button>
                </form>';;
                    break;
                case "videos":
                    echo '<p>
                <label id="' . $path . '"><b>:: ' . $path . '</b></label>
                <br><a target="steamDiv" id="play" href="?fp=' . $scanpath . $path . '" onclick="sif()"><input type="button" value="Play"></a>
            </p>';;
                    break;
                case "audios":
                    echo '<p>
                <label id="' . $path . '"><b>:: ' . $path . '</b></label>
                < target="steamDiv" id="play" href="?fp=' . $scanpath . $path . '" onclick="sif()"><input type="button" value="Play"></a>
            </p>';;
                    break;
            }
        }
    }
    ?>
    <!-- <iframe id="steamDiv" name="steamDiv" style="display:none;"></iframe> -->
    <p>
        <a href="../"><input type="button" value="HOME"></a>
    </p>
    <script>
        function sif() {
            document.getElementById("steamDiv").style.display = "block";
        }
    </script>
</body>

</html>





<?php




/** * Description of VideoStream * * @author Rana * @link http://codesamplez.com/programming/php-html5-video-streaming-tutorial */ class VideoStream
{
    private $path = "";
    private $stream = "";
    private $buffer = 102400;
    private $start = -1;
    private $end = -1;
    private $size = 0;
    function __construct($filePath)
    {
        $this->path = $filePath;
    }
    /** * Open stream */ private function open()
    {
        if (!($this->stream = fopen($this->path, 'rb'))) {
            die('Could not open stream for reading');
        }
    }
    /** * Set proper header to serve the video content */ private function setHeader()
    {
        ob_get_clean();
        header("Content-Type: video/mp4");
        header("Cache-Control: max-age=2592000, public");
        header("Expires: " . gmdate('D, d M Y H:i:s', time() + 2592000) . ' GMT');
        header("Last-Modified: " . gmdate('D, d M Y H:i:s', @filemtime($this->path)) . ' GMT');
        $this->start = 0;
        $this->size = filesize($this->path);
        $this->end = $this->size - 1;
        header("Accept-Ranges: 0-" . $this->end);
        if (isset($_SERVER['HTTP_RANGE'])) {
            $c_start = $this->start;
            $c_end = $this->end;
            list(, $range) = explode('=', $_SERVER['HTTP_RANGE'], 2);
            if (strpos($range, ',') !== false) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            if ($range == '-') {
                $c_start = $this->size - substr($range, 1);
            } else {
                $range = explode('-', $range);
                $c_start = $range[0];
                $c_end = (isset($range[1]) && is_numeric($range[1])) ? $range[1] : $c_end;
            }
            $c_end = ($c_end > $this->end) ? $this->end : $c_end;
            if ($c_start > $c_end || $c_start > $this->size - 1 || $c_end >= $this->size) {
                header('HTTP/1.1 416 Requested Range Not Satisfiable');
                header("Content-Range: bytes $this->start-$this->end/$this->size");
                exit;
            }
            $this->start = $c_start;
            $this->end = $c_end;
            $length = $this->end - $this->start + 1;
            fseek($this->stream, $this->start);
            header('HTTP/1.1 206 Partial Content');
            header("Content-Length: " . $length);
            header("Content-Range: bytes $this->start-$this->end/" . $this->size);
        } else {
            header("Content-Length: " . $this->size);
        }
    }
    /** * close curretly opened stream */ private function end()
    {
        fclose($this->stream);
        exit;
    }
    /** * perform the streaming of calculated range */ private function stream()
    {
        $i = $this->start;
        set_time_limit(0);
        while (!feof($this->stream) && $i <= $this->end) {
            $bytesToRead = $this->buffer;
            if (($i + $bytesToRead) > $this->end) {
                $bytesToRead = $this->end - $i + 1;
            }
            $data = fread($this->stream, $bytesToRead);
            echo $data;
            flush();
            $i += $bytesToRead;
        }
    }
    /** * Start streaming video content */ function start()
    {
        $this->open();
        $this->setHeader();
        $this->stream();
        $this->end();
    }
}




// cleaner function 
function cleanInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>