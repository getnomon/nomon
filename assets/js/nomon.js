/*
# NAME: NomON!
# AUTHOR: Evan Cohen
# DATE: September 2012
# USAGE: Imports all of the content from Ellington to Drupal
# REQUIREMENTS: Know what you are doing if you run this!
*/

var a=document.getElementsByTagName("a");
for(var i=0;i<a.length;i++) {
    if(!a[i].onclick && a[i].getAttribute("target") != "_blank") {
        a[i].onclick=function() {
        		console.log(this.getAttribute("href"));
                window.location=this.getAttribute("href");
                return false; 
        }
    }
}

$(function() {
    if($(location).attr('pathname') != '/' && $(location).attr('pathname') != '/test'){
        $('.mini-logo').attr('style', 'display: inline-block');
    }
});