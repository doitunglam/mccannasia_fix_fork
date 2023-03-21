<?php
use App\Models\Language;

function __transItem($string)
{
    $lang = (session('locale') ? session('locale') : 'en');
    $json = ($string) ? json_decode($string, true) : [];
    $displayString = "";
    // check type is array or object
    if($json != null && is_array($json) && count($json) > 0) {
        foreach ($json as $key => $value) {
            if($displayString == "") {
                $displayString = $value;
            }
        }
    }
    return (isset($json[$lang])) ? ($json[$lang]) :( $displayString ? $displayString : $string);
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
    // check is number
        if (!empty($number) && is_numeric($number)) {
            return number_format($number, 2, '.', ',') . "{$suffix}";
        } else {
            return 0 . "{$suffix}";
        }

    }
?>
