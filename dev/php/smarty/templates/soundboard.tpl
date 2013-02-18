{include file="header.tpl" title="header"}


{foreach $reviews as $review}
{$review}
{/foreach}

{foreach $tweets as $tweet}
{$tweet}
{/foreach}




{include file="copy.tpl"}
{include file="footer.tpl"}