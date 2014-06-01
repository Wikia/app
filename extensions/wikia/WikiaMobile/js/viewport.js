/**
 * A window event fired when the viewport size is changed
 * it tries to get viewport size correctly
 * support:
 * iOS > 3.2
 * Android > 2.3
 *
 * @author Jakub 'Student' Olek (jolek@wikia-inc.com)
 *
 * @example window.addEventListener('viewportsize', function(){});
 */

(function(w, d) {
	'use strict';

	var //some shortcuts to help minify JS
		ADD = 'addEventListener',
		CREATE = 'createEvent',

	//browser sniffing this is actually what I need here...
		ua = w.navigator.userAgent.toLowerCase(),
		android = ua.indexOf('android') > -1,
		ios = (ua.indexOf('iphone') > -1 || ua.indexOf('ipad') > -1),

	// private shared variables
		width = 0,
		height = 0,
		timer = 0,
		ev,
		portrait;

	if(android){
		var pixelRatio = w.devicePixelRatio || 1,
			//these are the sizes of topbar in android
			//in LDPI 19, MDPI 25, HDPI 38
			topBarSize = (pixelRatio === 1.5) ? 25 : (pixelRatio < 1.5 ? 19 : 38);
	}

	function getDimensions(){
		var orient = w.orientation;
		portrait = orient !== undefined ? (orient == 0 || orient == 180) : w.innerHeight >= w.innerWidth;

		if(ios && !width) {
			width = screen.width;
			height = screen.height;
		}else{
			if(portrait && !width) {
				width = w.innerWidth;
			}else if(!portrait && !height){
				//innerWidth is the only size that I can use and gives me meaningful measures
				height = w.innerWidth;
			}
		}
	}

	function resize() {
		clearTimeout(timer);
		timer = setTimeout(function() {
			getDimensions();

			ev = d[CREATE]('Event');
			ev.initEvent('viewportsize', true, true);

			ev.portrait = portrait;
			ev.width = portrait ? width : height;

			if(ios) {
				//64 is size of ui of iPhone in portrait mode
				//52 in landscape mode
				ev.height = portrait ? height - 64 : width - 52;
			}else{
				ev.height = (portrait ? height : width) - topBarSize;
			}

			w.dispatchEvent(ev);
		}, 50);
	}

	getDimensions();
	w[ADD]('resize', resize);
})(window, window.document);