<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('format_number')) {
    function format_number($number) {
        return rtrim(rtrim(number_format($number, 2, ',', '.'), '0'), ',');
    }
}