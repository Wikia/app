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

	var templates = {
			bannerNotification: '<div class="wds-banner-notification {{typeClassName}}">' +
			'<div class="wds-banner-notification__icon">' +
			'{{{icon}}}</div>' +
			'<span class="wds-banner-notification__text">{{{content}}}</span>' +
			// DS icon: wds-icons-close-tiny
			'<svg class="wds-icon wds-icon-tiny wds-banner-notification__close" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">' +
			'<path d="M7.426 6.001l4.278-4.279A1.008 1.008 0 1 0 10.278.296L6 4.574 1.723.296A1.008 1.008 0 1 0 .295 1.722l4.278 4.28-4.279 4.277a1.008 1.008 0 1 0 1.427 1.426L6 7.427l4.278 4.278a1.006 1.006 0 0 0 1.426 0 1.008 1.008 0 0 0 0-1.426L7.425 6.001z" fill-rule="evenodd"/>' +
			'</svg></div>',

			// DS icon: wds-icons-flag-small
			notifyIcon: '<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">' +
			'<path d="M3 11h10.586l-3.293-3.293a.999.999 0 0 1 0-1.414L13.586 3H3v8zm-1 7a1 1 0 0 1-1-1V1a1 1 0 0 1 2 0h13a1.002 1.002 0 0 1 .707 1.707L12.414 7l4.293 4.293A1 1 0 0 1 16 13H3v4a1 1 0 0 1-1 1z" fill-rule="evenodd"/>' +
			'</svg>',

			// DS icon: wds-icons-checkmark-small
			confirmIcon: '<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">' +
            '<path d="M6 16a.997.997 0 0 1-.707-.293l-5-5a.999.999 0 1 1 1.414-1.414L6 13.586 16.293 3.293a.999.999 0 1 1 1.414 1.414l-11 11A.997.997 0 0 1 6 16" fill-rule="evenodd"/>' +
            '</svg>',

			// DS icon: wds-icons-alert-small
			errorIcon: '<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">' +
			'<path d="M2.618 15.995L9 3.199l6.382 12.796H2.618zm15.276.554l-8-16.04C9.555-.17 8.445-.17 8.105.51l-8 16.04A1.003 1.003 0 0 0 1 18h16c.347 0 .668-.18.85-.476a.998.998 0 0 0 .044-.975zM8 7.975V9.98a1 1 0 1 0 2 0V7.975a1 1 0 1 0-2 0m1.71 4.3c-.05-.04-.1-.09-.16-.12a.567.567 0 0 0-.17-.09.61.61 0 0 0-.19-.06.999.999 0 0 0-.9.27c-.09.101-.16.201-.21.33a1.01 1.01 0 0 0-.08.383c0 .26.11.52.29.711.19.18.44.291.71.291.06 0 .13-.01.19-.02a.635.635 0 0 0 .19-.06.59.59 0 0 0 .17-.09c.06-.04.11-.08.16-.12.18-.192.29-.452.29-.712 0-.132-.03-.261-.08-.382a.94.94 0 0 0-.21-.33" fill-rule="evenodd"/>' +
			'</svg>',

			// DS icon: wds-icons-alert-small
			warnIcon: '<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">' +
			'<path d="M2.618 15.995L9 3.199l6.382 12.796H2.618zm15.276.554l-8-16.04C9.555-.17 8.445-.17 8.105.51l-8 16.04A1.003 1.003 0 0 0 1 18h16c.347 0 .668-.18.85-.476a.998.998 0 0 0 .044-.975zM8 7.975V9.98a1 1 0 1 0 2 0V7.975a1 1 0 1 0-2 0m1.71 4.3c-.05-.04-.1-.09-.16-.12a.567.567 0 0 0-.17-.09.61.61 0 0 0-.19-.06.999.999 0 0 0-.9.27c-.09.101-.16.201-.21.33a1.01 1.01 0 0 0-.08.383c0 .26.11.52.29.711.19.18.44.291.71.291.06 0 .13-.01.19-.02a.635.635 0 0 0 .19-.06.59.59 0 0 0 .17-.09c.06-.04.11-.08.16-.12.18-.192.29-.452.29-.712 0-.132-.03-.261-.08-.382a.94.94 0 0 0-.21-.33" fill-rule="evenodd"/>' +
			'</svg>'
		},

		defaultTimeout = 10000,
		types = {
			notify: {
				className: 'wds-message',
				svg: templates.notifyIcon
			},
			confirm: {
				className: 'wds-success',
				svg: templates.confirmIcon
			},
			error: {
				className: 'wds-alert',
				svg: templates.errorIcon
			},
			warn: {
				className: 'wds-warning',
				svg: templates.warnIcon
			}
		},
		classes = Object.keys(types).join(' '),
		closeImageSource = window.stylepath + '/oasis/images/icon_close.png',
		$container,
		$header,
		modal,
		fadeTime = 400,
		wrapperClass = 'wds-banner-notification__container',
		wrapperSelector = '.' + wrapperClass,
		notificationSelector = '.wds-banner-notification',
		transparentBannerClass = 'wds-is-transparent';

	/**
	 * Creates a new banner notifications instance (doesn't show it yet though!)
	 * @param {String} [content] Content of the notification
	 * @param {String} [type] One of notification classes / types
	 * @param {jQuery} [$parent] Element to pin the notification to
	 * @param {Number} [timeout] If set, notification will hide after given time
	 * @constructor
	 */
	function BannerNotification(content, type, $parent, timeout) {
		if (content instanceof jQuery && content.hasClass('wds-banner-notification')) {
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
		$header = $('#globalNavigation');
		$container = getContainer();

		require(['wikia.onScroll'], function (onScroll) {
			onScroll.bind(handleScrolling);
		});

		updatePlaceholderHeight();

		// SUS-729: hide notifications if VisualEditor is loaded and show them again once it's closed
		if (mw.config.get('wgVisualEditor') && mw.config.get('wgIsArticle')) {
			mw.hook('ve.activationComplete').add(function() {
				$(notificationSelector).fadeOut(fadeTime);
				updatePlaceholderHeight();
			});

			mw.hook('ve.deactivate').add(function() {
				$(notificationSelector).fadeIn(fadeTime);
				updatePlaceholderHeight();
			});
		}
		createBackendNotifications();
	}

	function updatePlaceholderHeight() {
		$container.height($container.find(wrapperSelector).height());
	}

	/**
	 * Create instances of BannerNotification based on HTML
	 * passed from the server on page load.
	 * (if such one exists)
	 */
	function createBackendNotifications() {
		$(notificationSelector).each(function () {
			var backendNotification = new BannerNotification($(this));
			setUpClose(backendNotification);
		});
	}

	/**
	 * Pins the notification to the top of the screen when scrolled down the page.
	 */
	function handleScrolling() {
		var containerTop,
			notificationWrapper = $container.children(wrapperSelector),
			headerBottom;

		if (!$container.length || !notificationWrapper.length) {
			return;
		}

		// get the position of the wrapper element relative to the top of the viewport
		containerTop = $container.get(0).getBoundingClientRect().top;
		headerBottom = $header.length > 0 ? $header.get(0).getBoundingClientRect().bottom : 0;

		if (containerTop < headerBottom) {
			notificationWrapper.css('top', headerBottom);

			if (!notificationWrapper.hasClass('float')) {
				notificationWrapper.addClass('float');
			}
		} else {
			notificationWrapper.removeClass('float');
		}
	}

	/**
	 * Obtains element wrapping notifications
	 * @returns {jQuery}
	 */
	function getContainer() {
		if ($container && $container.length) {
			return $container;
		} else {
			$container = $('.banner-notifications-placeholder');
		}
		return $container;
	}

	/**
	 * Constructs jQuery element with the notification
	 * @param {String} content
	 * @param {String} [type]
	 * @returns {jQuery}
	 */
	function createMarkup(content, type) {
		type = type || 'notify';
		return $(
			mustache.render(templates.bannerNotification, {
				imageSource: closeImageSource,
				content: content,
				icon: types[type].svg,
				typeClassName: types[type].className,
			})
		).addClass(type + ' ' + transparentBannerClass);
	}

	/**
	 * Adds given markup to DOM
	 * @param {jQuery} $element
	 * @param {jQuery} $parentElement
	 */
	function addToDOM($element, $parentElement) {
		// allow notification wrapper element to be passed by extension
		var $parent = $parentElement || (isModalShown() ? modal : getContainer()),
			$bannerNotificationsWrapper = $parent.find(wrapperSelector);

		if (!$bannerNotificationsWrapper.length) {
			$bannerNotificationsWrapper = $('<div></div>').addClass(wrapperClass);
			$parent.prepend($bannerNotificationsWrapper);
		}

		$bannerNotificationsWrapper.prepend($element);

		// 'fadeIn' resulted in 'display: block;' on MS Edge
		// we need to clear the stack after 'prepend' because transition will be not applied
		setTimeout(function () {
			$element.removeClass(transparentBannerClass);
		}, 0);
	}

	/**
	 * Bind close event to close button
	 */
	function setUpClose(notification) {
		notification.$element.find('.wds-banner-notification__close').on('click', function (event) {
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
			}, fadeTime, function () {
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

		if (
			$parent.hasClass(wrapperSelector) &&
			$parent.children().length === 1
		) {
			$parent.remove();
		} else {
			$element.remove();
		}

		updatePlaceholderHeight();
	}

	// run when DOM is loaded
	$(init);

	//Window global stays for legacy reasons
	window.BannerNotification = BannerNotification;

	define('BannerNotification', function () {
		return BannerNotification;
	});

})(window, $, window.Mustache);
