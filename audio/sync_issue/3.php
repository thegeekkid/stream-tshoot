<?php
    // Clear cache

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

if (isset($_SESSION['browser'])) {
    $browser = $_SESSION['browser'];
}else {
    $browser = '';
}



if (isset($_POST['submitting'])) {
    $id = filterABC($_POST['persistence_id']);
    $_SESSION['id'] = $id;
    if (isset($_POST['persistence_browser'])) {
        $b = filterABC($_POST['persistence_browser']);
        if (($b === "chrome") || ($b === "firefox") || ($b === "edge") || ($b === "safari") || ($b === "other")) {
            $browser = $b;
            $_SESSION['browser'] = $browser;
        }
    }
    if (isset($_POST['persistence_os'])) {
        $o = filterABC($_POST['persistence_os']);
        if (($o === "windows") || ($o === "mac") || ($o === "linux") || ($o === "chromebook")) {
            $_SESSION['os'] = $o;
            $os = $o;
        }
    }

    $hear = filterABC($_POST['hear']);

    if ($hear === "yes") {
        $message = "ID: $id \n
        Clearing cache and cookies was able to fix the issue.";
        send_message($slack_hook, $message);
        header("Location: ../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Clearing cache and cookies was *not* able to fix the issue.";
            send_message($slack_hook, $message);
            header("Location: 4.php");
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
<p>Troubleshooting audio sync issue</p>
<p>Ok, let's go ahead and clear the cache and cookies first.</p>
<div id="chrome" class="<?php if (($browser !== 'chrome') && ($browser !== 'other')) { echo 'hidden'; } ?>">
    <?php if ($browser === 'other') {
        echo '<p><b>Note:</b> Officially we do not support browsers other than Chrome, Firefox, Chromium based Edge, and Safari. We will display the Chrome instructions in case that is able to help at all;
however, you can also go back to the <a href="../../submit_other.php">General feedback form</a> and submit a general bug report if these instructions do not help.</p>';
    }
    ?>
    <ol>
        <li>Click on the hamburger menu at the top right of Chrome.</li>
        <img src="../../images/clear_cache/chrome_1.png" />
        <li>Hover over "More tools", then select "Clear browsing data".</li>
        <img src="../../images/clear_cache/chrome_2.png" />
        <li>Change the "Time range" dropdown to "All time".</li>
        <img src="../../images/clear_cache/chrome_3.png" />
        <li>Make sure all 3 checkboxes are checked, then click "Clear data".</li>
        <img src="../../images/clear_cache/chrome_4.png" />
    </ol>
</div>
<div id="firefox" class="<?php if ($browser !== 'firefox') { echo 'hidden'; } ?>">
    <ol>
        <li>Click on the hamburger menu at the top right of FireFox.</li>
        <img src="../../images/clear_cache/firefox_1.png" />
        <li>Click the "Library" submenu.</li>
        <img src="../../images/clear_cache/firefox_2.png" />
        <li>Click the "History" submenu.</li>
        <img src="../../images/clear_cache/firefox_3.png" />
        <li>Click "Clear Recent History...".</li>
        <img src="../../images/clear_cache/firefox_4.png" />
        <li>Change the "Time range to clear" dropdown to "Everything".</li>
        <img src="../../images/clear_cache/firefox_5.png" />
        <li>Check all of the boxes under "History" and "Data", then click "OK".</li>
        <img src="../../images/clear_cache/firefox_6.png" />
    </ol>
</div>
<div id="edge" class="<?php if ($browser !== 'edge') {echo 'hidden'; } ?>">
    <ol>
        <li>Click on the ellipsis menu at the top right of Edge.</li>
        <img src="../../images/clear_cache/edge_1.png" />
        <li>Hover over the "History" submenu, then click "Clear browsing data".</li>
        <img src="../../images/clear_cache/edge_2.png" />
        <li>Change the "Time range" dropdown to "All time".</li>
        <img src="../../images/clear_cache/edge_3.png" />
        <li>Check the first 4 boxes, then click "Clear now".</li>
        <img src="../../images/clear_cache/edge_4.png" />
    </ol>

</div>
<div id="fruitcake" class="<?php if ($browser !== 'safari') {echo 'hidden'; } ?>">
    <ol>
        <li>Click on the "History" menu in your menu bar, then click "Clear History".</li>
        <img src="../../images/clear_cache/fruit_1.png" />
        <li>Change the "Clear" dropdown to "all history".</li>
        <img src="../../images/clear_cache/fruit_2.png" />
        <li>Click "Clear History".</li>
        <img src="../../images/clear_cache/fruit_3.png" />
    </ol>
</div>
<p>Once you have cleared your cache and cookies, please try the test clip below again to see if that makes a difference.</p>
<iframe width="560" height="315" src="https://www.youtube.com/embed/ucZl6vQ_8Uo?start=3" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

<form id="issue_type" action="3.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <input type="hidden" id="persistence_id" name="persistence_id" value="<?php echo $id; ?>" />
    <input type="hidden" id="persistence_browser" name="persistence_browser" value="<?php echo $browser; ?>" />
    <?php
        if (isset($_SESSION['os'])) {
            echo '<input type="hidden" id="persistence_os" name="persistence_os" value="' . $_SESSION['os'] . '" />';
        }
    ?>
    <label for="hear">Did that fix the issue?</label>
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