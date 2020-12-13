<?php
// Check for system volume

require_once('../../../config.inc');
require_once('../../../filters.inc');
require_once('../../../functions.inc');
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
$os = $_SESSION['os'];

if (isset($_POST['submitting'])) {
    $hear = filterABC($_POST['hear']);
    if ($hear === "yes") {
        $message = "ID: $id \n
        Adjusting the system audio resolved the issue.";
        send_message($slack_hook, $message);
        header("Location: ../../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Adjusting the system audio did *not* help.";
            send_message($slack_hook, $message);
            header("Location: ../end_of_script.html");
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
    <link rel="stylesheet" media="screen" href="../../../css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="../../../css/screen.css" />
    <link rel="stylesheet" media="screen" href="../../../css/Nunito.css" />
</head>
<body>
<?php require_once('../../../alertbar.inc'); ?>
<h1>Audio troubleshooting</h1>
<p>Troubleshooting volume issues</p>
<p>We don't have a troubleshooting script pre-made for other devices; but the fact that the issue occurred with the test audio
indicates that the issue might be with your system.  We would recommend looking for any volume adjustments you can find to see if
there might be any you missed - including on any external audio systems if your audio system is separate from the stream source device.</p>
<p>Once you have ensured that your system volume is set correctly, please try to play the audio below or the livestream video again.</p>
<audio controls>
    <source src="../../test_file.mp3" type="audio/mpeg">
    Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
</audio>
<form id="issue_type" action="1.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="hear">Was the volume better this time?</label>
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
