define('device', function(){

    function hasTouch(){
        return ('ontouchstart' && 'ontouchmove' && 'ontouchend')in document.documentElement;
    }

    function hasBorderRadius(){
        return window.document.body.style.borderRadius !== undefined;
    }

    function hasCssTransforms(){
        return window.document.body.style.webkitTransform !== undefined;
    }

    function androidVersion(){
        var ua = navigator.userAgent;
        if( ua.indexOf("Android") >= 0 ){
            var androidversion = parseFloat(ua.slice(ua.indexOf("Android")+8));
            return androidversion;
        }
        return false;
    }

    function handlesAnimatedMenu(){
        return hasTouch() && hasBorderRadius() && hasCssTransforms() && androidVersion() != '2.3';
    }

    return {
        handlesAnimatedMenu: handlesAnimatedMenu
    }
});
