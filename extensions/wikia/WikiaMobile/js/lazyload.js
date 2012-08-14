/**
 * @define lazyload
 *
 * Image lazy loading
 */
/*global define*/
define('lazyload', ['thumbnailer'], function (thumbnailer) {
	'use strict';

	var win = window,
		w = win.innerWidth,
		h = win.innerHeight,
		width = 660,
		height = 330,
		//used to help browser not to reflow to much after lazyload
		//20 is a margin around page
		pageWidth = w - 20;

	w = (h > w) ? w : h;

	if(w <= 480){
		width = 300;
		height = 145;
	}else if(w <= 680){
		width = 460;
		height = 220;
	}

	window.addEventListener('resize', function(){
		pageWidth = win.innerWidth - 20;
	});

	return function(elements, background) {
		var x = 0,
			elm,
			img,
			src,
			imageWidth,
			onLoad = function(img){
				return function(){
					var url = this.src;
					img.className += ' load';
					setTimeout(function(){
						displayImage(img, url);
					}, 200);
				}
			},
			displayImage = function(img, url){
				background ? img.style.backgroundImage = 'url(' + url + ')' : img.src = url;
				img.className += ' loaded';
			};

		while(elm = elements[x++]) {
			img = new Image();
			src = elm.getAttribute('data-src');
			imageWidth = ~~elm.getAttribute('width');

			if(!thumbnailer.isThumbUrl(src)){
				if(elm.className.indexOf('getThumb') > -1){
					elm.setAttribute('height', height);
					src = thumbnailer.getThumbURL(src, 'image', width, height);
				}
			}

			if(pageWidth < imageWidth){
				elm.setAttribute('height', ~~(pageWidth/(imageWidth/~~elm.getAttribute('height'))));
			}

			img.src = src;

			//don't do any animation if image is already loaded
			img.complete ? displayImage(elm, src) : img.onload = onLoad(elm);
		}
	}
});