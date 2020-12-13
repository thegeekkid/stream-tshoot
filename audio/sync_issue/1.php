<?php
// Check if audio here is in sync
require_once('../../config.inc');
require_once('../../filters.inc');
require_once('../../functions.inc');
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
    $hear = filterABC($_POST['hear']);

    if ($hear === "yes") {
        $message = "ID: $id \n
        Sync test results: The test video was in sync.";
        send_message($slack_hook, $message);
        header("Location: working_on_it.html");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Sync test results: The test video was *not* in sync.";
            send_message($slack_hook, $message);
            header("Location: 2.php");
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
    <link rel="stylesheet" media="screen" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="../../css/screen.css" />
    <link rel="stylesheet" media="screen" href="../../css/Nunito.css" />
</head>
<body>
<?php require_once('../../alertbar.inc'); ?>
<h1>Audio troubleshooting</h1>
<p>Troubleshooting audio sync issue</p>
<p>Sorry about that!  It's probably an issue on our end, but just to double check; if you play the video below, does the red dot in the video below appear on the audible ticks?</p>
<iframe width="560" height="315" src="https://www.youtube.com/embed/ucZl6vQ_8Uo?start=3" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<form id="issue_type" action="1.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="hear">Was the audio above in sync?</label>
    <select id="hear" name="hear">
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>
