<?php

require_once('config.inc');
if ($debug) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

if (isset($_POST['submitting'])) {
    require_once('filters.inc');
    require_once('functions.inc');

    $issue = $_POST['issues'];

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

    $message = "New troubleshooting submission:\n\n
    ID: $id 
    Name: $name 
    Email: <mailto:$email|$email> \n\n
    Message: \n
    $issue";

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
<h1>Sorry that we weren't able to be of more assistance. If you would like us to take a closer look, please describe the issues you are having in the form below and we will take a look.</h1>
<form id="submit_description" action="submit_other.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="issues">Description of issues:</label>
    <textarea id="issues" name="issues"><?php if (isset($_SESSION['os'])) {
        $os = $_SESSION['os'];
        echo "OS: $os 
";
        }
        if (isset($_SESSION['browser'])) {
            $browser = $_SESSION['browser'];
            echo "Browser: $browser
";
        }?></textarea>
    <p>In addition to a description of the issues you are experiencing, it may also help us to know what browser you are using (Internet Explorer, Chrome, Edge, FireFox, etc.),
    what type of device you are using (desktop computer, laptop, tablet, phone, TV, etc.), and what operating system you are running
    (Windows 10, MacOS, iPadOS/iOS, ChromeOS, Android, Roku, Android TV, etc.) if you know it.</p>
    <p>If you would like us to follow up with you about these issues, please enter your name and email below. (optional)</p>
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
