/*global define  */
/**
 * Handling of Gallery view of images on a page in a Lighbox
 *
 * @author Jakub "Student" Olek
 *
 */
define('mediagallery', ['media', 'modal', 'pager', 'thumbnailer', 'lazyload', 'track'], function(med, mod, pag, thumbnailer, lazyload, track) {
	'use strict';

	var MAX_THUMB_SIZE = 140,
		width,
		imagesize,
		d = document,
		pager,
		gal,
		pages = [],
		goToImg,
		i,
		dotsPerWidth,
		modalWrapper = mod.getWrapper(),
		images = med.getImages(),
		pagination,
		paginationStyle,
		paginationWidth,
		current,
		imgsPerPage = 9;

	function init(){
		modalWrapper.addEventListener('click', function (ev) {
			var target = ev.target;

			//go to a specific page
			if (target.parentElement.className.indexOf('dot') > -1) {
				current = ~~target.parentElement.id.slice(3);
				pager.reset({
					pageNumber: current
				});
				loadImages();
				updateDots();

				//open specific image chosen from gallery
			} else if (target.className.indexOf('galPlc img') > -1) {
				goBackToImgModal(~~target.id.slice(3));
				if(target.className.indexOf('video')) {track.event('video', track.CLICK, {label: 'gallery'});}
				//open/close gallery
			} else if (target.id === 'wkGalTgl') {
				if(modalWrapper.className.indexOf('wkMedGal') > -1) {
					track.event('gallery', track.CLICK, {label: 'close'});
					goBackToImgModal(goToImg);
				} else {
					open();
				}
			}
		}, true);
	}

	function loadImages(){
		//this gives me a chance to first load current page then next and at the end prev

		lazyload(modalWrapper.querySelectorAll('.current .img'), true);

		setTimeout(function(){
			lazyload(modalWrapper.querySelectorAll('.next .img'), true);

			setTimeout(function(){
				lazyload(modalWrapper.querySelectorAll('.prev .img'), true);
			}, 100);
		}, 100);
	}

	function goBackToImgModal(img){
		mod.removeClass('wkMedGal');
		pager.cleanup();
		//I am not using here ontransitionEnd as it was finishing too early
		//when trying to go to an image by clicking on thumbnail
		setTimeout(function(){
			med.openModal(img);
			mod.setStopHiding(false);
		}, 401);
	}

	function prepareGallery(){
		width = gal.offsetWidth;
		imagesize = (width > 600 ? MAX_THUMB_SIZE + 5 : 105); //width + margin

		var dots,
			pagesNum,
			cols = ~~(width/imagesize),
			imgL = images.length,
			//how many placeholders need to be added
			//to keep gallery tiles in correct places
			x = (Math.ceil(imgL / cols) * cols) - imgL,
			img,
			thumb,
			isVideo;

		current *= imgsPerPage;
		imgsPerPage = cols * ~~((gal.offsetHeight - 50) / imagesize);

		current = ~~(current / imgsPerPage);
		pagesNum = 0;
		dots = '<div class="dot' + ((current === 0) ? ' curr' : '') + '" id=dot0><div></div></div>';
		pages.length = 0;
		pages[pagesNum] = '<div>';

		for (i = 0;i < imgL; i++) {
			if(i > 0 && (i%imgsPerPage) === 0){
				pages[pagesNum++] += '</div>';
				pages[pagesNum] = '<div>';
				dots += '<div class="dot'+ ((current === pagesNum) ? ' curr':'') + '" id=dot' + pagesNum + '><div></div></div>';
			}

			img = images[i];

			isVideo = img.isVideo;
			thumb = img.thumb;

			//no thumb available, generate one
			if (!thumb) {
				thumb = thumbnailer.getThumbURL(img.url, (isVideo ? 'video' : 'image'), MAX_THUMB_SIZE, MAX_THUMB_SIZE);
			}

			pages[pagesNum] += '<div class="galPlc img' +
				(isVideo ? ' video' : '') +
				((goToImg === i) ? ' this' : '') + '" data-src="' + thumb + '" id=img' + i + '></div>';
		}

		//add placeholders
		while(x--) {pages[pagesNum] += '<div class=galPlc></div>';}

		pages[pagesNum] += '</div>';

		if(pagesNum) {
			//18 is a width of a single dot
			paginationWidth = ((pagesNum + 1) * 18);
			dotsPerWidth = ~~(width / 18);

			paginationStyle.width = (paginationWidth > width ? paginationWidth + 'px' : '');
			pagination.innerHTML = dots;
		}else{
			pagination.innerHTML = '';
		}
	}

	function updateDots(){
		var curr;

		if(curr = pagination.getElementsByClassName('curr')[0]) {curr.className = 'dot';}
		d.getElementById('dot'+ current).className += ' curr';
		paginationStyle.webkitTransform = 'translate3d(' + Math.min(Math.max((~~(dotsPerWidth/2) - current) * 18, (-paginationWidth+width)), 0) + 'px,0,0)';
	}

	function open(){
		goToImg = med.getCurrent();
		med.hideShare();
		med.cleanup();
		mod.setStopHiding(true);
		mod.setContent('<div id=wkGal></div><div id=wkGalPag></div>');
		mod.setCaption('');

		gal = d.getElementById('wkGal');
		pagination = d.getElementById('wkGalPag');
		paginationStyle = pagination.style;
		current = ~~(goToImg/imgsPerPage);
		prepareGallery();

		pager = pag({
			container: gal,
			pages: pages,
			pageNumber: current,
			center: true,
			onEnd: function(currPageNum){
				if(current !== currPageNum){
					track.event('gallery', track.PAGINATE, {
						label: (current < currPageNum ? 'next' : 'previous')
					});
					current = currPageNum;
					loadImages();
					updateDots();
				}
			},
			onResize: function(){
				prepareGallery();
				pager.reset({
					pages: pages,
					pageNumber: current
				});
				loadImages();
			}
		});

		loadImages();
		mod.addClass('wkMedGal');

		track.event('gallery', track.CLICK, {label: 'open'});
	}

	return {
		init: init,
		open: open
	};
});