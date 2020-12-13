<?php
    // General guidance

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
        Checking for hardware issues solved the problem.";
        send_message($slack_hook, $message);
        header("Location: ../../../../resolved.php");
    }else {
        $message = "ID: $id \n
        Checking for hardware issues did *not* solve the problem.";
        send_message($slack_hook, $message);
        header("Location: ../../software/1.php");
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
<p>We don't have specific guidance for other types of hardware, but here are some general tips to check before moving onto the next step:</p>
<ol>
    <li>Please make sure that all devices necessary to make your system work are plugged in and turned on.</li>
    <li>Try disconnecting and then re-connecting any physical cord connections to make sure they didn't become loose.</li>
    <li>Please make sure nothing on your system's hardware is muted.</li>
    <li>Please make sure that your system's volume is turned up to a reasonable amount.</li>
</ol>
<p>Once you have checked the general tips above, please come back here and try playing the test clip again.</p>
<audio controls>
    <source src="../../../test_file.mp3" type="audio/mpeg">
    Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
</audio>
<form id="issue_type" action="1.php" method="post">
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