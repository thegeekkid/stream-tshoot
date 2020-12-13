<?php
// Classify audio issues

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

        if (($issue === "No_audio") || ($issue === "Soft") || ($issue === "Loud") || ($issue === "Distorted") || ($issue === "Out_of_sync") || ($issue === "Other")) {
            $message = "ID: $id \n
        Audio issue detail: $issue";
            $stat = send_message($slack_hook, $message);

            if ($issue === "No_audio") {
                header("Location: no_audio/1.php");
            }else {
                if (($issue === "Soft") || ($issue === "Loud")) {
                    header("Location: volume_issues/1.php");
                }else {
                        if ($issue === "Distorted") {
                            header("Location: distorted_audio/1.php");
                        }else {
                            if ($issue === "Out_of_sync") {
                                header("Location: sync_issue/1.php");
                            }else {
                                header("Location: ../submit_other.php");
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
<h1>Audio troubleshooting</h1>
    <form id="issue_type" action="1.php" method="post">
        <input type="hidden" id="submitting" name="submitting" value="true" />
        <label for="issue">Ok, let's dig a bit deeper.  What type of audio issues are you experiencing?</label>
        <select id="issue" name="issue">
            <option value="No_audio">No audio at all</option>
            <option value="Soft">Very soft audio</option>
            <option value="Loud">Very loud audio</option>
            <option value="Distorted">Distorted audio</option>
            <option value="Out_of_sync">Out of sync with video</option>
            <option value="Other">It's something else altogether</option>
        </select>
        <input type="submit" value="Next Step" class="btn btn-success" />
    </form>
<br />
<br />
</body>
</html>
