<?php
// Check to see if the tab got muted
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

$browser = $_SESSION['browser'];
if ($browser === "safari") {
    header("Location: 3.php");
}

if (isset($_POST['submitting'])) {
    $hear = filterABC($_POST['hear']);
    if ($hear === "yes") {
        $message = "ID: $id \n
        Unmuting the browser tab resolved the issue..";
        send_message($slack_hook, $message);
        header("Location: ../../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Checking to see if the browser tab was muted did *not* help.";
            send_message($slack_hook, $message);
            header("Location: 3.php");
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
<p>Ok, let's make sure the the tab didn't get muted.</p>
<div id="chrome" class="<?php if (($browser !== 'chrome') && ($browser !== 'other')) { echo 'hidden'; } ?>">
    <?php if ($browser === 'other') {
      echo '<p><b>Note:</b> Officially we do not support browsers other than Chrome, Firefox, Chromium based Edge, and Safari. We will display the Chrome instructions in case that is able to help at all;
however, you can also go back to the <a href="../../../submit_other.php">General feedback form</a> and submit a general bug report if these instructions do not help.</p>';
    }
    ?>
    <ol>
        <li>Right click the tab containing the live stream.</li>
        <img src="../../../images/tab_mute/chrome_1.png" />
        <li>If the option is available, select "Unmute site" (do not select "Mute site"!)</li>
        <img src="../../../images/tab_mute/chrome_2.png" />
    </ol>
</div>
<div id="firefox" class="<?php if ($browser !== 'firefox') { echo 'hidden'; } ?>">
    <ol>
        <li>Right click the tab containing the live stream.</li>
        <img src="../../../images/tab_mute/firefox_1.png" />
        <li>If the option is available, select "Unmute tab" (do not select "Mute tab"!)</li>
        <img src="../../../images/tab_mute/firefox_2.png" />
    </ol>
</div>
<div id="edge" class="<?php if ($browser !== 'edge') {echo 'hidden'; } ?>">
    <ol>
        <li>Right click the tab containing the live stream.</li>
        <img src="../../../images/tab_mute/edge_1.png" />
        <li>If the option is available, select "Unmute tab" (do not select "Mute tab"!)</li>
        <img src="../../../images/tab_mute/edge_2.png" />
    </ol>

</div>


<form id="issue_type" action="2.php" method="post">
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
