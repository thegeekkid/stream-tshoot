<?php
    // Determine how they are listening on the phone

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
    $device = filterABC($_POST['device']);
    if (($device === "built-in") || ($device === "wired-speakers") || ($device === "wireless-speakers") || ($device === "wired-headphones") || ($device === "wireless-headphones")) {
        $message = "ID: $id \n
        Speaker type: $device";
        send_message($slack_hook, $message);

        if ($device === "built-in") {
            header("Location: 4.php");
        }else {
            if (explode('-', $device)[0] === "wired") {
                header("Location: 3.php");
            } else {
                header("Location: 3.wireless.php");
            }
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
<form id="issue_type" action="2.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="device">Are you using built in speakers, or external speakers/headphones?</label>
    <select id="device" name="device">
        <option value="built-in">Built in speakers</option>
        <option value="wired-speakers">External speakers (wired)</option>
        <option value="wireless-speakers">External speakers (wireless)</option>
        <option value="wired-headphones">Headphones (wired)</option>
        <option value="wireless-headphones">Headphones (wireless)</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>

