/* global require, define*/
/*
 * Handles the color-coded notification messages that generally appear
 * at the top of the screen or inside a modal.
 *
 * AMD module is defined at the bottom of the 'require' block
 *
 * Use like:
 * new BannerNotification('Content', 'error').show().hide();
 *
 * NOTE: this module does not escape content of the notifications by itself
 * it should be used only with content that is considered safe (escaped)
 */
(function (window, $, mustache) {
	'use strict';

	var defaultTimeout = 10000,
		types = {
			'notify': 'blue',
			'confirm': 'green',
			'error': 'red',
			'warn': 'yellow'
		},
		classes = Object.keys(types).join(' '),
		closeImageSource = window.stylepath + '/oasis/images/icon_close.png',
		$pageContainer,
		headerHeight,
		modal,
		backendNotification,
		template = '<div class="banner-notification">' +
			'<button class="close wikia-chiclet-button"><img></button>' +
			'<div class="msg">{{{content}}}</div>' +
			'</div>';

	/**
	 * Creates a new banner notifications instance (doesn't show it yet though!)
	 * @param {String} [content] Content of the notification
	 * @param {String} [type] One of notification classes / types
	 * @param {jQuery} [$parent] Element to pin the notification to
	 * @param {Number} [timeout] If set, notification will hide after given time
	 * @constructor
	 */
	function BannerNotification(content, type, $parent, timeout) {
		if (content instanceof jQuery && content.hasClass('banner-notification')) {
			//create a notification object from already existing markup
			this.content = content.find('.msg').html();
			this.$element = content;
			this.$parent = content.parent();
			this.hidden = false;
		} else {
			this.content = content;
			this.$element = null;
			this.$parent = $parent;
			this.hidden = true;
			this.type = type;
			this.timeout = timeout;
		}
		this.onCloseHandler = Function.prototype;
	}

	/**
	 * Creates DOM element and reveals the notification
	 * @returns {BannerNotification}
	 */
	BannerNotification.prototype.show = function () {
		if (!this.hidden) {
			return this;
		}
		if (!this.$element) {
			this.$element = createMarkup(this.content, this.type);
		}
		this.setType(this.type);

		setUpClose(this);

		// Modal notifications have no close button so set a timeout
		if (isModalShown() && typeof this.timeout !== 'number') {
			this.timeout = defaultTimeout;
		}

		addToDOM(this.$element, this.$parent);

		this.hidden = false;

		// If the page is already scrolled, make sure we update our position
		handleScrolling();

		// Close notification after specified amount of time
		if (typeof this.timeout === 'number') {
			setTimeout(function () {
				this.hide();
			}.bind(this), this.timeout);
		}
		return this;
	};

	/**
	 * Hides a notification and removes an instance of a DOM element
	 * @returns {BannerNotification}
	 */
	BannerNotification.prototype.hide = function () {
		if (!this.hidden) {
			fadeOut(this.$element, removeFromDOM);
			this.$element = null;
			this.hidden = true;
		}
		return this;
	};

	/**
	 * Overrides the type of the notification
	 * @param {String} type
	 * @returns {BannerNotification}
	 */
	BannerNotification.prototype.setType = function (type) {
		if (type !== this.type && types.hasOwnProperty(type)) {
			this.type = type;
			if (this.$element) {
				this.$element
					.removeClass(classes)
					.addClass(type);
			}
		}
		return this;
	};

	/**
	 * Overrides the content of the notification
	 * @param {String} content
	 * @returns {BannerNotification}
	 */
	BannerNotification.prototype.setContent = function (content) {
		if (content && content !== this.content) {
			this.content = content;
			if (this.$element) {
				this.$element
					.find('.msg')
					.html(content);
			}
		}
		return this;
	};

	/**
	 * Generic method for indicating problem with AJAX connection
	 * @returns {BannerNotification}
	 */
	BannerNotification.prototype.showConnectionError = function () {
		return this
			.setType('error')
			.setContent(
				window.mw.message('bannernotifications-general-ajax-failure')
					.escaped()
			)
			.show();
	};

	/**
	 * Allows to attach a handler to a notification close event
	 * @param {Function} callback
	 * @returns {BannerNotification}
	 */
	BannerNotification.prototype.onClose = function (callback) {
		if (typeof callback === 'function') {
			this.onCloseHandler = callback;
		}
		return this;
	};

	/**
	 * Called once to instantiate this feature
	 */
	function init() {
		if (window.skin === 'monobook') {
			$pageContainer = $('#content');
		} else {
			$pageContainer = $('.WikiaPageContentWrapper');
			headerHeight = $('#globalNavigation, .wds-global-navigation ').outerHeight(true);
			require(['wikia.onScroll'], function (onScroll) {
				onScroll.bind(handleScrolling);
			});
		}

		// SUS-726: hide notifications if VisualEditor is loaded and show them again once it's closed
		if (mw.config.get('wgVisualEditor') && mw.config.get('wgIsArticle')) {
			mw.hook('ve.activationComplete').add(function() {
				$('.banner-notification').fadeOut(400);
			});

			mw.hook('ve.cancelButton').add(function() {
				$('.banner-notification').fadeIn(400);
			});
		}
		createBackendNotifications();
	}

	/**
	 * Create instances of BannerNotification based on HTML
	 * passed from the server on page load.
	 * (if such one exists)
	 */
	function createBackendNotifications() {
		$('.banner-notification').each(function () {
			var backendNotification = new BannerNotification($(this));
			setUpClose(backendNotification);
		});
	}

	/**
	 * Pins the notification to the top of the screen when scrolled down the page.
	 */
	function handleScrolling() {
		var containerTop,
			notificationWrapper = $pageContainer.children('.banner-notifications-wrapper');

		if (!$pageContainer.length || !notificationWrapper.length) {
			return;
		}

		// get the position of the wrapper element relative to the top of the viewport
		containerTop = $pageContainer[0].getBoundingClientRect().top;

		if (containerTop < headerHeight) {
			notificationWrapper.addClass('float');
		} else {
			notificationWrapper.removeClass('float');
		}
	}

	/**
	 * Obtains element wrapping contents of the page
	 * @returns {jQuery}
	 */
	function getPageContainer() {
		if ($pageContainer.length) {
			return $pageContainer;
		} else if (window.skin === 'monobook') {
			$pageContainer = $('#content');
		} else {
			$pageContainer = $('.WikiaPageContentWrapper');
		}
		return $pageContainer;
	}

	/**
	 * Constructs jQuery element with the notification
	 * @param {String} content
	 * @param {String} [type]
	 * @returns {jQuery}
	 */
	function createMarkup(content, type) {
		return $(
			mustache.render(template, {
				imageSource: closeImageSource,
				content: content
			})
		).addClass(type).hide();
	}

	/**
	 * Adds given markup to DOM
	 * @param {jQuery} $element
	 * @param {jQuery} $parentElement
	 */
	function addToDOM($element, $parentElement) {
		// allow notification wrapper element to be passed by extension
		var $parent = $parentElement || (isModalShown() ? modal : getPageContainer()),
			$bannerNotificationsWrapper = $parent.find('.banner-notifications-wrapper');
		if (!$bannerNotificationsWrapper.length) {
			$bannerNotificationsWrapper = $('<div></div>').addClass('banner-notifications-wrapper');
			$parent.prepend($bannerNotificationsWrapper);
		}
		$bannerNotificationsWrapper.prepend($element);

		$element.fadeIn('slow');
	}

	/**
	 * Bind close event to close button
	 */
	function setUpClose(notification) {
		$(notification.$element).on('click', '.close', function (event) {
			notification.hide();
			notification.onCloseHandler(event);
		});
	}

	/**
	 * Determine if a modal is present and visible so we can apply the
	 * notification to the modal instead of the page.
	 * @returns {boolean}
	 */
	function isModalShown() {
		// handle all types of modals since the begining of time!
		modal = $('.modalWrapper, .yui-panel, .modal');

		// returns false if there's no modal or it's hidden
		return modal.is(':visible');
	}

	/**
	 * Animates smooth fading of an element
	 * @param {jQuery} $element
	 * @param {Function} callback
	 */
	function fadeOut($element, callback) {
		if ($element.length) {
			$element.animate({
				'height': 0,
				'padding': 0,
				'opacity': 0
			}, 400, function () {
				callback($element);
			});
		}
	}

	/**
	 * Removes notification element from DOM and executes callback
	 * @param {jQuery} $element - elements to be removed from DOM
	 */
	function removeFromDOM($element) {
		var $parent = $element.parent();
		if ($parent.hasClass('.banner-notifications-wrapper') &&
			$parent.children().length === 1) {

			$parent.remove();
		} else {
			$element.remove();
		}
	}

	// run when DOM is loaded
	$(init);

	//Window global stays for legacy reasons
	window.BannerNotification = BannerNotification;

	define('BannerNotification', function () {
		return BannerNotification;
	});

})(window, $, window.Mustache);
