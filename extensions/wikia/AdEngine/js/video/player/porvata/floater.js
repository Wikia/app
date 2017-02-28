/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floater', [
		'wikia.window',
		'wikia.document',
	], function (win, doc) {
		'use strict';

		var activeFloatingCssClass = 'floating',
			compatibleSlots = ['TOP_LEADERBOARD'],
			floatingVideoPadding = 28;

		function resetAdContainer(top) {
			top.style.removeProperty('width');
			top.style.removeProperty('height');
		}

		function updateDimensions(element, width, height) {
			if (element) {
				element.style.width = width + 'px';
				element.style.height = height + 'px';
			}
		}

		function updateImage(image, width, height) {
			if (image) {
				image.width = width;
				image.style.marginTop = ((height - image.height) / 2) + 'px';
			}
		}

		function createCloseButton() {
			var a = doc.createElement('a'),
				img = doc.createElement('img');

			img.src = 'http://slot1.images.wikia.nocookie.net/__cb1487851645/common/extensions/wikia/ArticleVideo/images/close.svg';
			a.classList.add('floating-close-button');
			a.appendChild(img);

			return a;
		}

		function resetDimensions(element, params) {
			updateDimensions(element, params.width, params.height);
		}

		function resetImage(image, marginTop) {
			if (image) {
				image.removeAttribute('width');
				image.style.marginTop = marginTop;
			}
		}

		function enable(elements) {
			var width = ((win.innerWidth - elements.background.offsetWidth) / 2) - floatingVideoPadding,
				height = width;

			elements.top.classList.toggle(activeFloatingCssClass);
			updateDimensions(elements.top, width, height);
			updateDimensions(elements.iframe, width, height);
			updateDimensions(elements.imageContainer, width, height);
			updateImage(elements.image, width, height);
			elements.video.resize(width, height);
		}

		function disable(elements, params, imageMarginTop) {
			elements.top.classList.toggle(activeFloatingCssClass);
			resetAdContainer(elements.top);
			resetDimensions(elements.iframe, params);
			resetDimensions(elements.imageContainer, params);
			resetImage(elements.image, imageMarginTop);
			elements.video.resize(params.width, params.height);
		}

		function enableFloatingOn(video, params, onClose) {
			var top = doc.getElementById('WikiaTopAds'),
				threshold = 100,
				scrollYOffset = top.offsetTop + top.offsetHeight + threshold,
				imageMarginTop,
				floatignContext = {};

			floatignContext.scrollListener = function () {
				var imageContainer = params.container.parentElement.querySelector('#image'),
					image = imageContainer ? imageContainer.querySelector('img') : null,
					elements = {
						top: top,
						background: doc.getElementById('WikiaPageBackground'),
						iframe: top.querySelector('iframe'),
						imageContainer: imageContainer,
						image: image,
						video: video
					};

				if (win.scrollY > scrollYOffset) {
					if (!floatignContext.floating) {
						if (imageMarginTop === undefined && image) {
							imageMarginTop = image.style.marginTop;
						}

						enable(elements);

						if (!floatignContext.closeButton) {
							floatignContext.closeButton = createCloseButton();
							floatignContext.closeButton.addEventListener('click', function () {
								disable(elements, params, imageMarginTop);
								win.removeEventListener('scroll', floatignContext.scrollListener);

								if (onClose) {
									onClose();
								}
							});

							elements.top.appendChild(floatignContext.closeButton);
						} else {
							floatignContext.closeButton.classList.remove('hidden');
						}

						floatignContext.floating = true;
					}
				} else {
					if (floatignContext.floating) {
						disable(elements, params, imageMarginTop);

						if (floatignContext.closeButton) {
							floatignContext.closeButton.classList.add('hidden');
						}

						if (floatignContext.videoEnded) {
							win.removeEventListener('scroll', floatignContext.scrollListener);
						}

						floatignContext.floating = false;
					}
				}
			};

			return floatignContext;
		}

		function makeFloat(video, params, onClose) {
			var floatingContext = enableFloatingOn(video, params, onClose);

			win.addEventListener('scroll', floatingContext.scrollListener);
			video.addEventListener('wikiaAdCompleted', function () {
				floatingContext.videoEnded = true;
			});

			return floatingContext;
		}

		function canFloat(params) {
			return params.enableLeaderboardFloating && compatibleSlots.indexOf(params.slotName) > -1;
		}

		return {
			canFloat: canFloat,
			makeFloat: makeFloat
		};
	}
);
