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
		classes = Object.keys(types).join(' '),
		pageContainer,
		wikiaHeader,
		headerHeight,
		modal,
		isModal;

	/**
	 * Constructs jQuery element with the notification
	 * @param {String} content
	 * @param {String} [type]
	 * @returns {jQuery}
	 */
	function createMarkup(content, type) {
		return $('<div class="banner-notification">' +
			'<button class="close wikia-chiclet-button">' +
			'<img src="' + window.stylepath + '/oasis/images/icon_close.png">' +
			'</button><div class="msg">' + content + '</div></div>')
			.addClass(type)
			.hide();
	}

	/**
	 * Adds given markup to DOM
	 * @param {jQuery} $element
	 * @param {jQuery} $parentElement
	 */
	function addToDOM($element, $parentElement) {
		// allow notification wrapper element to be passed by extension
		if ($parentElement instanceof jQuery) {
			$parentElement.prepend($element);

			// handle modal implementations
		} else if (isModal) {
			modal.prepend($element);

			// handle non-modal implementation
		} else {
			$(pageContainer).prepend($element);
		}

		$element.fadeIn('slow');
	}

	/**
	 * Main entry point for this feature - shows the notification
	 * and returns the notification instance
	 * @param {string} content - message to be displayed
	 * @param {string} type - See BannerNotifications.options for supported types
	 * @param {jQuery} [$parent] Element to prepend notification to
	 * @param {number} [timeout] Optional time (in ms) after which notification will disappear.
	 */

	function show(content, type, $parent, timeout) {
		var bannerNotification;

		/**
		 * Removes notification with a fade-out animation
		 * @param {Function} callback
		 */
		function hide(callback) {
			removeFromDOM(bannerNotification.$element, callback);
		}

		/**
		 * Changes content of the notification to the provided one
		 * @param {String} content
		 */
		function setContent(content) {
			bannerNotification
				.$element
				.find('.msg')
				.html(content);
		}

		/**
		 * Changes type of the notification to the provided one
		 * @param {String} type
		 */
		function setType(type) {
			if (types.hasOwnProperty(type)) {
				bannerNotification
					.$element
					.removeClass(classes)
					.addClass(type);
			}
		}

		bannerNotification = {
			$element: createMarkup(content, type),
			hide: hide,
			setContent: setContent,
			setType: setType
		};

		isModal = isModalShown();

		// Modal notifications have no close button so set a timeout
		if (isModal && typeof timeout !== 'number') {
			timeout = defaultTimeout;
		}

		bannerNotification.setType(type);

		addToDOM(
			bannerNotification.$element,
			$parent
		);

		// Share scroll event with WikiaFooterApp's toolbar floating (BugId:33365)
		if (window.WikiaFooterApp) {
			window.WikiaFooterApp.addScrollEvent();
		}

		// Close notification after specified amount of time
		if (typeof timeout === 'number') {
			setTimeout(function () {
				hide();
			}, timeout);
		}

		return bannerNotification;
	}

	/**
	 * Shows notification informing about an AJAX connection error
	 * @returns {Object}
	 */
	function showConnectionError() {
		return show(
			$.msg('bannernotifications-general-ajax-failure'),
			'error'
		);
	}

	/**
	 * Called once to instantiate this feature
	 */
	function init() {
		var pageContainerSelector =
			window.skin === 'monobook' ? '#content' : '.WikiaPageContentWrapper';
		setUpClose();

		pageContainer = $(pageContainerSelector)[0];
		wikiaHeader = $('#globalNavigation');
		headerHeight = wikiaHeader.height();
	}

	/**
	 * Determine if a modal is present and visible so we can apply the notification to the modal instead of the page.
	 * @returns {boolean}
	 */
	function isModalShown() {
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
	function removeFromDOM($elements, callback) {
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
		} else {
			if (typeof callback === 'function') {
				callback();
			}
		}
	}

	/**
	 * Hides all displayed notifications
	 * @param {Function} callback
	 */
	function hideAll(callback) {
		removeFromDOM($('.banner-notification'), callback);
	}

	/**
	 * Bind close event to close button
	 */
	function setUpClose() {
		$(document.body).on('click', '.close', onCloseClicked);
	}

	/**
	 * Handles click event on the 'close' button
	 * @param {Event} event
	 */
	function onCloseClicked(event) {
		removeFromDOM(
			$(event.target).closest('.banner-notification')
		);
		event.stopPropagation();
	}

	/**
	 * Pin the notification to the top of the screen when scrolled down the page.
	 * Shares the scroll event with WikiaFooter.js
	 */
	function onScroll() {
		var containerTop,
			notificationElements = $('.banner-notification');

		if (!pageContainer || !notificationElements || !notificationElements.length) {
			return;
		}

		// get the position of the wrapper element relative to the top of the viewport
		containerTop = pageContainer.getBoundingClientRect().top;

		if (containerTop < headerHeight) {
			notificationElements.addClass('float');
		} else {
			notificationElements.removeClass('float');
		}
	}

	//Window global stays for legacy reasons
	window.BannerNotifications = {
		init: init,
		onScroll: onScroll,
		show: show,
		showConnectionError: showConnectionError,
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
