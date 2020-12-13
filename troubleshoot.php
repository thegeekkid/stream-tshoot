<?php
require_once('config.inc');
if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (isset($_POST['submitting'])) {
    require_once('filters.inc');
    require_once('functions.inc');


    if (isset($_SESSION['id'])) {
        $id = filterABC($_SESSION['id']);
    }else {
        $id = filterABC(generate_id($adjectives, $nouns));
    }

    if (isset($_POST['issues'])) {
        $issue = filterABC($_POST['issues']);
    }else {
        header("Location: submit_other.html");
    }

    if (($issue === "buffering") || ($issue === "audio") || ($issue === "video") || ($issue === "no_load") || ($issue === "other")) {
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $message = "New troubleshooting session:\n\n
        ID: $id
        User agent: $ua
        Issue: $issue";

        send_message($slack_hook, $message);

        if ($issue === "buffering") {
            header('Location: buffering\speedtest.html');
        }else {
            if ($issue === "audio") {
                header('Location: audio\1.php');
            }else {
                if ($issue === "video") {
                    header('Location: video\1.php');
                }else {
                    if ($issue === "no_load") {
                        header('Location: loading\1.php');
                    }else {
                        header("Location: submit_other.html");
                    }
                }
            }
        }
    }else {
        header("Location: submit_other.html");
    }





}

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Stream troubleshooting</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" media="screen" href="css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="css/screen.css" />
    <link rel="stylesheet" media="screen" href="css/Nunito.css" />
</head>
<body>
<?php require_once('alertbar.inc'); ?>
<h1>Please select the types of issues you are experiencing:</h1>
<p>(Note: your responses in this tool will be anonymously sent back to the broadcast engineer in real time to aid in quickly identifying any issues on their end.)</p>
<form id="troubleshoot_start" action="troubleshoot.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="issues">Please select from the following options:</label>
    <select id="issues" name="issues">
        <option value="buffering">The video and/or audio is freezing/buffering or starting and stopping</option>
        <option value="audio">I am having issues with the audio</option>
        <option value="video">I am having issues with the video</option>
        <option value="no_load">I can't get the page or video to load at all</option>
        <option value="other">It's something other than any of the options listed above</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>
