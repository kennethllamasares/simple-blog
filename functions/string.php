<?php

function str_slug($title, $separator = '-', $language = 'en')
{
    // $title = static::ascii($title, $language);
    // Convert all dashes/underscores into separator
    $flip = $separator == '-' ? '_' : '-';
    $title = preg_replace('!['.preg_quote($flip).']+!u', $separator, $title);
    // Replace @ with the word 'at'
    $title = str_replace('@', $separator.'at'.$separator, $title);
    // Remove all characters that are not the separator, letters, numbers, or whitespace.

    // With lower case: $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', mb_strtolower($title));
    $title = preg_replace('![^'.preg_quote($separator).'\pL\pN\s]+!u', '', $title);

    // Replace all separator characters and whitespace by a single separator
    $title = preg_replace('!['.preg_quote($separator).'\s]+!u', $separator, $title);
    return trim($title, $separator);
}

function dateDiff($date1, $date2)
{
    $date_1 = new DateTime($date1);
    $date_2 = new DateTime($date2);
    $diff = $date_1->diff($date_2);

    if ($diff->days > 365) {
        return $date_1->format('Y-m-d');
    } elseif ($diff->days > 7) {
        return $date_1->format('M d');
    } elseif ($diff->days > 2) {
        return $date_1->format('L - H:i');
    } elseif ($diff->days == 2) {
        return "Yesterday ".$date_1->format('H:i');
    } elseif ($diff->days > 0 OR $diff->h > 1) {
        return $date_1->format('h:i a');
    } elseif ($diff->i >= 1) {
        return $diff->i." min ago";
    } else {
        return "Just now";
    }
}