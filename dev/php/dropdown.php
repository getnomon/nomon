<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once("lib/backend.php");

if($_GET["name"]) { // No point in doing any of this if no query, rite?
    $artistName = $_GET["name"]; 
    $matches = explode("/AND/", call_backend("SRCH", $artistName));
    if ($matches[0] == "Unknown") {
        $formatted_matches = '<li class="artist-search-result">No results found.</li>';
    } else {
        $formatted_matches = "";
    }

    foreach ($matches as $match) {
        if (strlen($match) > 15) {
            $truncatedMatch = substr($match, 0, 15) . '...';
            } else {
                $truncatedMatch = $match;
            }
            $formatted_matches .= '<a class="artist-search-result"><li class="artist-search-result">' . $truncatedMatch . '</li></a>';
          
    } 
    echo $formatted_matches;
    } else {
    $matchFormatError = '<li class="artist-search-result">Search error.</li>';
    echo $matchFormatError;
    }
    ?>
