/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floater', [
		'wikia.document',
		'wikia.throttle',
		'wikia.window'
	], function (doc, throttle, win) {
		'use strict';

		var activeFloatingCssClass = 'floating',
			compatibleSlots = ['TOP_LEADERBOARD'],
			events = {
				attach: 'attach',
				detach: 'detach',
				end: 'end',
				start: 'start'
			},
			floatingThreshold = -50,
			state = {
				floating: 'floating',
				never: 'never',
				paused: 'paused',
				stopped: 'stopped'
			},
			videoWidth = 225;

		function fireEvent(floatingContext, eventName) {
			var eventHandler = 'on' + eventName.charAt(0).toUpperCase() + eventName.slice(1);

			if (floatingContext.eventHandlers[eventHandler]) {
				floatingContext.eventHandlers[eventHandler]();
			}
		}

		function updateDimensions(element, width, height) {
			if (element) {
				element.style.width = width + 'px';
				element.style.height = height + 'px';
			}
		}

		function resetDimensions(element, params) {
			updateDimensions(element, params.width, params.height);
		}

		function createCloseButton() {
			var a = doc.createElement('a');

			a.classList.add('floating-close-button');
			a.classList.add('hidden');

			return a;
		}

		function resizeVideoAndShowCloseButton(floatingContext, width, height) {
			var elements = floatingContext.elements;

			elements.video.addEventListener('start', function () {
				elements.video.resize(width, height);
				if (elements.closeButton) {
					elements.closeButton.classList.remove('hidden');
				}
			});

			if (elements.video.isPlaying()) {
				elements.video.resize(width, height);
				if (elements.closeButton) {
					elements.closeButton.classList.remove('hidden');
				}
			}
		}

		function deleteCloseButton(floatingContext) {
			var elements = floatingContext.elements;

			if (elements.closeButton) {
				elements.ad.removeChild(elements.closeButton);
			}
		}

		function endFloating(floatingContext) {
			win.removeEventListener('scroll', floatingContext.scrollListener);
			floatingContext.state = state.stopped;
			fireEvent(floatingContext, events.end);
		}

		function createOnCloseListener(floatingContext, params) {
			return function () {
				disableFloating(floatingContext, params);
				endFloating(floatingContext);
			};
		}

		function enableFloating(floatingContext) {
			var elements = floatingContext.elements,
				width = videoWidth,
				height = width;

			elements.topAds.style.height = elements.ad.offsetHeight + 'px';
			elements.topAds.classList.toggle(activeFloatingCssClass);
			updateDimensions(elements.imageContainer, width, height);

			resizeVideoAndShowCloseButton(floatingContext, width, height);

			floatingContext.state = state.floating;
			fireEvent(floatingContext, events.detach);
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

			if (elements.video.isCompleted()) {
				deleteCloseButton(floatingContext);
				endFloating(floatingContext);
			}

			floatingContext.state = state.paused;
			fireEvent(floatingContext, events.attach);
		}

		function createOnScrollListener(floatingContext, params) {
			var elements = floatingContext.elements,
				topAds = elements.topAds,
				scrollYOffset = topAds.offsetTop + params.height + floatingThreshold;

			return function () {
				if (win.scrollY > scrollYOffset) {
					if (floatingContext.state === state.never || floatingContext.state === state.paused) {
						enableFloating(floatingContext);
					}
				} else {
					if (floatingContext.state === state.floating) {
						disableFloating(floatingContext, params);
					}
				}
			};
		}

		function enableFloatingOn(video, params, eventHandlers) {
			var topAds = doc.getElementById('WikiaTopAds'),
				elements = {
					topAds: topAds,
					ad: topAds.querySelector('.wikia-ad'),
					imageContainer: params.container.parentElement.querySelector('#image'),
					video: video
				},
				floatingContext = {
					elements: elements,
					eventHandlers: eventHandlers,
					state: state.never
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

		function isOutsideOfViewport(params) {
			var slot = doc.querySelector('#' + params.slotName);

			return Boolean(slot && slot.getBoundingClientRect().bottom < 0);
		}

		/**
		 *
		 * @param video - video object
		 * @param params - parameters that video receives
		 * @param eventHandlers - handlers for events that floater exposes:
		 *  - onStart - floating start, after this event element might float if outside of viewport - emitted only once
		 *  - onAttach - after this event element is back to its original place - emitted multiple times, may be emitted before'start' and after 'end'
		 *  - onDetach - after this event element is floating, it is detached form its place - emitted multiple times, may be emitted after 'end'
		 *  - onEnd - floating end, after this event element will never float again - emitted only once
		 * @returns {floatingContext}
		 */
		function makeFloat(video, params, eventHandlers) {
			var floatingContext = enableFloatingOn(video, params, eventHandlers);

			win.addEventListener('scroll', floatingContext.scrollListener);

			if (isOutsideOfViewport(params)) {
				enableFloating(floatingContext);
			}

			fireEvent(floatingContext, events.start);

			return floatingContext;
		}

		/**
		 *
		 * @param params - parameters that video receives
		 * @returns {boolean} - true when floater can make given video & slot floatable
		 */
		function canFloat(params) {
			return params.enableLeaderboardFloating && compatibleSlots.indexOf(params.slotName) > -1;
		}

		function isEnabled(floatingContext) {
			return Boolean(floatingContext && floatingContext.state !== state.stopped);
		}

		return {
			canFloat: canFloat,
			isEnabled: isEnabled,
			makeFloat: makeFloat
		};
	}
);
