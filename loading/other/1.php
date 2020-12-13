<?php
// Determine what type of phone is being used.

require_once('../../config.inc');
require_once('../../filters.inc');
require_once('../../functions.inc');

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

    if (($device === "android") || ($device === "iphone") || ($device === "other")) {
        $message = "ID: $id \n
        Laptop type: $device";
        send_message($slack_hook, $message);

        $_SESSION['phone'] = $device;

        if ($device === "other") {
            header("Location: ../other/1.php");
        }else {
            header("Location: 2.php");
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
    <link rel="stylesheet" media="screen" href="../../css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="../../css/screen.css" />
    <link rel="stylesheet" media="screen" href="../../css/Nunito.css" />
</head>
<body>
<?php require_once('../../alertbar.inc'); ?>
<h1>Page/video load troubleshooting</h1>
<form id="issue_type" action="1.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="device">What type of phone or tablet do you have?</label>
    <select id="device" name="device">
        <option value="android">Android</option>
        <option value="iphone">iPhone/iPad</option>
        <option value="other">Other</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>
