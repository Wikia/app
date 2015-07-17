/* global define */
define(
	'wikia.venusToc',
	['jquery', 'wikia.window', 'wikia.toc', 'wikia.dropdownNavigation', 'wikia.tracker'],
	function ($, win, tocModule, DropdownNavigation, tracker) {
		'use strict';

		var articleWrapperId = 'mw-content-text',
			articleHeaderClass = 'mw-headline',
			headers = [
				'h2',
				'h3'
			],
			delayHoverParams = {
				onActivate: show,
				onDeactivate: hide,
				activateOnClick: false
			},
			tocDropdown,
			// cached jQuery Selectors
			$triggerButton,
			$parent;

		/**
		 * @desc creates single toc data object
		 * @param {HTMLElement} header - header node
		 * @returns {Object}
		 */
		function createSection(header) {
			return {
				href: '#' + header.id,
				title: header.textContent.trim(),
				sections: []
			};
		}

		/**
		 * @desc checks if header is valid article headers that should be shown in TOC
		 * @param {HTMLElement} header - header node
		 * @returns {Boolean}
		 */
		function filterHeader(header) {
			var rawHeader = header.getElementsByClassName(articleHeaderClass);

			return rawHeader.length === 0 ? false : rawHeader[0];
		}

		/**
		 * @desc gets data model for TOC
		 * @param {Array} headers - array of headers levels (example ['h2, 'h3'])
		 * @param {string} containerId - id of headers container
		 * @returns {Array}
		 */
		function getTocData(headers, containerId) {
			var headersSelector = headers.join(','),
				headersCollection = win.document
					.getElementById(containerId)
					.querySelectorAll(headersSelector);

			return tocModule.getData(headersCollection, createSection, filterHeader).sections;
		}

		/**
		 * @desc shows dropdown
		 * @param {Event=} event
		 */
		function show(event) {
			$('.article-navigation > ul > li.active').removeClass('active');

			$parent.addClass('active');

			// handle touch interactions
			if (event) {
				event.stopPropagation();
			}

			$('body').one('click', hide);
		}

		/**
		 * @desc hides dropdown
		 */
		function hide() {
			tocDropdown.resetUI();
			$parent.removeClass('active');
		}

		/**
		 * @desc returns true if there is ToC
		 * @return {Boolean} true if there is ToC
		 */
		function isEnabled() {
			var headersSelector = headers.join(','),
				headersCollection = win.document.getElementById(articleWrapperId).querySelectorAll(headersSelector);

			return headersCollection.length > 0;
		}

		/**
		 * @desc initialize TOC
		 * @param {String} id -  id of the trigger element
		 * @param {Boolean} isTouchScreen - true if browser suppport touch events
		 */
		function init(id, isTouchScreen) {
			var options = {},
				articleSections = getTocData(headers, articleWrapperId),
				track = tracker.buildTrackingFunction({
					action: tracker.ACTIONS.CLICK,
					trackingMethod: 'analytics'
				});

			// initialize TOC only if article has sections
			if (articleSections.length > 0) {
				options.sections = articleSections;
				options.trigger = id;

				tocDropdown = new DropdownNavigation(options);

				$triggerButton = $('#' + id);
				$parent = $triggerButton.parent();

				// required for backword compatibility with oasis tracking
				$parent.on('mousedown touchstart', 'a', function (event) {
					var label,
						el = $(event.currentTarget);

					// Primary mouse button only
					if (event.which !== 1) {
						return;
					}

					if (el.prop('className') === '') {
						label = 'link-internal';
					}

					if (label !== undefined) {
						track({
							browserEvent: event,
							category: 'article',
							label: label
						});
					}
				});

				if (!isTouchScreen) {
					win.delayedHover($parent[0], delayHoverParams);
				} else {
					$triggerButton.on('click', show);
				}

				show();
			}
		}

		return {
			init: init,
			isEnabled: isEnabled
		};
	}
);
