/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floater', [
		'wikia.window',
		'wikia.document'
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
			var a = doc.createElement('a');

			a.classList.add('floating-close-button');

			return a;
		}

		function createOnCloseListener(elements, params, floatingContext, imageMarginTop) {
			return function () {
				disableFloating(elements, params, imageMarginTop);
				win.removeEventListener('scroll', floatingContext.scrollListener);

				if (floatingContext.onClose) {
					floatingContext.onClose();
				}

				deleteCloseButton(elements, floatingContext);

			};
		}

		function deleteCloseButton(elements, floatingContext) {
			if (floatingContext.closeButton) {
				elements.top.removeChild(floatingContext.closeButton);
			}
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

		function enableFloating(elements) {
			var width = ((win.innerWidth - elements.background.offsetWidth) / 2) - floatingVideoPadding,
				height = width;

			elements.top.classList.toggle(activeFloatingCssClass);
			updateDimensions(elements.top, width, height);
			updateDimensions(elements.iframe, width, height);
			updateDimensions(elements.imageContainer, width, height);
			updateImage(elements.image, width, height);
			elements.video.resize(width, height);
		}

		function disableFloating(elements, params, imageMarginTop) {
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
				floatingContext = {};

			floatingContext.scrollListener = function () {
				var imageContainer = params.container.parentElement.querySelector('#image'),
					elements = {
						top: top,
						background: doc.getElementById('WikiaPageBackground'),
						iframe: top.querySelector('iframe'),
						imageContainer: imageContainer,
						image: imageContainer ? imageContainer.querySelector('img') : null,
						video: video
					};

				if (win.scrollY > scrollYOffset) {
					if (!floatingContext.floating) {
						if (imageMarginTop === undefined && elements.image) {
							imageMarginTop = elements.image.style.marginTop;
						}

						enableFloating(elements);

						if (!floatingContext.closeButton) {
							floatingContext.onClose = onClose;
							floatingContext.closeButton = createCloseButton();
							floatingContext.closeButton.addEventListener('click',
								createOnCloseListener(elements, params, floatingContext, imageMarginTop));

							elements.top.appendChild(floatingContext.closeButton);
						} else {
							floatingContext.closeButton.classList.remove('hidden');
						}

						floatingContext.floating = true;
					}
				} else {
					if (floatingContext.floating) {
						disableFloating(elements, params, imageMarginTop);

						if (floatingContext.closeButton) {
							floatingContext.closeButton.classList.add('hidden');
						}

						if (floatingContext.videoEnded) {
							win.removeEventListener('scroll', floatingContext.scrollListener);

							deleteCloseButton(elements, floatingContext);
						}

						floatingContext.floating = false;
					}
				}
			};

			return floatingContext;
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
