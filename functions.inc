<?php


function generate_id ($adjectives, $nouns) {
    $adj = array_rand($adjectives);

    $nou = array_rand($nouns);

    $id = $adjectives[$adj] . " " . $nouns[$nou];

    $_SESSION['id'] = $id;

    return $id;
}

function send_message($webhook, $message) {
    if ($webhook !== "") {
        $mess = array('payload' => json_encode(array('text' => $message)));

        $c = curl_init($webhook);

        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $mess);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_exec($c);
        curl_close($c);
    }

}
