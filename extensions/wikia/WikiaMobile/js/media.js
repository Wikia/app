/*global define, modal, WikiaMobile */
/**
 * Media handling in Wikia Mobile
 *
 * @author Jakub "Student" Olek
 */
define('media', ['modal', 'loader','querystring', 'popover', 'track', 'events', 'share'], function(modal, loader, qs, popover, track, events, share){
	/** @private **/

	var	images = [],
		fllScrImg,
		fllStyle,
		imagesLength,
		current = 0,
		shrImg = (new qs()).getVal('image'),
		clickEvent = events.click,
		touch = events.touch,
		move = events.move,
		end = events.end,
		cancel = events.cancel,
		sharePopOver,
		content = '<div id=fllScrImg></div>',
		//zoom variables
		wrapper,
		startX, startY,
		touched,
		zoomed,
		zooming,
		currentSize,
		computedStyle,
		sx, sy,
		widthFll, heightFll,
		startD;

	function init(){
		var	number = 0, href = '', name = '', nameMatch = /[^\/]*\.\w*$/,
			i, j, elm,
			elements = $('.infobox .image, .wkImgStk, figure').not('.wkImgStk > figure'),
			l = elements.length,
			img, cap;

		for(j = 0; j < l; j++){
			var element = elements[j],
				className = element.className,
				leng;

			if(className.indexOf('image') > -1){
				href = element.href;
				name = element.attributes['data-image-name'].value.replace('.','-');
				if(name === shrImg) shrImg = number;
				images.push([href, name, false]);
				element.setAttribute('data-num', number++);
			}else if(className.indexOf('wkImgStk') > -1){
				if(className.indexOf('grp') > -1) {
					var figures = element.getElementsByTagName('figure');

					leng = figures.length;

					element.setAttribute('data-num', number);

					element.getElementsByTagName('footer')[0].insertAdjacentHTML('beforeend', leng);

					for(i=0; i < leng; i++){
						elm = figures[i];
						img = elm.getElementsByClassName('image')[0];
						if(img){
							href = img.href;
							name = img.id;
							images.push([
								href, name, false,
								(cap = elm.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:'',
								i, leng
							]);

							if(name === shrImg) shrImg = number + i;
						}
					}
				} else {
					leng = parseInt(element.attributes['data-img-count'].value, 10);
					var	lis = element.getElementsByTagName('li');

					element.setAttribute('data-num', number);

					for(i=0; i < leng; i++){
						elm = lis[i];
						href = elm.attributes['data-img'].value;
						name = href.match(nameMatch)[0].replace('.','-');
						images.push([
							href,
							name,
							false,
							elm.innerHTML,
							//I need these number to show counter in a modal
							i, leng
						]);

						if(name === shrImg) shrImg = number + i;
					}
				}
				number += leng;
			} else {
				img = element.getElementsByClassName('image')[0];
				if(img){
					var videoattr = img.getAttribute('data-video-name'),
						isvideo = videoattr ? true : false;

					name = isvideo ? videoattr : img.id;
					if(name === shrImg) shrImg = number;
					images.push([
						img.href, name, isvideo,
						(cap = element.getElementsByClassName('thumbcaption')[0])?cap.innerHTML:''
					]);
					element.setAttribute('data-num', number++);
				}
			}
		}

		imagesLength = images.length;

		if(imagesLength > 1) content = '<div class=chnImg id=prvImg></div>' + content + '<div class=chnImg id=nxtImg></div>';

		//if url contains image=imageName - open modal with this image
		if(shrImg > -1) setTimeout(function(){openModal(shrImg)}, 2000);

		$(document.body).delegate('.infobox .image, figure, .wkImgStk', clickEvent, function(event){
			event.preventDefault();
			event.stopPropagation();
			var num = (this.attributes['data-num'] || this.parentElement.attributes['data-num']).value;

			if(num) openModal(num);
		});
	}

	function loadImage(){
		var image = images[current],
			img;

		fllScrImg.innerHTML = '';
		loader.show(fllScrImg, {center: true});

		if(image[2]) {// video
			fllScrImg.style.backgroundImage = 'none';
			$.ajax({
				url: wgScript,
				data: {
					action: 'ajax',
					method: 'ajax',
					rs: 'ImageLightboxAjax',
					maxheight: window.innerHeight,
					maxwidth: window.innerWidth - 100,
					pageName: wgPageName,
					share: 0,
					title: image[1],
					showEmbedCodeInstantly: true
				},
				dataType: 'json',
				success: function(res) {
					loader.hide(fllScrImg);
					fllScrImg.innerHTML = '<table id="wkVi"><tr><td>'+res.html+'</td></tr></table>';
				}
			});
		} else {
			img = new Image();
			img.src = image[0];
			fllStyle.backgroundImage = 'none';
			resetZoom();
			img.onload = function() {
				loader.hide(fllScrImg);
				fllStyle.backgroundImage = 'url("' + img.src + '")';
			};
		}

		modal.setCaption(getCaption(current));
	}

	function loadPrevImage(ev){
		ev.stopPropagation();

		if(zoomed && ev.type != 'click') return;

		zoomed = false;
		current -= 1;

		if(current < 0) {
			current = imagesLength-1;
		}

		track('modal/image/prev');
		loadImage();
	}

	function loadNextImage(ev){
		ev.stopPropagation();

		if(zoomed && ev.type != 'click') return;
		zoomed = false;
		current += 1;

		if(imagesLength <= current) {
			current = 0;
		}

		track('modal/image/next');
		loadImage();
	}

	function getCaption(num){
		var img = images[num],
			cap = img[3] || '',
			number = img[4],
			length = img[5];

		if(number >= 0 && length >= 0) {
			cap += '<div class=wkStkFtr> ' + (number+1) + ' / ' + length + ' </div>';
		}

		return cap;
	}

	function ondblTap(ev){
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
			fllStyle.backgroundSize = 'cover';
			//trackObj.ga_label = 'zoom-in';
		}

		//WikiaTracker.trackEvent(trackObj);

		onZoom();
	}

	function onZoom(state){
		zoomed = (state != undefined) ? state : !zoomed;
		modal.hideUI();
	}

	//for the ones that does not have ev.scale...
	function distance(a,b){
		var x = b.clientX - a.clientX,
			y = b.clientY - a.clientY;

		return Math.sqrt((x * x) + (y * y));
	}

	function onStart(ev){
		var touches = ev.touches,
			l = touches ? touches.length : 0,
			computedStyle = getComputedStyle(fllScrImg);

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

		if(l == 2 && !ev.scale){
			startD = distance(touches[0], touches[1])
		}
	}

	function onMove(ev){
		var touches = ev.touches,
			l = touches ? touches.length : 0,
			zoom,
			scale;

		ev.preventDefault();

		if(l == 1 && zoomed) {
			var touch = touches[0],
				x = (((startX - touch.clientX) / widthFll) * 100) + sx,
				y = (((startY - touch.clientY) / heightFll) * 100) + sy;

			fllStyle.backgroundPosition =  Math.min(Math.max(x, 0), 100) + '% ' + Math.min(Math.max(y, 0), 100) + '%';

			modal.hideUI();
		}

		if(l == 2){
			scale = ev.scale || distance(touches[0], touches[1]) / startD;
			//max 3x min 1x
			zoom = Math.min(Math.max(~~(currentSize * scale), 100), 300);

			zooming = (scale > 1) ? 'zoom-in' : 'zoom-out';

			if(zoom > 100){
				fllStyle.backgroundSize = zoom + '%';
				onZoom(true)
			}else{
				resetZoom();
				onZoom(false);
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
		fllStyle.backgroundPosition = '50% 50%';
		fllStyle.backgroundSize = 'contain';
	}

	function addZoom(){
		wrapper.addEventListener(touch, onStart);
		wrapper.addEventListener(move, onMove);
		wrapper.addEventListener(end, onEnd);
		wrapper.addEventListener(cancel, onEnd);
	}

	function removeZoom(){
		wrapper.removeEventListener(touch, onStart);
		wrapper.removeEventListener(move, onMove);
		wrapper.removeEventListener(end, onEnd);
		wrapper.removeEventListener(cancel, onEnd);
	}

	function openModal(num){
		current = Math.round(num);

		modal.open({
			content: content,
			toolbar: '<div class=wkShr id=wkShrImg>',
			classes: 'imgMdl',
			onClose: removeZoom
		});

		//setup of zoom
		wrapper = modal.getWrapper();

		fllScrImg = document.getElementById('fllScrImg');
		fllStyle = fllScrImg.style;

		widthFll = fllScrImg.offsetWidth;
		heightFll = fllScrImg.offsetHeight;

		addZoom();
		//end of zoom setup

		loadImage();

		//handling next/previous image
		if(imagesLength > 1){
			$(document.getElementById('nxtImg')).bind('swipeLeft ' + clickEvent, loadNextImage);
			$(document.getElementById('prvImg')).bind('swipeRight ' + clickEvent, loadPrevImage);
			$(fllScrImg).bind('swipeLeft', loadNextImage)
				.bind('swipeRight', loadPrevImage);
		}

		sharePopOver = popover({
			on: document.getElementById('wkShrImg'),
			style: 'left:3px;',
			create: function(cnt){
				$(cnt).delegate('li', clickEvent, function(){
					track('modal/share/' + this.className.replace('Shr',''));
				});
			},
			open: function(ev){
				ev.stopPropagation();
				sharePopOver.changeContent(share(images[current][1]));
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
		getCurrentImg: function(){
			return images[current];
		},
		init: init
	}
});