/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floater', [
		'wikia.window',
		'wikia.document'
	], function (win, doc) {
		'use strict';

		var activeFloatingCssClass = 'floating',
			compatibleSlots = ['TOP_LEADERBOARD'],
			floatingVideoPadding = 28,
			minimumVideoWidth = 225;

		function resetAdContainer(topAds) {
			topAds.style.removeProperty('width');
			topAds.style.removeProperty('height');
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
			a.classList.add('hidden');

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
				elements.topAds.removeChild(floatingContext.closeButton);
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
			var width = Math.max(
					((win.innerWidth - elements.background.offsetWidth) / 2) - floatingVideoPadding, minimumVideoWidth),
				height = width;

			elements.topAds.classList.toggle(activeFloatingCssClass);
			updateDimensions(elements.topAds, width, height);
			updateDimensions(elements.iframe, width, height);
			updateDimensions(elements.imageContainer, width, height);
			updateImage(elements.image, width, height);
			elements.video.resize(width, height);
		}

		function disableFloating(elements, params, imageMarginTop) {
			elements.topAds.classList.toggle(activeFloatingCssClass);
			resetAdContainer(elements.topAds);
			resetDimensions(elements.iframe, params);
			resetDimensions(elements.imageContainer, params);
			resetImage(elements.image, imageMarginTop);
			elements.video.resize(params.width, params.height);
		}

		function enableFloatingOn(video, params, onClose) {
			var topAds = doc.getElementById('WikiaTopAds'),
				threshold = -60,
				scrollYOffset = topAds.offsetTop + topAds.offsetHeight + threshold,
				imageMarginTop,
				floatingContext = {
					onClose: onClose
				},
				imageContainer = params.container.parentElement.querySelector('#image'),
				elements = {
					topAds: topAds,
					background: doc.getElementById('WikiaPageBackground'),
					iframe: params.container.ownerDocument.defaultView.frameElement,
					imageContainer: imageContainer,
					image: imageContainer ? imageContainer.querySelector('img') : null,
					video: video
				};

			if (!floatingContext.closeButton) {
				floatingContext.closeButton = createCloseButton();
				floatingContext.closeButton.addEventListener('click',
					createOnCloseListener(elements, params, floatingContext, imageMarginTop));

				elements.topAds.appendChild(floatingContext.closeButton);
			}

			floatingContext.scrollListener = function () {
				if (win.scrollY > scrollYOffset) {
					if (!floatingContext.floating) {
						if (imageMarginTop === undefined && elements.image) {
							imageMarginTop = elements.image.style.marginTop;
						}

						enableFloating(elements);

						if (floatingContext.closeButton) {
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
