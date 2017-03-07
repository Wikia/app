/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floater', [
		'wikia.document',
		'wikia.throttle',
		'wikia.window'
	], function (doc, throttle, win) {
		'use strict';

		var activeFloatingCssClass = 'floating',
			withArticleVideoCssClass = 'with-article-video',
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
			videoWidth = 225,
			wikiFloatingVideoSelector = '.video-container';

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
			var elements = floatingContext.elements,
				listeners = floatingContext.listeners;

			if (!listeners.start) {
				listeners.start = function () {
					if (floatingContext.state === state.floating) {
						elements.video.resize(width, height);
						if (elements.closeButton) {
							elements.closeButton.classList.remove('hidden');

						}
					}
				};
				elements.video.addEventListener('start', listeners.start);
			}

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
			var listeners = floatingContext.listeners;

			win.removeEventListener('scroll', listeners.scroll);
			if (listeners.start) {
				floatingContext.elements.video.removeEventListener('start', listeners.start);
			}
			floatingContext.state = state.stopped;
			fireEvent(floatingContext, events.end);
		}

		function createOnCloseListener(floatingContext, params) {
			return function () {
				disableFloating(floatingContext, params);
				endFloating(floatingContext);
			};
		}

		function enableFloating(floatingContext, params) {
			var elements = floatingContext.elements,
				width = videoWidth,
				height = width;

			elements.topAds.style.height = params.height + 'px';
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

		function isArticleVideoFloating() {
			var element = doc.querySelector(wikiFloatingVideoSelector);

			return element && 'fixed' === win.getComputedStyle(element).position;
		}

		function showAboveArticleVideo(floatingContext) {
			floatingContext.elements.topAds.classList.toggle(withArticleVideoCssClass, isArticleVideoFloating());
		}

		function createOnScrollListener(floatingContext, params) {
			var elements = floatingContext.elements,
				topAds = elements.topAds,
				scrollYOffset = topAds.offsetTop + params.height + floatingThreshold;

			return function () {
				if (win.scrollY > scrollYOffset) {
					showAboveArticleVideo(floatingContext);
					if (floatingContext.state === state.never || floatingContext.state === state.paused) {
						enableFloating(floatingContext, params);
					}
				} else {
					if (floatingContext.state === state.floating) {
						disableFloating(floatingContext, params);
					}
				}
			};
		}

		function selectContainer(params) {
			return params.originalContainer || params.container;
		}

		function enableFloatingOn(video, params, eventHandlers) {
			var topAds = doc.getElementById('WikiaTopAds'),
				elements = {
					topAds: topAds,
					ad: topAds.querySelector('.wikia-ad'),
					imageContainer: selectContainer(params).parentElement.querySelector('#image'),
					video: video
				},
				listeners = {},
				floatingContext = {
					elements: elements,
					eventHandlers: eventHandlers,
					listeners: listeners,
					state: state.never
				};

			if (!elements.closeButton) {
				elements.closeButton = createCloseButton();
				listeners.close = createOnCloseListener(floatingContext, params);
				elements.closeButton.addEventListener('click', listeners.close);

				elements.ad.appendChild(elements.closeButton);
			}

			listeners.scroll = throttle(createOnScrollListener(floatingContext, params), 100);
			win.addEventListener('scroll', listeners.scroll);

			listeners.adCompleted = function () {
				if (floatingContext.state !== state.floating && floatingContext.state !== state.stopped) {
					deleteCloseButton(floatingContext);
					endFloating(floatingContext);
				}
				elements.video.removeEventListener('wikiaAdCompleted', listeners.adCompleted);
			};
			elements.video.addEventListener('wikiaAdCompleted', listeners.adCompleted);

			return floatingContext;
		}

		function isOutsideOfViewport(params) {
			var globalNavigationOffset = 20,
				slot = doc.querySelector('#' + params.slotName),
				rect = null,
				result = false;

			if (slot) {
				rect = slot.getBoundingClientRect();

				if (params.height > rect.height) {
					result = ((params.height - rect.height) + rect.bottom) < globalNavigationOffset;
				} else {
					result = rect.bottom < 0;
				}
			}

			return result;
		}

		/**
		 * Make video floating on the right rail.
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

			if (isOutsideOfViewport(params)) {
				enableFloating(floatingContext, params);
			}

			fireEvent(floatingContext, events.start);

			return floatingContext;
		}

		/**
		 * Checks whether slot with given parameters can become floating.
		 *
		 * @param params - parameters that video receives
		 * @returns {boolean} - true when floater can make given video & slot floatable
		 */
		function canFloat(params) {
			return params.enableLeaderboardFloating && compatibleSlots.indexOf(params.slotName) > -1;
		}

		/**
		 * Checks whether floting is enabled for given floating context.
		 *
		 * @param floatingContext - floating context object, containing state parameter
		 * @returns {boolean} - true if state is different from stopped - stopped state is set when floating element
		 * was closed or when scrolling up floating mode was turned off and video ended
		 */
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
