<?php

function sanitize_operators($string)
{
    $sanitized = preg_replace("([\+-*/%&\|\^=<>\[\]\(\)\{\},;\.:\?])", "{1}", $string);
    return $sanitized;
}

?>
