/*
 * Handles the color-coded notification messages that generally appear
 * at the top of the screen or inside a modal.
 * Use like:
 * BannerNotifications.show('Some success message', 'confirm')
 * BannerNotifications.show('Some error message', 'error', $('.myDiv'), 3000)
 */
define('BannerNotifications', ['jquery', 'wikia.window'], function ($, window) {
	'use strict';

	var defaultTimeout = 10000,
		types = {
			'notify': 'blue',
			'confirm': 'green',
			'error': 'red',
			'warn': 'yellow'
		},
		dom,
		pageContainer,
		wikiaHeader,
		headerHeight,
		modal,
		isModal;

	function createMarkup(id, content, type) {
		return $('<div id="' + id + '" class="global-notification">' +
			'<button class="close wikia-chiclet-button">' +
			'<img src="' + window.stylepath + '/oasis/images/icon_close.png">' +
			'</button><div class="msg">' + content + '</div></div>')
			.addClass(type)
			.hide();
	}

	function addToDOM(markup, $elementBefore) {
		// allow notification wrapper element to be passed by extension
		if ($elementBefore instanceof jQuery) {
			$elementBefore.prepend(markup);

			// handle modal implementations
		} else if (isModal) {
			modal.prepend(markup);

			// handle non-modal implementation
		} else {
			$(pageContainer).prepend(markup);
		}

		markup.fadeIn('slow');
	}

	/**
	 * Called once to instantiate this feature
	 */
	function init() {
		setUpClose();

		pageContainer = $('.WikiaPageContentWrapper')[0];
		wikiaHeader = $('#globalNavigation');
		headerHeight = wikiaHeader.height();
	}

	/**
	 * Main entry point for this feature - shows the notification
	 * @param {string} id - unique id used for DOM markup of the notification
	 * @param {string} content - message to be displayed
	 * @param {string} type - See BannerNotifications.options for supported types
	 * @param {jQuery} [$element] Element to prepend notification to
	 * @param {number} [timeout] Optional time (in ms) after which notification will disappear.
	 */
	function show(id, content, type, $element, timeout) {

		validate(id, content);
		isModal = isModalShown();

		// Modal notifications have no close button so set a timeout
		if (isModal && typeof timeout !== 'number') {
			timeout = defaultTimeout;
		}

		addToDOM(
			createMarkup(id, content, type),
			$element
		);

		// Share scroll event with WikiaFooterApp's toolbar floating (BugId:33365)
		if (window.WikiaFooterApp) {
			window.WikiaFooterApp.addScrollEvent();
		}

		// Close notification after specified amount of time
		if (typeof timeout === 'number') {
			setTimeout(function () {
				hide(id);
			}, timeout);
		}
	}

	/**
	 * Determine if a modal is present and visible so we can apply the notification to the modal instead of the page.
	 * @returns {boolean}
	 */
	function isModalShown () {
		// handle all types of modals since the begining of time!
		modal = $('.modalWrapper, .yui-panel, .modal');

		// returns false if there's no modal or it's hidden
		return modal.is(':visible');
	}

	/**
	 * Removes notification element from DOM and executes callback
	 * @param {jQuery} $elements - elements to be removed from DOM
	 * @param {function} [callback]
	 */
	function removeFromDOM ($elements, callback) {
		if ($elements.length) {
			$elements.animate({
				'height': 0,
				'padding': 0,
				'opacity': 0
			}, 400, function () {
				$elements.remove();
				if (typeof callback === 'function') {
					callback();
				}
			});
		}
	}

	/**
	 * Hides the notification and executes an optional callback
	 * @param {String} id - ID of the notification element to hide
	 * @param {Function} [callback] - Optional callback to be triggered after the action
	 */
	function hide (id, callback) {
		var $element = $('#' + id);

		if ($element.length) {
			removeFromDOM($element, callback);
		} else {
			if (typeof callback === 'function') {
				callback();
			}
		}
	}

	function validate(id, content) {
		if (!id || document.getElementById(id)) {
			throw new Error('Either empty or already existing notification ID supplied');
		} else if (!content) {
			throw new Error('Empty notification content supplied');
		}
	}

	function hideAll (callback) {
		removeFromDOM($('.global-notification'), callback);
	}

	/**
	 * Bind close event to close button
	 */
	function setUpClose () {
		$(document.body).on('click', '.close', onCloseClicked);
	}

	/**
	 * Handles click event on the 'close' button
	 * @param {Event} event
	 */
	function onCloseClicked (event) {
		removeFromDOM(
			$(event.target).closest('.global-notification')
		);
		event.stopPropagation();
	}

	/**
	 * Pin the notification to the top of the screen when scrolled down the page.
	 * Shares the scroll event with WikiaFooter.js
	 */
	function onScroll () {
		var containerTop;

		if (!dom || !dom.length) {
			return;
		}

		// get the position of the wrapper element relative to the top of the viewport
		containerTop = pageContainer.getBoundingClientRect().top;

		if (containerTop < headerHeight) {
			dom.addClass('float');
		} else {
			dom.removeClass('float');
		}
	}

	//Attachment to window is for legacy reasons
	window.BannerNotifications = {
		init: init,
		onScroll: onScroll,
		show: show,
		hide: hide,
		hideAll: hideAll,
		isModal: isModalShown,
		types: types
	};

	return window.BannerNotifications;
});

$(function () {
	'use strict';
	require(['BannerNotifications'], function (bannerNotifications) {
		bannerNotifications.init();
	});
});
