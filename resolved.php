<?php

require_once('config.inc');
require_once('filters.inc');
require_once('functions.inc');
if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (isset($_POST['submitting'])) {


    $feedback = $_POST['feedback'];

    if (isset($_SESSION['id'])) {
        $id = filterABC($_SESSION['id']);
    }else {
        $id = filterABC(generate_id($adjectives, $nouns));
    }

    if (isset($_POST['name'])) {
        $name = filterABC($_POST['name']);
    }else {
        $name = 'Not provided';
    }
    if (isset($_POST['email'])) {
        $email = filterURL($_POST['email']);
    }else {
        $email = 'Not provided';
    }

    if (isset($_POST['helpful'])) {
        $helpful = filterABC($_POST['helpful']);
    }

    if (!(($helpful === "yes" || $helpful === "no"))) {
        $helpful = "Not answered";
    }

    $message = "New feedback submitted:\n\n
    ID: $id 
    Name: $name 
    Email: <mailto:$email|$email> \n\n
    Troubleshooter was helpful: $helpful \n
    Message: \n
    $feedback";

    send_message($slack_hook, $message);

    header("Location: submitted.html");

}

?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Stream troubleshooting</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" media="screen" href="css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="css/screen.css" />
    <link rel="stylesheet" media="screen" href="css/Nunito.css" />
</head>
<body>
<?php require_once('alertbar.inc'); ?>
<h1>Great!  We are glad that we were able to resolve your issue!</h1>
<form id="submit_description" action="resolved.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="helpful">Out of curiosity, was this troubleshooter helpful?</label>
    <select id="helpful" name="helpful">
        <option value="yes">Yes</option>
        <option value="no">No</option>
    </select>
    <label for="feedback">If you have any additional feedback about the issues you experienced or the troubleshooting tool, feel free to comment below. (Optional)</label>
    <textarea id="feedback" name="feedback"></textarea>
    <p>If you would like us to follow up with you about anything mentioned in the feedback, please enter your name and email below. (optional)</p>
    <label for="name">Name (optional):</label>
    <input type="text" id="name" name="name" />
    <label for="email">Email (optional):</label>
    <input type="email" id="email" name="email" />
    <input type="submit" value="Send feedback" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>
