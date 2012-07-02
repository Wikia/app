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
			updateDots();

			//open specific image chosen from gallery
		} else if (target.className.indexOf('galImg') > -1) {
			goBackToImgModal(~~target.id.slice(3));

			//open/close gallery
		} else if (target.id === 'wkGalTgl') {
			if(target.className === 'on') {
				goBackToImgModal(goToImg);
			} else {
				target.className = 'on';
				open();
			}
		}
	}, true);

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
			pages[pagesNum] += '<div class="galImg' + (images[i][2] ? ' video' : '') + ((goToImg == i) ? ' this' : '') + '" style="background-image:url('+images[i][0]+')" id=img'+i+'></div>';
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
				current = currPageNum;
				updateDots();
			},
			onResize: function(){
				var img  = current * imgsPerPage;
				prepareGallery();
				current = ~~(img / imgsPerPage);
				pager.reset({
					pages: pages,
					pageNumber: current
				});
			}
		});
		mod.addClass('wkMedGal');
	}

	return {
		open: open
	}
});