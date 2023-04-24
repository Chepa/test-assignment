<?php

if (!function_exists('mb_ucfirst')) {
    function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false): string
    {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);

        if ($lower_str_end) {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        } else {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }

        return $first_letter . $str_end;
    }
}
