<?php
// Check bluetooth connection
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
        The user was able to resolve the issue by connecting their device to Bluetooth.";
        send_message($slack_hook, $message);
        header("Location: ../../../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Checking the Bluetooth connection did *not* help.";
            send_message($slack_hook, $message);
            header("Location: 4.php");
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
<ol>
    <li>Please make sure the speakers or headphones are turned on, turned up, and have a charged battery.</li>
    <li>After that, please make sure the speakers or headphones are connected to your computer.  To do that:</li>
    <div id="windows" class="<?php if ($os !== 'windows') { echo 'hidden'; } ?>">
        <ol>
            <li>Click the expand arrow on your task bar.</li>
            <img src="../../../../images/bluetooth/windows_1.png" alt="The expand arrow should be at the left end of the panel that contains your system clock." />
            <li>Right-click the Bluetooth icon.</li>
            <img src="../../../../images/bluetooth/windows_2.png" />
            <li>Click "Show Bluetooth Devices"</li>
            <img src="../../../../images/bluetooth/windows_3.png" />
            <li>Make sure that your headphones or speakers say "Connected" and "music".  They may also say "voice", but they need to say "music" to work correctly for streaming.</li>
            <img src="../../../../images/bluetooth/windows_4.png" />
            <li>If they aren't already connected, click "Connect"</li>
            <img src="../../../../images/bluetooth/windows_5.png" />
        </ol>

    </div>
    <div id="fruitcake" class="<?php if ($os !== 'mac') { echo 'hidden'; } ?>">
        <ol>
            <li>Open your system preferences</li>
            <img src="../../../../images/bluetooth/mac_1.png" />
            <li>Go to your Bluetooth settings</li>
            <img src="../../../../images/bluetooth/mac_2.png" />
            <li>Make sure your headphones or speakers are showing as connected</li>
            <img src="../../../../images/bluetooth/mac_3.png" />
            <li>If they aren't, click "Connect" if they appear in the list.  If they don't appear in the list, then make sure they are in pairing mode first.</li>
            <img src="../../../../images/bluetooth/mac_4.png" />
        </ol>
    </div>
    <div id="chromebook" class="<?php if ($os !== 'chromebook') {echo 'hidden'; } ?>">
        <ol>
            <li>Click your system tray</li>
            <img src="../../../../images/bluetooth/chromebook_1.png" />
            <li>Click the gear icon to go to your settings</li>
            <img src="../../../../images/bluetooth/chromebook_2.png" />
            <li>Click the arrow to the right of "Bluetooth" to expand the Bluetooth menu</li>
            <img src="../../../../images/bluetooth/chromebook_3.png" />
            <li>Verify that your headphones or speakers say they are connected.</li>
            <img src="../../../../images/bluetooth/chromebook_4.png" />
            <li>If they aren't and you see them in "Unpaired devices", click on them to connect.</li>
            <img src="../../../../images/bluetooth/chromebook_5.png" />
            <li>If they aren't and you see them in "Paired devices", click on the menu icon to their right, then click "Connect"</li>
            <img src="../../../../images/bluetooth/chromebook_6.png" />
            <li>If you don't see them anywhere, then make sure they are in pairing mode first.</li>
        </ol>
    </div>
    <div id="nix" class="<?php if ($os !== 'linux') { echo 'hidden'; } ?>">
        <p><b>Note:</b> The GNU/Linux instructions were created on PureOS (a Debian variant). It is assumed that if you are running GNU/Linux, you should have the
        skill-level necessary to use these instructions as a general guide and adjust to any GUI differences on your own.</p>
        <ol>
            <li>Start by clicking the dropdown in your system menu at the top left.</li>
            <img src="../../../../images/bluetooth/gnulinux_1.png" />
            <li>Click your settings icon</li>
            <img src="../../../../images/bluetooth/gnulinux_2.png" />
            <li>Go to the Bluetooth tab</li>
            <img src="../../../../images/bluetooth/gnulinux_3.png" />
            <li>Make sure that your headphones or speakers show as connected.</li>
            <img src="../../../../images/bluetooth/gnulinux_4.png" />
            <li>If they show up as disconnected, click them to bring up the options menu.</li>
            <img src="../../../../images/bluetooth/gnulinux_5.png" />
            <li>Click the toggle switch to connect.</li>
            <img src="../../../../images/bluetooth/gnulinux_6.png" />
            <li>If they show up as available devices, click them to pair with your computer.</li>
            <img src="../../../../images/bluetooth/gnulinux_7.png" />
            <li>If you don't see them at all, make sure your device is in pairing mode and try again.</li>
        </ol>
    </div>
    <li>Once you have ensured the headphones or speakers are connected, please try to play the audio below again.</li>
    <audio controls>
        <source src="../../../test_file.mp3" type="audio/mpeg">
        Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
    </audio>
</ol>
    <form id="issue_type" action="3.wireless.php" method="post">
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
