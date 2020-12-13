<?php
// Make sure they are on the same network
require_once('../../../../config.inc');
require_once('../../../../filters.inc');
require_once('../../../../functions.inc');
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
        Fixing the network resolved the issue.";
        send_message($slack_hook, $message);
        header("Location: ../../../../resolved.php");
    }else {
        $message = "ID: $id \n
        Checking the network did *not* resolve the issue.";
        send_message($slack_hook, $message);
        header("Location: ../../../../submit_other.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Stream troubleshooting</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" media="screen" href="../../../../css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="../../../../css/screen.css" />
    <link rel="stylesheet" media="screen" href="../../../../css/Nunito.css" />
</head>
<body>
<?php require_once('../../../../alertbar.inc'); ?>
<h1>Audio troubleshooting</h1>
<p>Troubleshooting complete loss of audio</p>
<ol>
    <li>Please make sure that both your TV and your device are on the same wireless network.</li>
    <li>If they are already, please try rebooting your modem/router, then reconnect both devices to the network.</li>
    <li>Once these steps are done, please come back here and try the audio below again.</li>
</ol>
<audio controls>
    <source src="../../../test_file.mp3" type="audio/mpeg">
    Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
</audio>
<form id="issue_type" action="2.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="hear">Were you able to hear the audio above?</label>
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
