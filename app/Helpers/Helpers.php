<?php
if (!function_exists('add_paragraphs')) {
    function add_paragraphs($text) {
        // implementácia, ktorá obalí každý odsek do <p> tagu
        $text = '<p>' . implode('</p><p>', array_filter(explode("\n", $text))) . '</p>';
        return $text;
    }
}

if (!function_exists('filter_url')) {
    function filter_url($text) {
        // implementácia, ktorá detekuje URL a obalí ich do <a> tagu
        $text = preg_replace('@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.#-~]*(\?\S+)?[^\.\s])?)?)@', '<a href="$1" target="_blank">$1</a>', $text);
        return $text;
    }
}
