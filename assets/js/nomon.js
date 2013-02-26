/*
# NAME: nomON
# AUTHOR: Evan Cohen
# DATE: September 2012
# USAGE: Powers the mighty application known as nomON
# REQUIREMENTS: Extreme hunger
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