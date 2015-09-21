require([
	'wikia.window', 'wikia.document', 'wikia.tracker'
], function(win, doc, tracker) {
	var slider,
		pagerDiv,
		imageNumber,
		imageWidth = 270,
		currentPostion = 0,
		currentImage = 0;

	function init() {
		slider = doc.getElementsByClassName('image_slider')[0];

		if (!slider) {
			return;
		}

		imageNumber = slider.children.length;
		slider.style.width = parseInt(imageWidth * imageNumber) + 'px';

		doc.getElementsByClassName('prev')[0].onclick = function(){ onClickPrev(); };
		doc.getElementsByClassName('next')[0].onclick = function(){ onClickNext(); };

		generatePager(imageNumber);
	}

	function slideTo(imageToGo) {
		var numOfImageToGo = imageToGo - currentImage;
		currentPostion = -1 * currentImage * imageWidth;

		pagerDiv.children[currentImage].style.backgroundColor = 'transparent';
		pagerDiv.children[imageToGo].style.backgroundColor = 'black';

		$(slider).animate({
			left: parseInt(currentPostion - imageWidth * numOfImageToGo) + 'px'
		}, {
			duration: 300,
			complete: function() {
				currentImage = imageToGo;
			}
		});
	}

	function onClickPrev() {
		var targetIndex = currentImage == 0 ? imageNumber - 1 : currentImage - 1;

		slideTo(targetIndex);
	}

	function onClickNext() {
		var targetIndex = currentImage == imageNumber - 1 ? 0 : currentImage + 1;

		slideTo(targetIndex);
	}

	function generatePager(imageNumber) {
		var i, li;
		pagerDiv = doc.getElementsByClassName('pi-pager')[0];

		for (i = 0; i < imageNumber; i++) {
			li = doc.createElement('li');
			pagerDiv.appendChild(li);

			li.onclick = function(i) {
				return function() {
					slideTo(i);
				}
			} (i);
		}
	}

	window.onload = init;
});