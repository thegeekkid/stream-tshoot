<?php
// Determine type of desktop
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

if (isset($_SESSION['os'])) {
    header("Location: 2.php");
}

if (isset($_POST['submitting'])) {
    $device = filterABC($_POST['device']);

    if (($device === "windows") || ($device === "mac") || ($device === "linux")) {
        $message = "ID: $id \n
        Laptop type: $device";
        send_message($slack_hook, $message);

        $_SESSION['os'] = $device;

        header("Location: ../laptop/2.php");

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
<form id="issue_type" action="1.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="device">What type of operating system is it running?</label>
    <select id="device" name="device">
        <option value="windows">Windows</option>
        <option value="mac">Mac (OSx/MacOS)</option>
        <option value="linux">GNU/Linux (very rare for most people)</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />

</body>
</html>