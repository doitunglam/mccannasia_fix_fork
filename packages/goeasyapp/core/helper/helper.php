<?php
use App\Models\Language;

function __transItem($string)
{
    $lang = (session('locale') ? session('locale') : 'en');
    $json = ($string) ? json_decode($string, true) : [];
    return (isset($json[$lang])) ? $json[$lang] : $string;
}
function __trans($language, $key, $default)
{
    return (isset($language[$key]) ? $language[$key] : $default);
}
function json($string)
{
    return (isset($string) && $string) ? json_decode($string, true) : [];
}
function __language()
{
    return Language::all();
}
function currency_format($number, $suffix = '₫') {
        if (!empty($number)) {
            return number_format($number, 2, '.', ',') . "{$suffix}";
        } else {
            return 0 . "{$suffix}";
        }

    }
?>
