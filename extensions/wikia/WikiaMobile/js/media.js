/*global define, modal, WikiaMobile, wgStyleVersion, wgArticleId */
/**
 * Media handling in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */
define('media', ['JSMessages', 'modal', 'throbber', 'wikia.querystring', require.optional('popover'), 'track', require.optional('share'), require.optional('wikia.cache'), 'wikia.loader', 'wikia.nirvana', 'wikia.videoBootstrap', 'wikia.media.class', 'toast'],
	function(msg, modal, throbber, QueryString, popover, track, share, cache, loader, nirvana, VideoBootstrap, Media, toast){
	'use strict';
	/** @private **/

	var	transform = (function(style, undef){
			return style.transform !== undef ? 'transform' :
				style.webkitTransform !== undef ? 'webkitTransform' :
				style.oTransform !== undef ? 'oTransform' :
				style.mozTransform !== undef ? 'mozTransform' :
				'msTransform';
		})(document.createElement('div').style),
		images = [],
		elements,
		videoCache = {},
		pager,
		lastNum = 0,
		currentNum = 0,
		currentMedia,
		currentWrapper,
		currentWrapperStyle,
		wkMdlImages,
		qs = new QueryString(),
		shrImg = qs.getVal('file'),
		// index of shared file in array of videos/images on page
		shrImgIdx = -1,
		shareBtn,
		clickEvent = 'click',
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
		inited,
		// Video view click source tracking. Default, before lightbox is opened, is 'embed'.  Other possible values are 'share' and 'lightbox'.
		clickSource = 'embed',
		videoInstance,
		events = {},
		skip = [];

	function trigger(event, data){
		if(events[event]){
			events[event].forEach(function(func) {
				func.call(func, data);
			});
		}
	}

	function setup(){
		var	name,
			i = 0,
			imagesLength = 0,
			element,
			imageData,
			j,
			l,
			data;

		//loop that gets all media from a page
		while(element = elements[i++]) {
			var params = element.getAttribute('data-params') || false;

			data = JSON.parse(params);

			if(data && data instanceof Array){
				j = 0;

				element.setAttribute('data-num', imagesLength);

				l = data.length;

				while(imageData = data[j++]){
					name = imageData.name;

					if (name === shrImg) {
							shrImgIdx = imagesLength;
					}

					images[imagesLength] = new Media({
						element: element,
						image: imageData,
						length: l,
						number: j,
						imgNum: imagesLength++
					});
				}
			}
		}

		elements = null;

		data = {
			images: images,
			skip: skip
		};

		trigger('setup', data);

		if(images.length > 1) {
			content = '<div class=chnImg id=prvImg></div>' + content + '<div class=chnImg id=nxtImg></div>';
			toolbar += '<div id=wkGalTgl></div>';
		}

		//this function should not run twice
		inited = true;
	}

	function init(elementList){

		elements = elementList;

		//if url contains file=fileName - setup and find the image/video
		if(shrImg) {
			!inited && setup();
			if ( shrImgIdx > -1 ) {
				// file specified in querystring exists on the page - show it in a modal
				// after a short delay so the user will know they are on an article page
				setTimeout(function(){
					clickSource = 'share';
					openModal(shrImgIdx);
				}, 2000);
			} else {
				// file specified in querystring doesn't exist on the page
				toast.show( msg('wikiamobile-shared-file-not-available') );
				if(!Features.gameguides){
					qs.removeVal( 'file' ).replaceState();
				}
			}
		}

		document.body.addEventListener(clickEvent, function(event){
			var t = event.target,
				className = t.className,
				isSmall = (className.indexOf('small') > -1),
				isMedia = (className.indexOf('media') > -1);

			if(isSmall || isMedia) {
				event.preventDefault();
				event.stopPropagation();
			}

			//if this image is a linked image don't open modal
			if(isMedia){
				!inited && setup();

				if(className.indexOf('Wikia-video-thumb') > -1) {track.event('video', track.CLICK, {label: 'article'});}

				openModal(~~t.getAttribute('data-num'));
			}
		}, true);
	}

	function handleError(msg){
		modal.setCaption(msg || '');
		modal.showUI();
		//for a support of not prefixed transform refer to:
		//http://caniuse.com/#feat=transforms2d
		currentWrapperStyle.webkitTransform = 'scale(1)';
		currentWrapper.className += ' imgPlcHld';
	}

	function embedVideo(image, data, cs) {
		videoInstance = new VideoBootstrap(image, data, cs);
		// Future video/image views will come from modal
		clickSource = 'lightbox';
	}

	function setupImage(){
		var video,
			imgTitle = currentMedia.name,
			// cache value for clickSource to prevent race conditions
			cs = clickSource,
			// grab the querystring for the current url
			currQS = QueryString();

		throbber.remove(currentWrapper);

		modal.setCaption(getCaption());

		// If a video uses a timeout for tracking, clear it
		if ( videoInstance ) {
			videoInstance.clearTimeoutTrack();
		}

		if(currentMedia.type === Media.types.VIDEO) {
			zoomable = false;

			if(videoCache[imgTitle]){
				embedVideo(currentWrapper, videoCache[imgTitle], cs);
			}else{
				if(currentMedia.supported) {
					currentWrapper.innerHTML = '';

					throbber.show(currentWrapper, {
						center: true
					});

					nirvana.getJson(
						'VideoHandler',
						'getEmbedCode',
						{
							fileTitle: imgTitle,
							width: window.innerWidth - 100,
							autoplay: 1
						}
					).done(
						function(data) {
							throbber.remove(currentWrapper);

							if(data.error){
								handleError(data.error);
							}else{
								var videoData = data.embedCode;

								if(videoData.html) {
									videoData.html = '<div class=player>' + videoData.html + '</div>';
								}

								videoCache[imgTitle] = videoData;

								embedVideo(currentWrapper, videoData, cs);
							}
						}
					);
				} else {
					var html = '<div class=not-supported><span>' +
						msg('wikiamobile-video-not-friendly-header') + '</span>' +
						currentWrapper.innerHTML + '<span>' +
						msg('wikiamobile-video-not-friendly') +
						'</span></div>';

					videoCache[imgTitle] = {
						html: html
					};

					currentWrapper.innerHTML = html;
				}
			}

			// update url for sharing
			if(!Features.gameguides){
				currQS.setVal( 'file', imgTitle, true ).replaceState();
			}
		}else if(currentMedia.type == Media.types.IMAGE){
			var img = new Image();
			img.src = currentMedia.url;

			zoomable = true;

			if(!img.complete){
				img.onload = function(){
					throbber.remove(currentWrapper);

					var image = currentWrapper.getElementsByTagName('img')[0];
					origW = image.width;
					origH = image.height;
				};

				img.onerror = function(){
					throbber.remove(currentWrapper);

					var image = currentWrapper.getElementsByTagName('img')[0];

					if(image) {
						image.parentElement.removeChild(image);
					}

					handleError(msg('wikiamobile-image-not-loaded'));
				};

				throbber.show(currentWrapper, {
					center: true
				});
			}else{
				img = currentWrapper.getElementsByTagName('img')[0];
				origW = img.width;
				origH = img.height;
			}

			// update url for sharing
			if(!Features.gameguides){
				currQS.setVal( 'file', imgTitle, true ).replaceState();
			}
		} else if(currentMedia.type){//custom
			var data = {
					currentNum: currentNum,
					wrapper: currentWrapper,
					zoomable: zoomable
				};

			trigger(currentMedia.type, data);

			//If anything was changed in event listeners
			//change it in media module as well
			if(data.zoomable != zoomable){
				zoomable = data.zoomable
			}

			// We're showing an ad or other custom media type.  Don't support sharing.
			if(!Features.gameguides){
				currQS.removeVal( 'file' ).replaceState();
			}
		}

		// Future video/image views will come from modal
		clickSource = 'lightbox';

		//remove any left videos from DOM
		//videos tend to be heavy on resources we shouldn't have more than one at a time
		if(video = document.querySelector('.swiperPage:not(.current) .player')) {
			video.parentElement.removeChild(video);
		}
	}

	function getCaption(){
		var cap = currentMedia.caption,
			number = currentMedia.number,
			length = currentMedia.length,
			figCap;

		if(typeof cap !== 'string'){
			if(cap) {
				if(typeof cap == 'function') {
					cap = cap();
				} else {
					//if caption is not a string and img.caption is set to true grab it from DOM
					figCap = currentMedia.element.parentElement.parentElement.getElementsByClassName('thumbcaption')[0];

					cap = figCap ? figCap.innerHTML : '';
					//and then cache it in media object
					currentMedia.caption = cap;
				}
			}else{
				cap = '';
				currentMedia.caption = '';
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

		if(ev.target.className.indexOf('chnImg') == -1) {
			if(zoomed){
				resetZoom();
			}else{
				currentZoom = 2;
				currentWrapperStyle[transform] = 'scale(2)';
			}

			onZoom();
		}
	}

	function onZoom(state){
		zoomed = (state === undefined) ? !zoomed : state;

		imgW = origW * currentZoom;
		imgH = origH * currentZoom;

		xMax = ((imgW + 40) / 2 - widthFll / 2);
		yMax = ((imgH + 40) / 2 - heightFll / 2);

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

				currentWrapperStyle[transform] = 'scale(' + currentZoom + ') translate(' + -dx / currentZoom + 'px,' + -dy / currentZoom + 'px)';

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

							currentWrapperStyle[transform] = 'scale(' + newZoom + ')';

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
		if(currentWrapperStyle) currentWrapperStyle[transform] = '';
	}

	function addZoom(){
		zoomed = false;
		resetZoom();
		wrapper.addEventListener('touchstart', onStart);
	}

	function removeZoom(){
		wrapper.removeEventListener('touchstart', onStart);
	}

	function toggleGallery(show){
		var gallery = document.getElementById('wkGalTgl');

		if(gallery) {
			gallery.style.display = show ? 'block' : 'none';
		}
	}

	function refresh(){
		currentWrapper = wkMdlImages.getElementsByClassName('current')[0];
		currentWrapperStyle = currentWrapper.style;

		// GameGuides has no share button
		if( shareBtn ) {
			shareBtn.style.display = 'block';
		}
		toggleGallery(true);
		setupImage();
	}

	function getMediaNumber(num, reverse) {
		var add = 0;
		//count how many images have to be skipped
		//to correctly get to an image
		//also support reverse lookup
		skip.every(function(val){
			if(reverse) {
				if(val < num){
					add--;
					return true;

				}
			}else {
				if(val <= num){
					num++;
					return true;
				}
			}
		});

		return num + add;
	}

	function openModal(num){
		var cacheKey = 'mediaGalleryAssets',
			galleryData,
			ttl = 604800; //7days

		currentNum = getMediaNumber(~~num);
		currentMedia = images[currentNum];

		modal.open({
			content: content,
			toolbar: toolbar,
			classes: 'imgMdl',
			onClose: function(){
				pager.cleanup();
				removeZoom();

				// remove file=title from URL
				if(!Features.gameguides){
					qs.removeVal( 'file' ).replaceState();
				}
				// reset tracking clickSource
				clickSource = 'embed';
			},
			onResize: function(ev){
				resetZoom();

				widthFll = ev.width;
				heightFll = ev.height;

				var image = currentWrapper.getElementsByTagName('img')[0];

				if(image) {
					origW = image.width;
					origH = image.height;
				}

				sx = sy = dx = dy = 0;

				onZoom(false);
			}
		});

		wrapper = modal.getWrapper();

		if(images.length > 1 && !galleryInited) {
			//in GG all assets are loaded upfront
			if(Features.gameguides) {
				require(['mediagallery'], function(mg){
					mg.init();
				});
			} else {
				galleryData = cache && cache.getVersioned(cacheKey);

				if(galleryData){
					loader.processStyle(galleryData[0]);
					loader.processScript(galleryData[1]);
					require(['mediagallery'], function(mg){
						mg.init();
					});
				}else{
					loader({
						type: loader.MULTI,
						resources: {
							styles: '/extensions/wikia/WikiaMobile/css/mediagallery.scss',
							scripts: 'wikiamobile_mediagallery_js',
							ttl: ttl
						}
					}).done(
						function(res){
							var script = res.scripts,
								style = res.styles;

							loader.processStyle(style);
							loader.processScript(script);

							cache && cache.setVersioned(cacheKey, [style, script], ttl);
							require(['mediagallery'], function(mg){
								mg.init();
							});
						}
					);
				}
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
				pages: images,
				pageNumber: currentNum,
				setCancel: function(){
					return (zoomed || zooming);
				},
				onStart: function(){
					zoomable = false;
				},
				onEnd: function(image, page, currentPageNum){
					zoomable = true;

					currentMedia = image;
					lastNum = currentNum;
					currentNum = currentPageNum;

					//make sure user changed page
					if(currentNum !== lastNum) {
						track.event('modal', track.PAGINATE, {
							label: currentNum > lastNum ? 'next' : 'previous'
						});

						currentWrapper = page;

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
			if(images.length > 1){
				document.getElementById('nxtImg').addEventListener('click', tap);
				document.getElementById('prvImg').addEventListener('click', tap);
			}

			addZoom();

			//setupImage and get references to currentWrapper and it's style property
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
				sharePopOver && sharePopOver.changeContent(share(images[currentNum].name));
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
		getMedia: function(whiteList){
			!inited && setup();

			if(whiteList && whiteList instanceof Array) {
				return images.filter(function(media){
					return whiteList.indexOf(media.type) != -1;
				});
			}else {
				return images
			}

		},
		getCurrent: function(){
			return currentNum;
		},
		getCurrentDisplayable: function(){
			return getMediaNumber(currentNum, true);
		},
		hideShare: function(){
			if(shareBtn) {shareBtn.style.display = 'none';}
		},
		init: init,
		cleanup: removeZoom,
		on: function(event, func){
			if(!events.hasOwnProperty(event)){
				events[event] = [func]
			}else{
				events[event].push(func)
			}
		},
		remove: function(event, func){
			if(events.hasOwnProperty(event)){
				events[event] = events[event].filter(function(callback){
					return callback != func;
				})
			}

		},
		skip: function(){
			if(currentNum - lastNum > 0) {
				pager.next();
			}else{
				pager.prev();
			}
		},
		toggleGallery: toggleGallery,
		resetZoom: resetZoom
	};
});