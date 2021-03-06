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
<p>Ok, let's check the system volume.</p>
<div id="windows" class="<?php if ($os !== 'windows') { echo 'hidden'; } ?>">
    <ol>
        <li>Start by clicking the speaker icon in your system tray.</li>
        <img src="../../../images/system_mute/windows.1.png" />
        <li>Drag the volume bar up or down to your preference.</li>
        <img src="../../../images/system_mute/windows.3.png" />
        <li>Once the volume setting is set, right-click the sound icon in the tray again.</li>
        <img src="../../../images/system_mute/windows.1.png" />
        <li>Click "Open volume mixer"</li>
        <img src="../../../images/system_mute/windows.4.png" />
        <li>Make sure that your browser is all the way up and isn't muted.  For instance, here we can see that Firefox is all the way up, but is muted.  Click the mute icon to unmute and/or drag the slider all the way up.</li>
        <img src="../../../images/system_mute/windows.5.png" />
    </ol>
</div>
<div id="mac" class="<?php if ($os !== 'mac') { echo 'hidden'; } ?>">
    <ol>
        <li>Open your system preferences</li>
        <img src="../../../images/system_mute/mac_1.png" />
        <li>Open your sound settings</li>
        <img src="../../../images/system_mute/mac_2.png" />
        <li>Adjust the volume slider as desired</li>
        <li>(Optional) Add the volume icon to your top menu bar to make it easier to access later</li>
        <img src="../../../images/system_mute/mac_3.png" />
    </ol>
</div>
<div id="chromebook" class="<?php if ($os !== 'chromebook') {echo 'hidden'; } ?>">
    <ol>
        <li>Click your system tray</li>
        <img src="../../../images/system_mute/chromebook_1.png" />
        <li>Adjust your volume slider as desired.</li>
        <img src="../../../images/system_mute/chromebook_2.png" />
    </ol>
</div>
<div id="nix" class="<?php if ($os !== 'linux') { echo 'hidden'; } ?>">
    <p><b>Note:</b> The GNU/Linux instructions were created on PureOS (a Debian variant). It is assumed that if you are running GNU/Linux, you should have the
        skill-level necessary to use these instructions as a general guide and adjust to any GUI differences on your own.</p>
    <ol>
        <li>Start by clicking the dropdown in your system menu at the top left.</li>
        <img src="../../../images/system_mute/gnulinux_1.png" />
        <li>Adjust the volume slider as desired.</li>
        <img src="../../../images/system_mute/gnulinux_2.png" />
    </ol>
</div>
<p>Once you have ensured that your system volume is set correctly, please try to play the audio below or the livestream video again.</p>
<audio controls>
    <source src="../../test_file.mp3" type="audio/mpeg">
    Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
</audio>
<form id="issue_type" action="2.php" method="post">
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
