<?php
// Try local embed
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
        Test embed from YouTube worked correctly.";
        send_message($slack_hook, $message);

    }else {
        $message = "ID: $id \n
        Test embed from YouTube *did not* work correctly.";
        send_message($slack_hook, $message);

    }
    if ($backup_url !== "") {
        $message = "Sending user to the backup link.";
        header("Location: 6.php");
    }else {
        $message = "No backup link configured.  Sending user to general feedback form.";
        header("Location: ../../submit_other.php");
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
<h1>Page/video load troubleshooting</h1>
<p>Please check the video below and see if it plays correctly.</p>
<iframe width="560" height="315" src="https://www.youtube.com/embed/nfq66XQhyRE?start=1153" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
<form id="issue_type" action="5.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="hear">Did the video above play correctly?</label>
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