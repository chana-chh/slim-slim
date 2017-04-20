<?php
/*
    Pomocne funkcije - brise se u prodikciji
 */
function dd($prom, $prn = false) {
    if($prn) {
        echo '<pre><code>';
        print_r($prom);
        echo '</code></pre>';
    } else {
        var_dump($prom);
    }
    die();
}

function vd($prom) {
    echo '<pre><code>';
    var_dump($prom);
    echo '</code></pre>';
}

function pr($prom) {
    echo '<pre><code>';
    print_r($prom);
    echo '</code></pre>';
}