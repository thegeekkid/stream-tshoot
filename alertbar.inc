<?php

    require_once('daily_config.inc');

    if ($known_issues !== "") {
        echo '<div class="alert alert-danger" role="alert">
Note: there are currently known issues with the stream: ' . $known_issues . '</div>';
    }