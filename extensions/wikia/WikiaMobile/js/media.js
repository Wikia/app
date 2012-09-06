/*global define, modal, WikiaMobile */
/**
 * Media handling in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */
define('media', ['modal', 'loader', 'querystring', 'popover', 'track', 'events', 'share', 'cache'], function(modal, loader, qs, popover, track, events, share, cache){
	/** @private **/

	var	images = [],
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
		zoomed,
		zooming,
		currentSize,
		sx,
		sy,
		widthFll,
		heightFll,
		startD,
		galleryInited = false,
		imgNameProcessRegEx = new RegExp(' ', 'g'),
		inited;

	function oldInit() {
		var	number = 0, href = '', name = '', nameMatch = /[^\/]*\.\w*$/,
			i, j, elm,
			elements = $('.infobox .image, .wkImgStk, figure').not('.wkImgStk > figure'),
			l = elements.length,
			img, cap,
			element,
			className,
			leng,
			figures,
			lis,
			imgCnt;

		for (j = 0; j < l; j++) {
			element = elements[j];
			className = element.className;

			//get image form infobox
			if(className.indexOf('image') > -1){
				href = element.href;
				name = encodeImageName(element.getAttribute('data-image-name'));
				if (name === shrImg) shrImg = number;
				images.push({
					image: href,
					name: name,
					isVideo: false
				});
				element.setAttribute('data-num', number++);

			//get images from image stacks
			}else if (className.indexOf('wkImgStk') > -1){

				//handle images from grouped images
				if (className.indexOf('grp') > -1) {
					figures = element.getElementsByTagName('figure');

					leng = figures.length;

					element.setAttribute('data-num', number);
					element.getElementsByTagName('footer')[0].insertAdjacentHTML('beforeend', leng);

					imgCnt = 0;

					for (i = 0; i < leng; i++) {
						elm = figures[i];
						img = elm.getElementsByClassName('image')[0];
						if (img) {
							href = img.href;
							name = encodeImageName(img.getAttribute('data-image-name'));
							images.push({
								image: href,
								name: name,
								isVideo: false,
								caption: (cap = elm.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:'',
								number: i,
								length: leng
							});

							imgCnt += 1;

							if(name === shrImg) shrImg = number + imgCnt;
						}
					}

					leng = imgCnt;

				//handle images from galleries/slideshows
				} else {
					leng = parseInt(element.getAttribute('data-img-count'), 10);
					lis = element.getElementsByTagName('li');

					element.setAttribute('data-num', number);

					for (i=0; i < leng; i++) {
						elm = lis[i];
						href = elm.getAttribute('data-img');

						images.push({
							image: href,
							thumb: elm.getAttribute('data-thumb'),
							//TODO the href.match part is legacy for old parser cache, remember to remove it!
							name: encodeImageName(elm.getAttribute('data-name') || href.match(nameMatch)[0].replace('.','-')),
							isVideo: false,
							caption: elm.innerHTML,
							//I need these number to show counter in a modal
							number: i,
							length: leng
						});

						if (name === shrImg) shrImg = number + i;
					}
				}

				number += leng;

			//get normal images on a page
			} else {
				img = element.getElementsByClassName('image')[0];
				if(img){
					var videoattr = img.getAttribute('data-video-name');
					name = encodeImageName(videoattr || img.getAttribute('data-image-name'));
					href = (!!videoattr ? img.getElementsByClassName('Wikia-video-thumb')[0].src : img.href);

					if(name === shrImg) shrImg = number;
					images.push({
						image: href,
						name: name,
						isVideo: !!videoattr,
						caption: (cap = element.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:''
					});
					element.setAttribute('data-num', number++);
				}
			}
		}

		imagesLength = images.length;

		for(i = 0; i < imagesLength; i++){
			pages[i] = '<div style="background-image: url(' + images[i].image + ')"></div>';
		}

		if(imagesLength > 1) {
			content = '<div class=chnImg id=prvImg></div>' + content + '<div class=chnImg id=nxtImg></div>';
			toolbar += '<div id=wkGalTgl></div>';
		}

		//if url contains image=imageName - open modal with this image
		if(shrImg > -1) setTimeout(function(){openModal(shrImg);}, 2000);

		$(document.body).delegate('.infobox .image, figure, .wkImgStk', clickEvent, function(event){
			event.preventDefault();
			event.stopPropagation();
			var num = ~~(this.getAttribute('data-num') || this.parentElement.getAttribute('data-num'));

			if(num >= 0) {openModal(num);}
		});
	}

	//Media object that holds all data needed to display it in modal/gallery
	function Media(elem, data, length, i){

		this.element = elem;
		this.url = data.full;

		if(data.name) this.name = data.name;
		if(data.thumb) this.thumb = data.thumb;
		if(data.med) this.med = data.med;
		if(data.capt) this.caption = data.capt;
		if(data.type === 'video') this.isVideo = true;

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

					if (name === shrImg) shrImg = imagesLength;

					images[images.length] = new Media(element, imageData, l, j);

					//create pages for modal
					pages[imagesLength++] = '<div style="background-image: url(' + imageData.full + ')"></div>';
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

				openModal(~~t.getAttribute('data-num'));
			}
		}, true);
	}

	function encodeImageName(name){
		return name.replace(imgNameProcessRegEx, '_');
	}

	function handleError(msg){
		modal.setCaption(msg || '');
		modal.showUI();
		currentImage.style.backgroundImage = '';
		currentImage.style.backgroundSize = '50%';
		currentImage.className += ' imgPlcHld';
	}

	function setupImage(){
		var image = images[current];
		loader.hide(currentImage);

		//inject the content only if it was not already there in the page
		//to avoid refresh the contents (it triggers a full
		//reload of iframe contents for videos)
		if (!pager.getCurrent().innerHTML) {
			if(image.isVideo) {// video
				var imgTitle = image.name;
				currentImageStyle.backgroundImage = '';

				if(videoCache[imgTitle]){
					currentImage.innerHTML = '<table id=wkVi><tr><td>'+videoCache[imgTitle]+'</td></tr></table>';
				}else{
					loader.show(currentImage, {
						center: true
					});

					$.nirvana.sendRequest({
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
							loader.hide(currentImage);
							if(!data.error){
								videoCache[imgTitle] = data.embedCode;
								currentImage.innerHTML = '<table id=wkVi><tr><td>' + data.embedCode + '</td></tr></table>';
							}else{
								handleError(data.error);
							}
						}
					});
				}
			}else{
				var img = new Image();
				//TODO: remove after 2 weeks second option
				img.src = image.url || image.image;

				if(!img.complete){
					img.onload = function(){
						loader.hide(currentImage);
					};

					img.onerror = function(){
						loader.hide(currentImage);
						handleError($.msg('wikiamobile-image-not-loaded'));
					};

					loader.show(currentImage, {
						center: true
					});
				}
			}
		}

		modal.setCaption(getCaption(current));
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
				img.caption = cap = '';
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

	/*	var trackObj = {
			ga_category: 'wikiamobile-modal',
			tracking_method: 'both',
			ga_action: WikiaTracker.ACTIONS.DOUBLETAP,
			ga_label: ''
		}
	*/
		if(zoomed){
			resetZoom();
			//trackObj.ga_label = 'zoom-out';
		}else{
			currentImageStyle.backgroundSize = 'cover';
			//trackObj.ga_label = 'zoom-in';
		}

		//WikiaTracker.trackEvent(trackObj);

		onZoom();
	}

	function onZoom(state){
		zoomed = (state != undefined) ? state : !zoomed;
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

		return Math.sqrt((x * x) + (y * y));
	}

	function onStart(ev){
		var touches = ev.touches,
			l = touches.length,
			computedStyle = getComputedStyle(currentImage);

		window.scrollTo(0,1);

		//I need to split it as ios4 adds auto at the end of this property if you set only one % value
		currentSize = ~~computedStyle.backgroundSize.split('%')[0] || 100;

		if(l == 1){
			sx = ~~computedStyle.backgroundPositionX.slice(0,-1);
			sy = ~~computedStyle.backgroundPositionY.slice(0,-1);
			startX = touches[0].clientX;
			startY = touches[0].clientY;

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
			startD = distance(touches[0], touches[1]);
		}
	}

	function onMove(ev){
		var touches = ev.touches,
			l = touches ? touches.length : 0,
			zoom,
			scale;

		ev.preventDefault();

		if(l === 1 && zoomed) {
			var touch = touches[0],
				x = (((startX - touch.clientX) / widthFll) * 100) + sx,
				y = (((startY - touch.clientY) / heightFll) * 100) + sy;

			currentImageStyle.backgroundPosition =  Math.min(Math.max(x, 0), 100) + '% ' + Math.min(Math.max(y, 0), 100) + '%';

			modal.hideUI();
		}

		if(l === 2){
			scale = ev.scale || distance(touches[0], touches[1]) / startD;
			//max 3x min 1x
			zoom = Math.min(Math.max(~~(currentSize * scale), 100), 300);

			if(!zoomed && scale < 1){
				if(!zooming && scale < 0.8){
					require('mediagallery', function(mg){
						mg.open();
					});
				}
			}else {
				zooming = (scale > 1) ? 'zoom-in' : 'zoom-out';

				if(zoom > 100){
					currentImageStyle.backgroundSize = zoom + '%';
					onZoom(true);
				}else{
					resetZoom();
					onZoom(false);
				}
			}
		}
	}

	function onEnd(){
		if(zooming){
			/*WikiaTracker.trackEvent({
				ga_category: 'wikiamobile-modal',
				tracking_method: 'both',
				ga_action: WikiaTracker.ACTIONS.PINCH,
				ga_label: zooming
			});*/
			zooming = '';
		}
	}

	function resetZoom(){
		currentImageStyle.backgroundPosition = '50% 50%';
		currentImageStyle.backgroundSize = 'contain';
	}

	function addZoom(){
		wrapper.addEventListener('touchstart', onStart);
		wrapper.addEventListener('touchmove', onMove);
		wrapper.addEventListener('touchend', onEnd);
		wrapper.addEventListener('touchcancel', onEnd);
	}

	function removeZoom(){
		wrapper.removeEventListener('touchstart', onStart);
		wrapper.removeEventListener('touchmove', onMove);
		wrapper.removeEventListener('touchend', onEnd);
		wrapper.removeEventListener('touchcancel', onEnd);
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

		if(imagesLength > 1 && !galleryInited) {
			galleryData = cache.get(cacheKey);

			if(galleryData){
				Wikia.processStyle(galleryData[0]);
				Wikia.processScript(galleryData[1]);
				require('mediagallery');
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

						cache.set(cacheKey, [style, script], ttl);
						require('mediagallery');
					}
				});
			}
			galleryInited = true;
		}

		//setup of zoom
		wrapper = modal.getWrapper();

		addZoom();
		//end of zoom setup

		wkMdlImages = document.getElementById('wkMdlImages');

		widthFll = wkMdlImages.offsetWidth;
		heightFll = wkMdlImages.offsetHeight;

		require('pager', function(pg){

			pager = pg({
				wrapper: wrapper,
				container: wkMdlImages,
				pages: pages,
				pageNumber: current,
				setCancel: function(){
					return (zoomed || zooming);
				},
				onEnd: function(n){
					current = n;
					sharePopOver.close();
					refresh();
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

			//setupImage and get references to currentImage and it's style property
			refresh();
		});

		shareBtn = document.getElementById('wkShrImg');
		sharePopOver = popover({
			on: shareBtn,
			style: 'left:3px;',
			create: function(cnt){
				$(cnt).delegate('li', clickEvent, function(){
					track('modal/share/' + this.className.replace('Shr',''));
				});
			},
			open: function(ev){
				ev.stopPropagation();
				sharePopOver.changeContent(share(images[current].name));
				//track('modal/share/open');
			},
			close: function(){
				//track('modal/share/close');
			}
		});
	}

	/** @public **/

	return {
		openModal: openModal,
		getImages: function(){
			return images;
		},
		getCurrent: function(){
			return current;
		},
		hideShare: function(){
			if(shareBtn) {shareBtn.style.display = 'none';}
		},
		oldInit: oldInit,
		init: init,
		cleanup: function(){
			removeZoom();
		}
	};
});