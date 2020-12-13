<?php
// Check for browser extension issues
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
    $hear = filterABC($_POST['hear']);

    if ($hear === "yes") {
        $message = "ID: $id \n
        Clearing unnecessary extensions was able to fix the issue.";
        send_message($slack_hook, $message);
        header("Location: ../../resolved.php");
    }else {
        if ($hear === "no") {
            $message = "ID: $id \n
        Clearing unnecessary extensions was *not* able to fix the issue.";
            send_message($slack_hook, $message);
            header("Location: 5.php");
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
<p>Ok, let's remove any browser extensions you don't recognize or aren't absolutely positive that you need. While some browser extensions
    may improve browsing experience, they can also cause undesired interference with certain websites on occasion,
    and in some cases can even be malicious (most are able to see all information you submit to a website -
    <i>including your passwords</i>); so it's a good idea to keep the installed extensions to a minimum anyway.</p>
<div id="chrome" class="<?php if (($browser !== 'chrome') && ($browser !== 'other')) { echo 'hidden'; } ?>">
    <?php if ($browser === 'other') {
        echo '<p><b>Note:</b> Officially we do not support browsers other than Chrome, Firefox, Chromium based Edge, and Safari. We will display the Chrome instructions in case that is able to help at all;
however, you can also go back to the <a href="../../submit_other.php">General feedback form</a> and submit a general bug report if these instructions do not help.</p>';
    }
    ?>
    <ol>
        <li>Click on the hamburger menu at the top right of Chrome.</li>
        <img src="../../images/clear_extensions/chrome_1.png" />
        <li>Hover over "More tools", then click "Extensions".</li>
        <img src="../../images/clear_extensions/chrome_2.png" />
        <li>For each extension, if you don't recognize it or aren't absolutely sure that you need it, either toggle it off or click "Remove".</li>
        <img src="../../images/clear_extensions/chrome_3.png" />
    </ol>
</div>
<div id="firefox" class="<?php if ($browser !== 'firefox') { echo 'hidden'; } ?>">
    <ol>
        <li>Click on the hamburger menu at the top right of FireFox.</li>
        <img src="../../images/clear_extensions/firefox_1.png" />
        <li>Click "Add-ons"</li>
        <img src="../../images/clear_extensions/firefox_2.png" />
        <li>For each extension listed under "Enabled", if you don't recognize it or aren't absolutely sure that you need it, you can toggle it off; or:</li>
        <img src="../../images/clear_extensions/firefox_3.png" />
        <li>Click the ellipsis menu to the right and click "Remove".</li>
        <img src="../../images/clear_extensions/firefox_4.png" />
    </ol>
</div>
<div id="edge" class="<?php if ($browser !== 'edge') {echo 'hidden'; } ?>">
    <ol>
        <li>Click on the ellipsis menu at the top right of Edge.</li>
        <img src="../../images/clear_extensions/edge_1.png" />
        <li>Click "Extensions"</li>
        <img src="../../images/clear_extensions/edge_2.png" />
        <li>For each extension, if you don't recognize it or aren't absolutely sure that you need it, either toggle it off or click "Remove".</li>
        <img src="../../images/clear_extensions/edge_3.png" />
    </ol>

</div>
<div id="fruitcake" class="<?php if ($browser !== 'safari') {echo 'hidden'; } ?>">
    <ol>
        <li>Click on "Safari" in your menu bar, then click "Preferences".</li>
        <img src="../../images/clear_extensions/safari_1.png" />
        <li>For each extension listed, if you don't recognize it or aren't absolutely sure that you need it, uncheck the box or uninstall the extension.</li>
        <img src="../../images/clear_extensions/safari_2.png" />
    </ol>
</div>
<p>Once you have cleared any unrecognized or unnecessary extensions, please <b>reload</b> the livestream and select whether or not that made a difference.</p>

<form id="issue_type" action="4.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
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