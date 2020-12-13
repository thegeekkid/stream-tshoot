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

$device = $_SESSION['phone'];

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
    <li>After that, please make sure the speakers or headphones are connected to your phone or tablet.  To do that:</li>
    <div id="android" class="<?php if ($os !== 'android') { echo 'hidden'; } ?>">
        <ol>
            <li>Drag down you notifications bar and expand it all the way; then tap the gear icon to open your setings.</li>
            <img src="../../../../images/bluetooth/android_1.png" />
            <li>Tap "Connected devices"</li>
            <img src="../../../../images/bluetooth/android_2.png" />
            <li>Make sure that your headphones or speakers show up under "Media Devices" as "Active".</li>
            <img src="../../../../images/bluetooth/android_3.png" />
            <li>If they don't, tap "See all" under "Previously connected devices".</li>
            <img src="../../../../images/bluetooth/android_4.png" />
            <li>If you see your device there, tap it to reconnect.</li>
            <img src="../../../../images/bluetooth/android_5.png" />
            <li>If you don't see your device under "Previously connected devices", go back one menu, then tap "Pair new device".</li>
            <img src="../../../../images/bluetooth/android_6.png" />
            <li>Tap your device to pair</li>
            <img src="../../../../images/bluetooth/android_7.png" />
            <li>Tap "pair" if prompted.</li>
            <img src="../../../../images/bluetooth/android_8.png" />
        </ol>

    </div>
    <div id="fruitcake" class="<?php if ($os !== 'iphone') { echo 'hidden'; } ?>">
        <ol>
            <li>Open your settings app</li>
            <img src="../../../../images/bluetooth/fruit_1.png" />
            <li>Go to your Bluetooth settings</li>
            <img src="../../../../images/bluetooth/fruit_2.png" />
            <li>Make sure your headphones or speakers are showing as connected</li>
            <img src="../../../../images/bluetooth/fruit_3.png" />
            <li>If they aren't, tap them to connect.</li>
            <img src="../../../../images/bluetooth/fruit_4.png" />
            <img src="../../../../images/bluetooth/fruit_5.png" />
        </ol>
    </div>
    <li>Once you have ensured the headphones or speakers are connected, please try to play the audio below again.</li>
</ol>
    <audio controls>
        <source src="../../../test_file.mp3" type="audio/mpeg">
        Your browser doesn't support HTML 5 audio - this could be part of the problem - please update to the latest version of your browser before continuing.
    </audio>

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
