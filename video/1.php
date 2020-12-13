<?php
// Classify video issues

require_once('../config.inc');
require_once('../filters.inc');
require_once('../functions.inc');
if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (isset($_SESSION['id'])) {
    $id = filterABC($_SESSION['id']);
}else {
    $id = filterABC(generate_id($adjectives, $nouns));
}

if (isset($_POST['submitting'])) {
    if (isset($_POST['issue'])) {
        $issue = filterABC($_POST['issue']);

        if (($issue === "No_video") || ($issue === "overexposed") || ($issue === "underexposed") || ($issue === "focus") || ($issue === "Out_of_sync") || ($issue === "audio") || ($issue === "doesnt_load") || ($issue === "buffering") || $issue === "other") {
            $message = "ID: $id \n
        Video issue detail: $issue";
            $stat = send_message($slack_hook, $message);

            if ($issue === "No_video") {
                header("Location: ../loading/1.php");
            }else {
                if (($issue === "overexposed") || ($issue === "underexposed") || ($issue === "focus")) {
                    header("Location: feedback_noted.html");
                }else {
                    if ($issue === "audio") {
                        header("Location: ../audio/1.php");
                    }else {
                        if ($issue === "Out_of_sync") {
                            header("Location: ../audio/sync_issue/1.php");
                        }else {
                            if ($issue === "doesnt_load") {
                                header("Location: ../loading/1.php");
                            }else {
                                if ($issue === "buffering") {
                                    header("Location: ../buffering/1.php");
                                }else {
                                    header("Location: ../submit_other.php");
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}


?>


<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Stream troubleshooting</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="../css/screen.css" />
    <link rel="stylesheet" media="screen" href="../css/Nunito.css" />
</head>
<body>
<?php require_once('../alertbar.inc'); ?>
<h1>Video troubleshooting</h1>
<form id="issue_type" action="1.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="issue">Ok, let's dig a bit deeper.  What type of video issues are you experiencing?</label>
    <select id="issue" name="issue">
        <option value="No_video">No video at all/video freezes (but audio plays fine)</option>
        <option value="overexposed">Video is too bright (overexposed)</option>
        <option value="underexposed">Video is too dark (underexposed)</option>
        <option value="focus">Video is out of focus</option>
        <option value="Out_of_sync">Out of sync with audio</option>
        <option value="audio">There's another issue with the audio</option>
        <option value="doesnt_load">It doesn't load the video (or audio)</option>
        <option value="buffering">It starts and stops a lot with a spinning circle</option>
        <option value="Other">It's something else altogether</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>
