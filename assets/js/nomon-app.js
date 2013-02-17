/*
# NAME: NomON - The App!
# AUTHOR: Evan Cohen
# DATE: Febuary 2012
# USAGE: MVM using jQuery
# REQUIREMENTS: Sufficient swag
*/


$(function() {
    if($(location).attr('pathname') != '/' && $(location).attr('pathname') != '/test'){
        $('.mini-logo').attr('style', 'display: inline-block');
    }
});