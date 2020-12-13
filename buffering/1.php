<?php
// Check for speed issues

require_once('../config.inc');
require_once('../filters.inc');
require_once('../functions.inc');
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

$recommended = "";

if (isset($_POST['submitting'])) {

    if (isset($_POST['inform'])) {
        $inform = filterABC($_POST['inform']);
        if ($inform === "good_speed") {
            $reload_fix = filterABC($_POST['reload']);
            if ($reload_fix === "yes") {
                $message = "ID: $id \n
       Update: Reloading the page resolved the issue.";
                send_message($slack_hook, $message);
                header("Location: ../resolved.php");
            }else {
                if ($reload_fix === "no") {
                    $message = "ID: $id \n
       Update: Reloading the page did *not* resolve the issue.";
                    send_message($slack_hook, $message);
                    header("Location: 2.php");
                }
            }

        }else {
            if ($inform === "bad_speed") {
                $reso_fix = filterABC($_POST['resoreduce']);
                if ($reso_fix === "yes") {
                    $message = "ID: $id \n
       Update: Reducing the resolution resolved the issue.";
                    send_message($slack_hook, $message);
                    header("Location: ../resolved.php");
                }else {
                    if ($reso_fix === "no") {
                        $message = "ID: $id \n
       Update: Reducing the resolution did *not* solve the issue.";
                        send_message($slack_hook, $message);
                        header("Location: 2.php");
                    }
                }
            }
        }
    }


}else {

    if (isset($_GET['down'])) {
        $mbs = explode('.', $_GET['down'])[0];
        $up = explode('.', $_GET['up'])[0];
        $ping = explode('.', $_GET['ping'])[0];
        $jitter = explode('.', explode(', ', $_GET['ping'])[1])[0];

        $message = "ID: $id \n
        Speed test results: $mbs Mbps download
        $up Mbps upload
        $ping ms ping | $jitter ms jitter";
        $stat = send_message($slack_hook, $message);

        if ($mbs <= 10) {
            $speed_issue = true;


            if ($mbs <= 5) {
                $recommended = "360p";
                if ($mbs <= 4) {
                    $recommended = "240p";
                }else {
                    if ($mbs <= 2) {
                        $recommended = "144p";
                    }
                }
            }else {
                $recommended = "480p";
            }


        }else {
            $speed_issue = false;
        }
    }else {
        header("Location: speedtest.html");
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
<?php
    if (isset($mbs)) {
        echo "<p>We just ran a speed test on your computer. The result was $mbs Mbps download.";
        if (isset($speed_issue)) {
            if ($speed_issue) {
                echo "  This seems a bit slow - we recommend having a <i>minimum</i> of 10Mbps for an HD stream.</p>";
            }else {
                echo "  This seems like it should be adequate for viewing an HD stream.</p>";
            }
        }else {
            echo "</p>";
        }
    }

?>
<div id="bandwidth_good" class="<?php if ($speed_issue) { echo 'hidden'; } ?>">
    <p>We would recommend reloading the page just to verify if that will help.  Once you are done, if that doesn't fix it,
    come back here and we can continue troubleshooting.</p>
    <form id="reload_fix" action="1.php" method="post">
        <input type="hidden" id="submitting" name="submitting" value="true" />
        <input type="hidden" id="inform" name="inform" value="good_speed" />
        <label for="reload">Did reloading the page fix the issue?</label>
        <select id="reload" name="reload">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
        <input type="submit" value="Next Step" class="btn btn-success" />
    </form>
</div>

<div id="bandwidth_bad" class="<?php if (!($speed_issue)) { echo 'hidden'; } ?>">
    <p>If you would like a second opinion on your bandwidth, you can also check out <a href="https://fast.com" target="_blank">https://fast.com</a>.</p>
    <pIf this sounds like less than you are paying for, we would recommend double-checking the result with fast.com, and then reaching out to your
    Internet Service Provider for further assistance.</p>
    <p>In the meantime, you can try reducing the video resolution to see if that can help. To do that:</p>
    <ol>
        <li>Hover your mouse over the video, then click the gear icon on the lower right</li>
        <img src="../images/resolution_1.png" class="tutorial" />
        <li>Click "Quality"</li>
        <img src="../images/resolution_2.png" class="tutorial" />
        <li>Select a lower resolution - we recommend <?php echo $recommended; ?> or less based on your connection speed.</li>
        <img src="../images/resolution_3.png" class="tutorial" />
    </ol>
    <p>Once you've tried changing your resolution, come back and let us know if that made a difference.</p>
    <form id="reload_fix" action="1.php" method="post">
        <input type="hidden" id="submitting" name="submitting" value="true" />
        <input type="hidden" id="inform" name="inform" value="bad_speed" />
        <label for="resoreduce">Did reducing the resolution fix the issue?</label>
        <select id="resoreduce" name="resoreduce">
            <option value="yes">Yes</option>
            <option value="no">No</option>
        </select>
        <input type="submit" value="Next Step" class="btn btn-success" />
    </form>
</div>
<br />
<br />
</body>
</html>
