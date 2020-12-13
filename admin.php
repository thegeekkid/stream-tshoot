<?php
    require_once('config.inc');
    require_once('filters.inc');
    require_once('functions.inc');
    require_once('daily_config.inc');
    require_once('admin.inc');

    $authorized = false;

    if (isset($_POST['submitting'])) {
        if (($admin_pass_hash === "") && ($admin_pass_salt === "")) {
            $salt = hash('sha256', random_bytes(64));
            $hash = hash('sha256', $_POST['password'] . $salt);
            $adm = fopen('admin.inc', 'w') or die("Permissions error");
            $f = '<?php
$admin_pass_hash = "' . filterABC($hash) . '";
$admin_pass_salt = "' . filterABC($salt) . '";';
            fwrite($adm, $f);
            fclose($adm);
            header("Location: admin_login.html");
        }else {
            $check = hash('sha256', $_POST['password'] . $admin_pass_salt);
            if ($check === $admin_pass_hash) {
                $authorized = true;
                $_SESSION['admin'] = true;
            }else {
                die("Unauthorized!");
            }
        }
    }else {
        if (isset($_SESSION['admin'])) {
            if ($_SESSION['admin'] === true) {
                $authorized = true;
            }else {
                die("Unauthorized!");
            }
        }else {
            header("Location: admin_login.html");
            die("Unauthorized!");
        }
    }

    if (!($authorized)) {
        die("Unauthorized!");
    }

    if (isset($_POST['saving'])) {
        $issues = filterABC($_POST['issues']);
        $backup = filterURL($_POST['backup']);
        $set = fopen('daily_config.inc', 'w') or die("Permissions error");
        $fw = '<?php
    $known_issues = "' . $issues . '";
    $backup_url = "' . $backup . '";';
        fwrite($set, $fw);
        fclose($adm);
        header("Location: admin.php");
    }
?>

<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Stream troubleshooting admin page</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" media="screen" href="css/bootstrap.min.css" />
    <link rel="stylesheet" media="screen" href="css/screen.css" />
    <link rel="stylesheet" media="screen" href="css/Nunito.css" />
</head>
<body>
<h1>Save settings below:</h1>
<form id="admin" action="admin.php" method="post">
    <input type="hidden" id="saving" name="saving" value="true" />
    <label for="issues">Known issues:</label>
    <input type="text" id="issues" name="issues" value="<?php echo $known_issues; ?>" />
    <label for="backup">Backup link:</label>
    <input type="url" id="backup" name="backup" value="<?php echo $backup_url; ?>" />
    <input type="submit" value="Save settings" />
</form>
<br />
<br />
</body>
</html>
