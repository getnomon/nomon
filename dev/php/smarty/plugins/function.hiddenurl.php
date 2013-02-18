<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.hiddenurl.php
 * Type:     function
 * Name:     hiddenurl
 * Purpose:  checks for the user's location
 * -------------------------------------------------------------
 */

function smarty_function_hiddenurl($params, Smarty_Internal_Template $template) {
	return '<input type="hidden" name="current_url" value="' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] .'" />';
}
