<?php

function escape($str) {

    return htmlentities($str , ENT_QUOTES , 'UTF-8');
}

function clean($val) {

    $cleanVal = trim($val);

    $cleanVal = strip_tags($cleanVal);

    $cleanVal = escape($cleanVal);

    return $cleanVal;
}