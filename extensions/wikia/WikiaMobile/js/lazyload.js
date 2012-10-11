/**
 * @define lazyload
 *
 * Image lazy loading
 */
/*global define*/
define('lazyload', ['thumbnailer', 'layout'], function (thumbnailer, layout) {
	'use strict';

	return function(elements, background) {
		var x = 0,
			elm,
			img,
			src,
			imageWidth,
			pageWidth = layout.getPageWidth(),
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

			if(elm.className.indexOf('getThumb') > -1 && !thumbnailer.isThumbUrl(src)){
				src = thumbnailer.getThumbURL(src, 'nocrop', 660, 330);
			}

			if(pageWidth < imageWidth){
				elm.setAttribute('height', ~~(pageWidth/(imageWidth/~~elm.getAttribute('height'))));
			}

			img.src = src;

			//don't do any animation if image is already loaded
			img.complete ? displayImage(elm, src) : img.onload = onLoad(elm);
		}
	};
});