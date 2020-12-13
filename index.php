<?php
    require_once('config.inc');
    if ($debug) {
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    }

    if (isset($_POST['submitting'])) {
        require_once('filters.inc');
        if (filterABC($_POST['troubleshoot']) === "yes") {
            header("Location: troubleshoot.php");
        }else {
            header("Location: submit_other.php");
        }
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
        <h1>We're sorry to hear you are having issues with the stream!</h1>
        <h2>If you're up for it, we can try to do some basic troubleshooting, otherwise you can simply report the issue below.</h2>
        <form id="intial_question" action="index.php" method="post">
            <input type="hidden" id="submitting" name="submitting" value="true" />
            <label for="troubleshoot">Should we start troubleshooting?</label>
            <select name="troubleshoot" id="troubleshoot">
                <option value="yes" selected>Yes, start troubleshooting</option>
                <option value="no">No, just report the issue</option>
            </select>
            <input type="submit" value="Next step" class="btn btn-success" />
        </form>
        <br />
        <br />
    </body>
</html>