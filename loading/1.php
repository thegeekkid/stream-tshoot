<?php
// Get device type
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

if (isset($_POST['submitting'])) {
    $device = filterABC($_POST['device']);
    if (($device === "laptop") || ($device === "desktop") || ($device === "tablet") || ($device === "phone") || ($device === "laptop2tv") || ($device === "cast2tv") || ($device === "tv") || ($device === "other")) {
        $message = "ID: $id \n
        Device type: $device";
        send_message($slack_hook, $message);

        if ($device === "laptop") {
            header("Location: computer/1.php");
        }else {
            if ($device === "desktop") {
                header("Location: computer/1.php");
            }else {
                if ($device === "tablet") {
                    header("Location: other/1.php");
                }else {
                    if ($device === "phone") {
                        header("Location: other/1.php");
                    }else {
                        if ($device === "laptop2tv") {
                            header("Location: computer/1.php");
                        }else {
                            if ($device === "cast2tv") {
                                header("Location: computer/1.php");
                            }else {
                                if ($device === "tv") {
                                    header("Location: other/1.php");
                                }else {
                                    header("Location: other/1.php");
                                }
                            }
                        }
                    }
                }
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
<h1>Page/video load troubleshooting</h1>
<form id="issue_type" action="1.php" method="post">
    <input type="hidden" id="submitting" name="submitting" value="true" />
    <label for="device">Ok, what type of device are you using?</label>
    <select id="device" name="device">
        <option value="laptop">Laptop computer</option>
        <option value="desktop">Desktop computer</option>
        <option value="tablet">Tablet</option>
        <option value="phone">Phone</option>
        <option value="laptop2tv">Laptop connected to TV over HDMI</option>
        <option value="cast2tv">Tablet/phone screen casting (wirelessly) to TV</option>
        <option value="tv">Directly streaming from TV</option>
        <option value="other">Something else</option>
    </select>
    <input type="submit" value="Next Step" class="btn btn-success" />
</form>
<br />
<br />
</body>
</html>

