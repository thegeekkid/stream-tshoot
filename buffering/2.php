<?php
// Check for stream source issues
require_once('../config.inc');
require_once('../filters.inc');
require_once('../functions.inc');
require_once('../daily_config.inc');

if ($backup_url === "") {
    $message = "ID: $id \n
       No backup URL listed in configuration, redirecting to submit_other.";
    send_message($slack_hook, $message);
    header("Location: ../submit_other.php");
}else {
    if (isset($_POST['submitting'])) {
        $backup_fix = filterABC($_POST['backup']);
        if ($backup_fix === "yes") {
            $message = "ID: $id \n
       Update: Backup URL fixed the issue.";
            send_message($slack_hook, $message);
            header("Location: ../resolved.php");
        }else{
            if ($backup_fix === "no") {
                $message = "ID: $id \n
       Update: Backup URL did *not* fix the issue.";
                send_message($slack_hook, $message);
                header("Location: ../submit_other.php");
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
    <link rel="stylesheet" media="screen" href="../css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="../css/screen.css" />
    <link rel="stylesheet" media="screen" href="../css/Nunito.css" />
</head>
<body>
<?php require_once('../alertbar.inc'); ?>
<h1>Buffering troubleshooting</h1>
    <p>Please check the backup link below to see if that is any better.</p>
    <p>Backup link: <a href="<?php echo $backup_url; ?>" target="_blank"><?php echo $backup_url; ?></a></p>
    <form id="backup_fix" action="2.php" method="post">
        <input type="hidden" id="submitting" name="submitting" value="true" />
        <input type="hidden" id="inform" name="inform" value="good_speed" />
        <label for="backup">Were you able to view the video correctly at the backup link?</label>
        <select id="backup" name="backup">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
        <input type="submit" value="Next Step" class="btn btn-success" />
    </form>
<br />
<br />



</body>
</html>
