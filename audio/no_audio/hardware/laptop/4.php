<?php
// Check selected device

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
$os = $_SESSION['os'];

if (isset($_POST['submitting'])) {
    $hear = filterABC($_POST['hear']);
    if ($hear === "yes") {
        $message = "ID: $id \n
        The user was able to resolve the issue by selecting the correct output device.";
        send_message($slack_hook, $message);
        header("Location: ../../../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Checking the output device did *not* help.";
            send_message($slack_hook, $message);
            header("Location: 5.php");
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
    <link rel="stylesheet" media="screen" href="../../../../css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="../../../../css/screen.css" />
    <link rel="stylesheet" media="screen" href="../../../../css/Nunito.css" />
</head>
<body>
<?php require_once('../../../../alertbar.inc'); ?>
<h1>Audio troubleshooting</h1>
<p>Troubleshooting complete loss of audio</p>
    <p>Next, let's check to make sure the correct audio device is selected.</p>
    <div id="windows" class="<?php if ($os !== 'windows') { echo 'hidden'; } ?>">
        <ol>
            <li>Right click the speaker icon in your system tray.</li>
            <img src="../../../../images/device_selection/windows.1.png" />
            <li>Click "Open Sound Settings"</li>
            <img src="../../../../images/device_selection/windows.2.png" />
            <li>Click the dropdown under "Choose your output device"</li>
            <img src="../../../../images/device_selection/windows.3.png" />
            <li>Make sure the correct device is selected there.</li>
            <img src="../../../../images/device_selection/windows.4.png" />
        </ol>
    </div>
    <div id="mac" class="<?php if ($os !== 'mac') { echo 'hidden'; } ?>">
        <ol>
            <li>Open your system preferences</li>
            <img src="../../../../images/device_selection/mac_1.png" />
            <li>Open your sound settings</li>
            <img src="../../../../images/device_selection/mac_2.png" />
            <li>Select the "Output" tab</li>
            <img src="../../../../images/device_selection/mac_3.png" />
            <li>Ensure the correct device is selected</li>
            <img src="../../../../images/device_selection/mac_4.png" />
        </ol>
    </div>
    <div id="chromebook" class="<?php if ($os !== 'chromebook') {echo 'hidden'; } ?>">
        <ol>
            <li>Click your system tray</li>
            <img src="../../../../images/device_selection/chromebook_1.png" />
            <li>Click the arrow button to the right of the volume bar to access the audio settings.</li>
            <img src="../../../../images/device_selection/chromebook_2.png" />
            <li>Make sure the correct device is selected under "Output".</li>
            <img src="../../../../images/device_selection/chromebook_3.png" />
        </ol>

    </div>
    <div id="nix" class="<?php if ($os !== 'linux') { echo 'hidden'; } ?>">
        <p><b>Note:</b> The GNU/Linux instructions were created on PureOS (a Debian variant). It is assumed that if you are running GNU/Linux, you should have the
            skill-level necessary to use these instructions as a general guide and adjust to any GUI differences on your own.</p>
        <ol>
            <li>Start by clicking the dropdown in your system menu at the top left.</li>
            <img src="../../../../images/device_selection/gnulinux_1.png" />
            <li>Click your settings icon</li>
            <img src="../../../../images/device_selection/gnulinux_2.png" />
            <li>Go to the "Sound" tab.</li>
            <img src="../../../../images/device_selection/gnulinux_3.png" />
            <li>Make sure the correct device is selected under "Output".</li>
            <img src="../../../../images/device_selection/gnulinux_4.png" />
        </ol>
    </div>
    <p>Once you have ensured the correct device is selected, please try to play the audio below again.</p>
    <audio controls>
        <source src="../../../test_file.mp3" type="audio/mpeg">
        Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
    </audio>
    <form id="issue_type" action="4.php" method="post">
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
