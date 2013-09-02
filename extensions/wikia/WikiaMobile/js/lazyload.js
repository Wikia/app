/**
 * @define lazyload
 *
 * Image lazy loading
 */
/*global define*/
define('lazyload', ['wikia.thumbnailer', 'jquery', 'wikia.window'], function (thumbnailer, $, window) {
	'use strict';

	var d = document,
		pageContent = (d.getElementById('mw-content-text') || d.getElementById('wkMainCnt')),
		pageWidth = pageContent.offsetWidth;

	window.addEventListener('viewportsize', function(ev){
		pageWidth = pageContent.offsetWidth;
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
					}, 250);
				};
			},
			displayImage = function(img, url){
				background ? img.style.backgroundImage = 'url(' + url + ')' : img.src = url;
				img.className += ' loaded';
			};

		elements = $.makeArray(elements);

		while(elm = elements[x++]) {
			img = new window.Image();
			src = elm.getAttribute('data-src');
			imageWidth = ~~elm.getAttribute('width');

			if(elm.className.indexOf('getThumb') > -1 && !thumbnailer.isThumbUrl(src)){
				src = thumbnailer.getThumbURL(src, 'nocrop', 660, 330);
			}

			if(pageWidth < imageWidth){
				elm.setAttribute('height', Math.round(elm.width * (~~elm.getAttribute('height') / imageWidth)));
			}

			img.src = src;

			//don't do any animation if image is already loaded
			img.complete ? displayImage(elm, src) : img.onload = onLoad(elm);
		}
	};
});
