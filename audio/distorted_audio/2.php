<?php
// Check if audio is clipping the output device
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
        The test audio was still distorted after turning the volume down.";
        send_message($slack_hook, $message);
        header("Location: 3.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Turning the audio down did resolve the distortion..";
            send_message($slack_hook, $message);
            header("Location: ../../resolved.php");
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
<p>Troubleshooting audio distortion</p>
<p>If that clip is distorted as well, that indicates the issue may be on your end.</p>
<p>Let's start with a common source of distortion: clipping.  This occurs when the source signal is too loud for the physical or digital limits
of the device and causes the device to "clip" off the peaks of the audio.  The easiest way to fix this is to turn down the volume.</p>
<p>After you turn down the volume a bit, try the audio again and see if it is still distorted.</p>
<audio controls>
    <source src="../test_file.mp3" type="audio/mpeg">
    Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
</audio>
<form id="issue_type" action="1.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="hear">Was the audio above still distorted?</label>
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
