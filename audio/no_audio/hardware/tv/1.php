<?php
// General advice
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
        General troubleshooting steps helped.";
        send_message($slack_hook, $message);
        header("Location: ../../../../resolved.php");
    }else {
        $message = "ID: $id \n
        General troubleshooting steps did *not* help..";
        send_message($slack_hook, $message);
        header("Location: ../../software/3.php");
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
<p>Please note that each TV will be different and is therefore very hard for us to create a troubleshooting guide for.
That being said, here are some general tips on some things to check.</p>
<ol>
    <li>Please make sure your TV isn't muted.</li>
    <li>If you have a separate sound system, please make sure that is plugged into power, the TV, and that it is turned on and isn't muted.</li>
    <li>Please make sure that your TV is connected to the internet and can stream from other internet based sources.</li>
    <li>Please make sure that your volume is turned up sufficiently.</li>
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
