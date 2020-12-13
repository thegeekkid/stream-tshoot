<?php


function filterInts($input)
{

    $allowedChars = '1234567890';

    $result = "";
    $array  = str_split($input);

    foreach ($array as $char) {
        if (strpos($allowedChars, $char) !== false) {
            $result = $result . $char;
        }
    }

    return $result;

}

function filterABC($input)
{

    $allowedChars = 'abcdefghijklmnopqrstuvwxyz0123456789._- ';

    $result = "";
    $array  = str_split($input);

    foreach ($array as $char) {
        if (strpos($allowedChars, strtolower($char)) !== false) {
            $result = $result . $char;
        }
    }

    return $result;

}


function filterIP($input)
{

    $allowedChars = '0123456789./';

    $result = "";
    $array  = str_split($input);

    foreach ($array as $char) {
        if (strpos($allowedChars, strtolower($char)) !== false) {
            $result = $result . $char;
        }
    }

    return $result;

}

function filterProtocol($input)
{
    if ($input === "Any") {
        return "Any";
    } else {
        if ($input === "TCP") {
            return "TCP";
        } else {
            if ($input === "UDP") {
                return "UDP";
            } else {
                return "Any";
            }
        }
    }
}


function filterPorts($input)
{
    if ($input === "Any") {
        return "Any";
    } else {
        $allowedChars = '1234567890-';

        $build = "";
        $array = str_split($input);

        foreach ($array as $char) {
            if (strpos($allowedChars, $char) !== false) {
                $build = $build . $char;
            }
        }

        if ($build === "") {
            return "Any";
        } else {
            return $build;
        }
    }
}

function filterURL($input)
{
    $allowedChars = 'abcdefghijklmnopqrstuvwxyz0123456789.-+=_/\\:%?&*@';

    $result = "";
    $array  = str_split($input);

    foreach ($array as $char) {
        if (strpos($allowedChars, strtolower($char)) !== false) {
            $result = $result . $char;
        }
    }

    return $result;
}

function filterDate($input)
{
    $allowedChars = 'abcdefghijklmnopqrstuvwxyz0123456789.-+=_/\\:%? ';

    $result = "";
    $array  = str_split($input);

    foreach ($array as $char) {
        if (strpos($allowedChars, strtolower($char)) !== false) {
            $result = $result . $char;
        }
    }

    return $result;
}