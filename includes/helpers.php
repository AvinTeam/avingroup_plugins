<?php

(defined('ABSPATH')) || exit;


function sazo_remote(string $url)
{
    $res = wp_remote_get(
        $url,
        [
            'timeout' => 1000,
         ]);

    if (is_wp_error($res)) {
        $result = [
            'code'   => 1,
            'result' => $res->get_error_message(),
         ];
    } else {
        $result = [
            'code'   => 0,
            'result' => json_decode($res[ 'body' ]),
         ];
    }

    return $result;
}

function sazo_mask_mobile($mobile)
{

    $mobile = (string) $mobile;
    // بررسی طول شماره موبایل
    if (strlen($mobile) === 11) {
        $masked = substr($mobile, -3) . '****' . substr($mobile, 0, 4);
        return $masked;
    }
    return "شماره موبایل نامعتبر است.";
}

function get_current_relative_url()
{
    // گرفتن مسیر فعلی بدون دامنه
    $path = esc_url_raw(wp_unslash($_SERVER[ 'REQUEST_URI' ]));

    $relative_url = strtok($path, '?');
    $query_string = $_SERVER[ 'QUERY_STRING' ];

    if ($query_string) {
        $relative_url .= '?' . $query_string;
    }
    return $relative_url;
}

function sazo_to_english($text)
{

    $western = [ '0', '1', '2', '3', '4', '5', '6', '7', '8', '9' ];
    $persian = [ '۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹' ];
    $arabic  = [ '٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩' ];
    $text    = str_replace($persian, $western, $text);
    $text    = str_replace($arabic, $western, $text);
    return $text;

}

function is_mobile($mobile)
{
    $pattern = '/^(\+98|0)?9\d{9}$/';
    return preg_match($pattern, $mobile);
}

function sazo_transient()
{
    $sazo_transient = get_transient('sazo_transient');

    if ($sazo_transient) {
        delete_transient('sazo_transient');
        return $sazo_transient;
    }

}

function linktocode($input)
{
    if (preg_match('/^[a-zA-Z0-9]+$/', $input)) {
        return $input; // ورودی همان کد است
    }

    if (preg_match('/aparat\.com\/v\/([a-zA-Z0-9]+)/', $input, $matches)) {
        return $matches[ 1 ]; // کد ویدیو را برگردان
    }

    return null;
}

