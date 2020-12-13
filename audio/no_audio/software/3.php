<?php
// Check for video mute
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

if (isset($_SESSION['browser'])) {
    $browser = $_SESSION['browser'];
}else {
    $browser = '';
}




if (isset($_POST['submitting'])) {
    $hear = filterABC($_POST['hear']);
    if ($hear === "yes") {
        $message = "ID: $id \n
        Unmuting the video resolved the issue..";
        send_message($slack_hook, $message);
        header("Location: ../../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Checking to see if the video was muted did *not* help.";
            send_message($slack_hook, $message);
            header("Location: ../../../submit_other.php");
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
<p>Troubleshooting loss of audio</p>
<p>Ok, let's make sure the the video didn't get muted.</p>
<div id="video_mute">
    <?php if ($browser === 'other') {
        echo '<p><b>Note:</b> Officially we do not support browsers other than Chrome, Firefox, Chromium based Edge, and Safari. We will display the Chrome instructions in case that is able to help at all;
however, you can also go back to the <a href="../../../submit_other.php">General feedback form</a> and submit a general bug report if these instructions do not help.</p>';
    }
    ?>

    <ol>
        <li>Hover over the video and find the speaker icon.  If it has a line through it, click it to unmute the video.</li>
        <img src="../../../images/video_mute_1.png" />
        <li>Hover over the video and then over the speaker icon.  Make sure it is dragged all the way up.</li>
        <img src="../../../images/video_volume_1.png" />
    </ol>
</div>



<form id="issue_type" action="3.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="hear">Did that fix the issue?</label>
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
