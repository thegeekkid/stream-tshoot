<?php
// Troubleshoot client-side issue
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
    if ($_SESSION['os'] === "chromebook") {
        $_SESSION['browser'] = "chrome";
        header("Location: 3.php");
    }
}

if (isset($_SESSION['browser'])) {
    header("Location: 3.php");
}

if (isset($_POST['submitting'])) {
    $browser = filterABC($_POST['browser']);
    if (($browser === "chrome") || ($browser === "firefox") || ($browser === "edge") || ($browser === "safari") || ($browser === "other")) {
        $message = "ID: $id \n
        User's browser: $browser";
        send_message($slack_hook, $message);
        $_SESSION['browser'] = $browser;
        if ($browser === "safari") {
            if (!(isset($_SESSION['os']))) {
                $_SESSION['os'] = 'mac';
            }
        }
        header("Location: 3.php");
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
<p>Troubleshooting audio sync issue</p>
<p>Hmm... if that's the case, it indicates that the issue might be on your end rather than ours. We have still alerted
    our broadcast engineers who will look into it, but in the meantime, we would recommend clearing your cache and cookies
    and checking for unknown/questionable browser extensions.  We can help walk you through that; but first we will need to
    know what browser you are using?</p>
<form id="issue_type" action="2.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="browser">Please select your browser below:</label>
    <select id="browser" name="browser">
        <option value="chrome">Chrome</option>
        <option value="firefox">Firefox</option>
        <option value="edge">Microsoft Edge</option>
        <option value="safari">Safari</option>
        <option value="other">Other browser</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>
