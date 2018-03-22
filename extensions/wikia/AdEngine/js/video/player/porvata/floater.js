/*global define, require*/
define('ext.wikia.adEngine.video.player.porvata.floater', [
		'ext.wikia.adEngine.video.player.porvata.floaterConfiguration',
		'ext.wikia.adEngine.video.player.porvata.floatingContextFactory',
		'wikia.document',
		'wikia.throttle',
		'wikia.window'
	], function (floaterConfiguration, floatingContextFactory, doc, throttle, win) {
		'use strict';

		var activeFloatingCssClass = 'floating',
			withArticleVideoCssClass = 'with-article-video',
			wikiFloatingVideoSelector = '.video-container',
			floatingContextCache = {};

		function updateDimensions(element, width, height) {
			if (element) {
				element.style.width = width + 'px';
				element.style.height = height + 'px';
			}
		}

		function createCloseButton() {
			var a = doc.createElement('a'),
				img = doc.createElement('img');

			a.classList.add('floating-close-button');
			img.src = '/extensions/wikia/AdEngine/js/video/player/ui/images/close.svg';
			a.appendChild(img);

			return a;
		}

		function resizeVideoAndShowCloseButton(floatingContext, width, height) {
			var elements = floatingContext.elements,
				listeners = floatingContext.listeners;

			if (!listeners.start) {
				listeners.start = function () {
					if (floatingContext.isFloating()) {
						elements.video.resize(width, height);
					}
				};
				elements.video.addEventListener('start', listeners.start);
			}

			elements.video.resize(width, height);
		}

		function deleteCloseButton(floatingContext) {
			var elements = floatingContext.elements;

			if (elements.closeButton) {
				elements.ad.removeChild(elements.closeButton);
			}
		}

		function endFloating(floatingContext) {
			var video = floatingContext.elements.video,
				listeners = floatingContext.listeners;

			win.removeEventListener('scroll', listeners.scroll);
			if (listeners.start) {
				video.removeEventListener('start', listeners.start);
			}
			if (listeners.adResumed) {
				video.removeEventListener('resume', listeners.adResumed);
			}
			if (listeners.adCompleted) {
				video.removeEventListener('wikiaAdCompleted', listeners.adCompleted);
			}
			floatingContext.stop();
		}

		function createOnCloseListener(floatingContext) {
			return function () {
				disableFloating(floatingContext);

				if (floatingContext.pauseOnClose) {
					floatingContext.stop();
				} else {
					endFloating(floatingContext);
				}
			};
		}

		function enableFloating(floatingContext) {
			var elements = floatingContext.elements,
				width = 0,
				height = 0;

			floatingContext.beforeFloat();
			elements.adContainer.classList.add(activeFloatingCssClass);

			// Those values have to be set after setting active floating css class
			width = floatingContext.getWidth();
			height = floatingContext.getHeight();

			updateDimensions(elements.imageContainer, width, height);

			resizeVideoAndShowCloseButton(floatingContext, width, height);

			floatingContext.float();
		}

		function disableFloating(floatingContext) {
			var elements = floatingContext.elements,
				preferred = floatingContext.preferred;

			elements.adContainer.classList.remove(activeFloatingCssClass);
			updateDimensions(elements.imageContainer, preferred.width, preferred.height);
			elements.video.resize(preferred.width, preferred.height);

			floatingContext.pause();

			if (elements.video.isCompleted()) {
				deleteCloseButton(floatingContext);
				endFloating(floatingContext);
			}
		}

		function isArticleVideoFloating() {
			var element = doc.querySelector(wikiFloatingVideoSelector);

			return element && 'fixed' === win.getComputedStyle(element).position;
		}

		function showAboveArticleVideo(floatingContext) {
			floatingContext.elements.adContainer.classList.toggle(withArticleVideoCssClass, isArticleVideoFloating());
		}

		function createOnScrollListener(floatingContext) {
			return function () {
				if (!floatingContext.doNotFloat) {
					if (floatingContext.isOutsideOfViewport()) {
						showAboveArticleVideo(floatingContext);
						if (floatingContext.isStill()) {
							enableFloating(floatingContext);
						}
					} else if (floatingContext.isFloating()) {
						disableFloating(floatingContext);
					}
				}
			};
		}

		function enableFloatingOn(video, params, eventHandlers) {
			var floatingContext = floatingContextFactory.create(video, params, eventHandlers),
				elements = floatingContext.elements,
				listeners = floatingContext.listeners;

			if (!elements.closeButton) {
				elements.closeButton = createCloseButton();
				listeners.close = createOnCloseListener(floatingContext);
				elements.closeButton.addEventListener('click', listeners.close);

				elements.ad.insertBefore(elements.closeButton, elements.ad.firstChild);
			}

			listeners.scroll = throttle(createOnScrollListener(floatingContext), 100);
			win.addEventListener('scroll', listeners.scroll);

			listeners.adCompleted = function () {
				disableFloating(floatingContext);
				elements.video.removeEventListener('wikiaAdCompleted', listeners.adCompleted);
				win.removeEventListener('scroll', listeners.scroll);
			};
			elements.video.addEventListener('wikiaAdCompleted', listeners.adCompleted);

			if (floatingContext.pauseOnClose) {
				listeners.adResumed = function () {
					if (floatingContext.isStopped()) {
						floatingContext.pause();
					}
				};
				elements.video.addEventListener('resume', listeners.adResumed);
			}

			return floatingContext;
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

			floatingContext.invokeLater(function (floatingContext) {
				showAboveArticleVideo(floatingContext);
				enableFloating(floatingContext);
			});

			floatingContextCache[params.slotName] = floatingContext;

			return floatingContext;
		}

		/**
		 * Checks whether slot with given parameters can become floating.
		 *
		 * @param params - parameters that video receives
		 * @returns {boolean} - true when floater can make given video & slot floatable
		 */
		function canFloat(params) {
			return floaterConfiguration.canFloat(params);
		}

		function isFloating(slotName) {
			return floatingContextCache[slotName] &&
				floatingContextCache[slotName].elements.adContainer.classList.contains(activeFloatingCssClass);
		}

		return {
			canFloat: canFloat,
			makeFloat: makeFloat,
			isFloating: isFloating
		};
	}
);
