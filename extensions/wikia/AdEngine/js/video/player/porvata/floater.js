/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floater', [
		'wikia.document',
		'wikia.throttle',
		'wikia.window'
	], function (doc, throttle, win) {
		'use strict';

		var activeFloatingCssClass = 'floating',
			compatibleSlots = ['TOP_LEADERBOARD'],
			floatingThreshold = -60,
			floatingVideoPadding = 28,
			minimumVideoWidth = 225;

		function updateDimensions(element, width, height) {
			if (element) {
				element.style.width = width + 'px';
				element.style.height = height + 'px';
			}
		}

		function createCloseButton() {
			var a = doc.createElement('a');

			a.classList.add('floating-close-button');
			a.classList.add('hidden');

			return a;
		}

		function deleteCloseButton(floatingContext) {
			var elements = floatingContext.elements;

			if (elements.closeButton) {
				elements.ad.removeChild(elements.closeButton);
			}
		}

		function createOnCloseListener(floatingContext, params) {
			return function () {
				disableFloating(floatingContext, params);
				win.removeEventListener('scroll', floatingContext.scrollListener);

				if (floatingContext.onClose) {
					floatingContext.onClose();
				}

				deleteCloseButton(floatingContext);
			};
		}

		function resetDimensions(element, params) {
			updateDimensions(element, params.width, params.height);
		}

		function enableFloating(floatingContext) {
			var elements = floatingContext.elements,
				width = Math.max(
					((win.innerWidth - elements.background.offsetWidth) / 2) - floatingVideoPadding, minimumVideoWidth),
				height = width;

			elements.topAds.style.height = elements.ad.offsetHeight + 'px';
			elements.topAds.classList.toggle(activeFloatingCssClass);
			updateDimensions(elements.iframe, width, height);
			updateDimensions(elements.imageContainer, width, height);
			elements.video.resize(width, height);
		}

		function disableFloating(floatingContext, params) {
			var elements = floatingContext.elements;

			elements.topAds.classList.toggle(activeFloatingCssClass);
			elements.topAds.style.removeProperty('height');
			resetDimensions(elements.iframe, params);
			resetDimensions(elements.imageContainer, params);
			elements.video.resize(params.width, params.height);
		}

		function createOnScrollListener(floatingContext, params) {
			var elements = floatingContext.elements,
				topAds = elements.topAds,
				scrollYOffset = topAds.offsetTop + topAds.offsetHeight + floatingThreshold;

			return function () {
				if (win.scrollY > scrollYOffset) {
					if (!floatingContext.floating) {
						enableFloating(floatingContext);

						if (elements.closeButton) {
							elements.closeButton.classList.remove('hidden');
						}

						floatingContext.floating = true;
					}
				} else {
					if (floatingContext.floating) {
						disableFloating(floatingContext, params);

						if (elements.closeButton) {
							elements.closeButton.classList.add('hidden');
						}

						if (floatingContext.videoEnded) {
							win.removeEventListener('scroll', floatingContext.scrollListener);

							deleteCloseButton(floatingContext);
						}

						floatingContext.floating = false;
					}
				}
			};
		}

		function enableFloatingOn(video, params, onClose) {
			var topAds = doc.getElementById('WikiaTopAds'),
				elements = {
					topAds: topAds,
					ad: topAds.querySelector('.wikia-ad'),
					background: doc.getElementById('WikiaPageBackground'),
					iframe: params.container.ownerDocument.defaultView.frameElement,
					imageContainer: params.container.parentElement.querySelector('#image'),
					video: video
				},
				floatingContext = {
					elements: elements,
					onClose: onClose
				};

			if (!elements.closeButton) {
				elements.closeButton = createCloseButton();
				elements.closeButton.addEventListener('click',
					createOnCloseListener(floatingContext, params));

				elements.ad.appendChild(elements.closeButton);
			}

			floatingContext.scrollListener = throttle(createOnScrollListener(floatingContext, params), 100);

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
