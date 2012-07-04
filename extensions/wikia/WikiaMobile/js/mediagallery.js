/*global  */
/**
 * Handling of Gallery view of images on a page in a Lighbox
 *
 * @author Jakub "Student" Olek
 */
define('mediagallery', ['media', 'modal', 'pager'], function(med, mod, pag) {
	var imagesize,
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
		imgsPerPage = 9,
		width;

	modalWrapper.addEventListener('tap', function (ev) {
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
		} else if (target.className.indexOf('galImg') > -1) {
			goBackToImgModal(~~target.id.slice(3));

			//open/close gallery
		} else if (target.id === 'wkGalTgl') {
			if(modalWrapper.className.indexOf('wkMedGal') > -1) {
				goBackToImgModal(goToImg);
			} else {
				open();
			}
		}
	}, true);

	function loadImages(){
		var slice = Array.prototype.slice,
			//this gives me a chance to first load current page then next and at the end prev
			all = slice.call(modalWrapper.querySelectorAll('.current .galImg')).concat(
				slice.call(modalWrapper.querySelectorAll('.prev .galImg'))
			).concat(
				slice.call(modalWrapper.querySelectorAll('.next .galImg'))
			),
			i = 0,
			l = all.length,
			updateImg = function(img, src){
				if(src) img.style.backgroundImage = 'url("' + src + '")';
				img.className += ' loaded';
			}

		for(; i < l; i++){
			var imgPreload,
				img = all[i];

			if(!img.style.backgroundImage) {
				imgPreload = new Image();
				imgPreload.src = img.getAttribute('data-img');

				if(imgPreload.complete){
					updateImg(img, imgPreload.src);
				}else{
					imgPreload.onload = (function(img, src){
						//as there are more images I need to freeze references to img and src
						return function(ev){
							if(img.className.indexOf(' load') == -1) img.className += ' load';

							setTimeout(function(){
								updateImg(img, src);
							},200);
						}
					})(img, imgPreload.src);
				}
			}else{
				updateImg(img);
			}
		}
	};

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
		var dots,
			pagesNum;

		width = gal.offsetWidth;
		if(width > 600) {
			imagesize = 145; //width + margin
		}else{
			imagesize = 105; //width + margin
		}

		imgsPerPage = ~~((gal.offsetHeight - 50)/imagesize) * ~~(width/imagesize)
		pagesNum = 0;
		dots = '<div class="dot' + ((current == 0) ? ' curr':'') + '" id=dot0><div></div></div>';
		pages.length = 0;
		pages[pagesNum] = '<div>';

		for (i = 0;i < images.length; i++) {
			if(i > 0 && (i%imgsPerPage) === 0){
				pages[pagesNum++] += '</div>';
				pages[pagesNum] = '<div>';
				dots += '<div class="dot'+((current == pagesNum) ? ' curr':'')+'" id=dot'+pagesNum+'><div></div></div>';
			}

			pages[pagesNum] += '<div class="galImg' +
				(images[i].isVideo ? ' video' : '') +
				((goToImg == i) ? ' this' : '') +
				//use thumb if is available if not use full image
				'" data-img="' + (images[i].thumb || images[i].image) +
				'" id=img' + i + '></div>';
		}

		pages[pagesNum] += '</div>';

		pagination.innerHTML = dots;

		paginationWidth = (pagesNum * 18);
		dotsPerWidth = ~~(width / 18);

		if(paginationWidth > width){
			paginationStyle.width = paginationWidth + 'px';
		}else{
			paginationStyle.width = '';
		}
	}

	function updateDots(){
		var curr;

		if(curr = pagination.getElementsByClassName('curr')[0]) curr.className = 'dot';
		d.getElementById('dot'+ current).className += ' curr';
		paginationStyle.webkitTransform = 'translate3d(' + Math.min(Math.max((~~(dotsPerWidth/2) - current) * 18, (-paginationWidth+width)), 0) + 'px,0,0)';
	}

	function open(){
		var pos;

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
				if(current != currPageNum){
					current = currPageNum;
					loadImages();
					updateDots();
				}
			},
			onResize: function(){
				var img  = current * imgsPerPage;
				prepareGallery();
				current = ~~(img / imgsPerPage);
				pager.reset({
					pages: pages,
					pageNumber: current
				});
				loadImages();
			}
		});

		loadImages();

		mod.addClass('wkMedGal');
	}

	return {
		open: open
	}
});