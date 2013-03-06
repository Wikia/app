//in webview setTimeout does not work as expected
//ie. webview is too long (as long as before section wrapping)
window.setTimeout = function(f){f()};