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
			videoWidth = 225;

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

				if (floatingContext.onEnd) {
					floatingContext.onEnd();
				}

				deleteCloseButton(floatingContext);
			};
		}

		function resetDimensions(element, params) {
			updateDimensions(element, params.width, params.height);
		}

		function enableFloating(floatingContext) {
			var elements = floatingContext.elements,
				width = videoWidth,
				height = width;

			elements.topAds.style.height = elements.ad.offsetHeight + 'px';
			elements.topAds.classList.toggle(activeFloatingCssClass);
			updateDimensions(elements.imageContainer, width, height);
			elements.video.resize(width, height);

			if (elements.closeButton) {
				elements.closeButton.classList.remove('hidden');
			}

			floatingContext.floating = true;
		}

		function disableFloating(floatingContext, params) {
			var elements = floatingContext.elements;

			elements.topAds.classList.toggle(activeFloatingCssClass);
			elements.topAds.style.removeProperty('height');
			resetDimensions(elements.imageContainer, params);
			elements.video.resize(params.width, params.height);

			if (elements.closeButton) {
				elements.closeButton.classList.add('hidden');
			}

			if (floatingContext.videoEnded) {
				win.removeEventListener('scroll', floatingContext.scrollListener);

				deleteCloseButton(floatingContext);

				if (floatingContext.onEnd) {
					floatingContext.onEnd();
				}
			}

			floatingContext.floating = false;
		}

		function createOnScrollListener(floatingContext, params) {
			var elements = floatingContext.elements,
				topAds = elements.topAds,
				scrollYOffset = topAds.offsetTop + topAds.offsetHeight + floatingThreshold;

			return function () {
				if (win.scrollY > scrollYOffset) {
					if (!floatingContext.floating) {
						enableFloating(floatingContext);
					}
				} else {
					if (floatingContext.floating) {
						disableFloating(floatingContext, params);
					}
				}
			};
		}

		function enableFloatingOn(video, params, onEnd) {
			var topAds = doc.getElementById('WikiaTopAds'),
				elements = {
					topAds: topAds,
					ad: topAds.querySelector('.wikia-ad'),
					imageContainer: params.container.parentElement.querySelector('#image'),
					video: video
				},
				floatingContext = {
					elements: elements,
					onEnd: onEnd
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

		function makeFloat(video, params, onEnd) {
			var floatingContext = enableFloatingOn(video, params, onEnd);

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
