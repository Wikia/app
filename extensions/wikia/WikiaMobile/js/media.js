/*global define, modal, WikiaMobile, wgStyleVersion, wgArticleId */
/**
 * Media handling in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */
define('media', ['JSMessages', 'modal', 'loader', 'querystring', require.optional('popover'), 'track', 'events', require.optional('share'), require.optional('cache')], function(msg, modal, loader, qs, popover, track, events, share, cache){
	'use strict';
	/** @private **/

	var	transform = (function(style, undef){
			return style.transform != undef ? 'transform' : style.webkitTransform != undef ? 'webkitTransform' : style.oTransform != undef ? 'oTransform' : style.mozTransform != undef ? 'mozTransform' : 'msTransform';
		})(document.createElement('div').style),
		images = [],
		elements,
		pages = [],
		videoCache = {},
		pager,
		currentImage,
		currentImageStyle,
		imagesLength = 0,
		wkMdlImages,
		current = 0,
		shrImg = (new qs()).getVal('file'),
		shareBtn,
		clickEvent = events.click,
		sharePopOver,
		content = '<div id=wkMdlImages></div>',
		toolbar = '<div class=wkShr id=wkShrImg></div>',
		//zoom variables
		wrapper,
		startX,
		startY,
		touched,
		currentZoom,
		zoomed,
		zooming,
		zoomable = true,
		img,
		imgW,
		imgH,
		origW,
		origH,
		dx,
		dy,
		sx,
		sy,
		xMax,
		yMax,
		widthFll,
		heightFll,
		startD,
		galleryInited = false,
		inited;

	//Media object that holds all data needed to display it in modal/gallery
	function Media(elem, data, length, i){

		this.element = elem;
		this.url = data.full;

		if(data.name) {this.name = data.name;}
		if(data.thumb) {this.thumb = data.thumb;}
		if(data.med) {this.med = data.med;}
		if(data.capt) {this.caption = data.capt;}
		if(data.type === 'video') {this.isVideo = true;}

		if(length > 1){
			this.length = length;
			this.number = i;
		}
	}

	function setup(){
		var	name,
			i = 0,
			element,
			imageData,
			j,
			l;

		//loop that gets all media from a page
		while(element = elements[i++]) {
			var params = element.getAttribute('data-params') || false,
				data = JSON.parse(params);

			if(data && data instanceof Array){
				j = 0;

				element.setAttribute('data-num', imagesLength);

				l = data.length;

				while(imageData = data[j++]){
					name = imageData.name;

					if (name === shrImg) {shrImg = imagesLength;}

					images[images.length] = new Media(element, imageData, l, j);

					//create pages for modal
					pages[imagesLength++] = '<section><img src=' + imageData.full + '></section>';
				}
			}
		}

		if(imagesLength > 1) {
			content = '<div class=chnImg id=prvImg></div>' + content + '<div class=chnImg id=nxtImg></div>';
			toolbar += '<div id=wkGalTgl></div>';
		}

		//this function should not run twice
		inited = true;
		elements = null;
	}

	function init(images){

		elements = images;

		//if url contains image=imageName - setup and find the image
		if(shrImg) {
			setTimeout(function(){
				!inited && setup();
				openModal(shrImg);
			}, 2000);
		}

		document.body.addEventListener(clickEvent, function(event){
			var t = event.target,
				className = t.className;

			//if this image is a linked image don't open modal
			if(className.indexOf('media') > -1){
				event.preventDefault();
				event.stopPropagation();

				!inited && setup();

				if(className.indexOf('Wikia-video-thumb') > -1) {track.event('video', track.CLICK, {label: 'article'});}

				openModal(~~t.getAttribute('data-num'));
			}
		}, true);
	}

	function handleError(msg){
		modal.setCaption(msg || '');
		modal.showUI();
		currentImageStyle.webkitTransform = 'scale(1)';
		currentImage.className += ' imgPlcHld';
	}

	function setupImage(){
		var image = images[current];
		loader.remove(currentImage);

		modal.setCaption(getCaption(current));

		//inject the content only if it was not already there in the page
		//to avoid refresh the contents (it triggers a full
		//reload of iframe contents for videos)
		if(image.isVideo) {// video
			if(!pager.getCurrent().innerHTML) {
				var imgTitle = image.name;
				currentImageStyle.backgroundImage = '';

				if(videoCache[imgTitle]){
					currentImage.innerHTML = '<table id=wkVi><tr><td>'+videoCache[imgTitle]+'</td></tr></table>';
				}else{
					loader.show(currentImage, {
						center: true
					});

					Wikia.nirvana.sendRequest({
						type: 'get',
						format: 'json',
						controller: 'VideoHandlerController',
						method: 'getEmbedCode',
						data: {
							articleId: wgArticleId,
							fileTitle: imgTitle,
							width: window.innerWidth - 100
						},
						callback: function(data) {
							loader.remove(currentImage);

							if(data.error){
								handleError(data.error);
							}else{
								videoCache[imgTitle] = data.embedCode;
								currentImage.innerHTML = '<table id=wkVi><tr><td>' + data.embedCode + '</td></tr></table>';
							}
						}
					});
				}
			}
		}else{
			var img = new Image();
			img.src = image.url;

			if(!img.complete){
				img.onload = function(){
					loader.hide(currentImage);

					var img = currentImage.getElementsByTagName('img')[0];
					origW = img.width;
					origH = img.height;
				};

				img.onerror = function(){
					loader.hide(currentImage);
					handleError(msg('wikiamobile-image-not-loaded'));
				};

				loader.show(currentImage, {
					center: true
				});
			}else{
				img = currentImage.getElementsByTagName('img')[0];
				origW = img.width;
				origH = img.height;
			}
		}
	}

	function getCaption(num){
		var img = images[num],
			cap = img.caption,
			number = img.number,
			length = img.length,
			figCap;

		if(typeof cap !== 'string'){
			if(cap) {
				//if caption is not a string and img.caption is set to true grab it from DOM
				figCap = img.element.parentElement.parentElement.getElementsByClassName('thumbcaption')[0];

				cap = figCap ? figCap.innerHTML : '';
				//and then cache it in media object
				img.caption = cap;
			}else{
				cap = '';
				img.caption = '';
			}
		}

		if(number >= 0 && length >= 0) {
			cap += '<div class=wkStkFtr> ' + number + ' / ' + length + ' </div>';
		}

		return cap;
	}

	function ondblTap(ev){
		touched = false;
		ev.preventDefault();

		if(zoomed){
			resetZoom();
		}else{
			currentZoom = 2;
			currentImageStyle[transform] = 'scale(2)';
		}

		onZoom();
	}

	function onZoom(state){
		zoomed = (state === undefined) ? !zoomed : state;

		imgW = origW * currentZoom;
		imgH = origH * currentZoom;

		xMax = imgW / 2 - widthFll / 2 + 10;
		yMax = imgH / 2 - heightFll / 2 + 10;

		if(zoomed){
			modal.hideUI();
		}else{
			modal.showUI();
		}
	}

	//for the ones that does not have ev.scale...
	function distance(a,b){
		var x = b.clientX - a.clientX,
			y = b.clientY - a.clientY;

		return Math.sqrt((x * x) + (y * y)) / 1000;
	}

	function onStart(ev){
		if (zoomable) {
			var touches = ev.touches,
				l = touches.length;

			ev.scale && wrapper.removeEventListener('touchstart', onStart);
			wrapper.addEventListener('touchmove', onMove);
			wrapper.addEventListener('touchend', onEnd);
			wrapper.addEventListener('touchcancel', onEnd);

			if(l == 1){
				sx = dx * currentZoom || 0;
				sy = dy * currentZoom || 0;
				startX = touches[0].clientX * currentZoom;
				startY = touches[0].clientY * currentZoom;

				if(touched) {
					ondblTap(ev);
				}else{
					touched = true;
					setTimeout(function(){
						touched = false;
					}, 300);
				}
			}

			if(l === 2 && !ev.scale){
				wrapper.removeEventListener('touchstart', onStart);
				startD = distance(touches[0], touches[1]);
			}
		}
	}

	function onMove(ev){
		if ( zoomable ) {
			var touches = ev.touches,
				l = touches ? touches.length : 0;

			ev.preventDefault();

			if(l === 1 && zoomed) {
				var touch = touches[0];

				dx = (imgW <= widthFll) ? 0 : ~~(Math.max(-xMax, Math.min(xMax, (-(touch.clientX * currentZoom - startX) + sx) / currentZoom)));
				dy = (imgH <= heightFll) ? 0 : ~~(Math.max(-yMax, Math.min(yMax, (-(touch.clientY * currentZoom - startY) + sy) / currentZoom)));

				currentImageStyle[transform] = 'scale(' + currentZoom + ') translate(' + -dx / currentZoom + 'px,' + -dy / currentZoom + 'px)';

				modal.hideUI();
			}

			if(l === 2){
				//max 4x
				var scale = (ev.scale || (distance(touches[0], touches[1]) / startD)),
					newZoom = Math.min(4, currentZoom * (Math.sqrt(scale) * 100) / 100);

				if(newZoom != currentZoom) {
					if(!zoomed && newZoom < 1){
						if(!zooming && newZoom < 0.9){
							require([require.optional('mediagallery')], function(mg){
								mg && mg.open();
							});
							currentZoom = 1;
						}
					}else {
						zooming = (scale > 1) ? 'zoom-in' : 'zoom-out';

						if(newZoom > 1){
							currentZoom = newZoom;

							currentImageStyle[transform] = 'scale(' + newZoom + ')';

							onZoom(true);
						}else{
							resetZoom();
							onZoom(false);
						}
					}
				}
			}
		} else {
			onEnd();
		}

	}

	function onEnd(){
		wrapper.addEventListener('touchstart', onStart);
		wrapper.removeEventListener('touchmove', onMove);
		wrapper.removeEventListener('touchend', onEnd);
		wrapper.removeEventListener('touchcancel', onEnd);
		zooming = '';
	}

	function resetZoom(){
		currentZoom = 1;
		currentImageStyle && (currentImageStyle[transform] = 'scale(1)');
	}

	function addZoom(){
		zoomed = false;
		resetZoom();
		wrapper.addEventListener('touchstart', onStart);
	}

	function removeZoom(){
		wrapper.removeEventListener('touchstart', onStart);
	}

	function refresh(){
		currentImage = wkMdlImages.getElementsByClassName('current')[0];
		currentImageStyle = currentImage.style;

		setupImage();
	}

	function openModal(num){
		var cacheKey = 'mediaGalleryAssets' + wgStyleVersion,
			galleryData,
			ttl = 604800; //7days

		current = ~~num;

		modal.open({
			content: content,
			toolbar: toolbar,
			classes: 'imgMdl',
			onClose: function(){
				pager.cleanup();
				removeZoom();
			}
		});

		wrapper = modal.getWrapper();

		if(imagesLength > 1 && !galleryInited) {
			galleryData = cache && cache.get(cacheKey);

			if(galleryData){
				Wikia.processStyle(galleryData[0]);
				Wikia.processScript(galleryData[1]);
				require(['mediagallery'], function(mg){
					mg.init();
				});
			}else{
				Wikia.getMultiTypePackage({
					styles: '/extensions/wikia/WikiaMobile/css/mediagallery.scss',
					scripts: 'wikiamobile_mediagallery_js',
					ttl: ttl,
					callback: function(res){
						var script = res.scripts[0],
							style = res.styles;

						Wikia.processStyle(style);
						Wikia.processScript(script);

						cache && cache.set(cacheKey, [style, script], ttl);
						require(['mediagallery'], function(mg){
							mg.init();
						});
					}
				});
			}
			galleryInited = true;
		}

		wkMdlImages = document.getElementById('wkMdlImages');

		widthFll = wkMdlImages.offsetWidth;
		heightFll = wkMdlImages.offsetHeight;

		require(['pager'], function(pg){
			pager = pg({
				wrapper: wrapper,
				container: wkMdlImages,
				pages: pages,
				pageNumber: current,
				setCancel: function(){
					return (zoomed || zooming);
				},
				onStart: function(){
					zoomable = false;
				},
				onEnd: function(n){
					zoomable = true;
					//make sure user changed page
					if(current !== n) {
						track.event('modal', track.PAGINATE, {
							label: current > n ? 'previous' : 'next'
						});
						current = n;
						sharePopOver && sharePopOver.close();
						refresh();
					}
				},
				circle: true
			});

			function tap(ev){
				ev.stopPropagation();
				resetZoom();
				zoomed = false;
				if(ev.target.id === 'nxtImg') {
					pager.next();
				}else{
					pager.prev();
				}
			}

			//handling next/previous image
			if(imagesLength > 1){
				document.getElementById('nxtImg').addEventListener('click', tap);
				document.getElementById('prvImg').addEventListener('click', tap);
			}

			addZoom();

			//setupImage and get references to currentImage and it's style property
			refresh();
		});

		shareBtn = document.getElementById('wkShrImg');
		sharePopOver = popover && popover({
			on: shareBtn,
			style: 'left:3px;',
			create: function(cnt){
				cnt.addEventListener(clickEvent, function(){
					track.event('share', track.CLICK, 'file');
				});
			},
			open: function(ev){
				ev.stopPropagation();
				sharePopOver && sharePopOver.changeContent(share(images[current].name));
				track.event('share', track.CLICK, {
					label: 'open'
				});
			},
			close: function(){
				track.event('share', track.CLICK, {
					label: 'close'
				});
			}
		});
	}

	/** @public **/

	return {
		openModal: openModal,
		getImages: function(){
			!inited && setup();
			return images;
		},
		getCurrent: function(){
			return current;
		},
		hideShare: function(){
			if(shareBtn) {shareBtn.style.display = 'none';}
		},
		init: init,
		cleanup: removeZoom
	};
});