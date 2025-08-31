<?php
(defined('ABSPATH')) || exit;


function view($view, $response = null)
{

    if (! file_exists(SAZO_VIEWS . $view . '.php')) {

        echo "<p style='text-align:center'>dont have view -> $view</p>";
    } else {

        if ($response != null && (is_array($response) || is_object($response))) {

            extract($response);

        }

        require SAZO_VIEWS . $view . '.php';
    }

}