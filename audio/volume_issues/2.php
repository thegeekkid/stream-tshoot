<?php
// Check if video volume can be adjusted more
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

if (isset($_POST['submitting'])) {
    $hear = filterABC($_POST['hear']);

    if ($hear === "yes") {
        $message = "ID: $id \n
        Adjusting the video volume helped.";
        send_message($slack_hook, $message);
        header("Location: ../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Adjusting the video volume did *not* help.";
            send_message($slack_hook, $message);
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
<h1>Audio troubleshooting</h1>
<p>Troubleshooting volume issues</p>
<p>Ok, please adjust the video volume by hovering over the video, the over the volume icon, and dragging the bar to the left or right.</p>
<form id="issue_type" action="2.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="hear">Did adjusting the volume on the video help?</label>
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