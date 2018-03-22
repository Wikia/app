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
			// DS icon: wds-icons-cross-tiny
			'<svg class="wds-icon wds-icon-tiny wds-banner-notification__close" width="12" height="12" viewBox="0 0 12 12" xmlns="http://www.w3.org/2000/svg">' +
			'<path d="M6 4.554L2.746 1.3C2.346.9 1.7.9 1.3 1.3c-.4.4-.4 1.046 0 1.446L4.554 6 1.3 9.254c-.4.4-.4 1.047 0 1.446.4.4 1.046.4 1.446 0L6 7.446 9.254 10.7c.4.4 1.047.4 1.446 0 .4-.4.4-1.046 0-1.446L7.446 6 10.7 2.746c.4-.4.4-1.047 0-1.446-.4-.4-1.046-.4-1.446 0L6 4.554z" fill-rule="evenodd"/>' +
			'</svg></div>',

			// DS icon: wds-icons-flag-small
			notifyIcon: '<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path d="M8.1 16.5l-7-13C.9 3 1 2.4 1.5 2.1c.5-.2 1.1-.1 1.4.4l7 13c.2.5.1 1.1-.4 1.4-.5.2-1.1.1-1.4-.4zM17 6.7c-2.8 2.5-6.2-.6-8.3 3.1L5.5 4.1C7.6.4 11 3.5 13.7 1L17 6.7z"/></svg>',

			// DS icon: wds-icons-checkmark-circle-small
			confirmIcon: '<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path fill-rule="evenodd" d="M9 17A8 8 0 1 1 9 1a8 8 0 0 1 0 16zm-1.083-5a.73.73 0 0 0 .52-.22l4.33-4.403c.3-.305.312-.81.024-1.13a.722.722 0 0 0-1.062-.026l-3.83 3.895L6.25 8.563a.72.72 0 0 0-1.06.068.835.835 0 0 0 .063 1.13l2.165 2.04a.725.725 0 0 0 .5.2z"/></svg>',

			// DS icon: wds-icons-error-small
			errorIcon: '<svg class="wds-icon wds-icon-small" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18"><path fill-rule="evenodd" d="M10.414 9l1.417-1.416a1.003 1.003 0 0 0-.002-1.412.996.996 0 0 0-1.412-.003L9 7.585 7.584 6.17a1.003 1.003 0 0 0-1.412.002.996.996 0 0 0-.003 1.412L7.585 9 6.17 10.416a1.003 1.003 0 0 0 .002 1.412.996.996 0 0 0 1.412.003L9 10.415l1.416 1.417a1.003 1.003 0 0 0 1.412-.002.996.996 0 0 0 .003-1.412L10.415 9zm1.9-8L17 5.686v6.628L12.314 17H5.686L1 12.314V5.686L5.686 1h6.628z"/></svg>',

			// DS icon: wds-icons-alert-small
			warnIcon: '<svg class="wds-icon wds-icon-small" width="18" height="16" viewBox="0 0 18 16" xmlns="http://www.w3.org/2000/svg"><path d="M17.928 15.156c.1.178.096.392-.013.565a.603.603 0 0 1-.515.28H.6a.607.607 0 0 1-.515-.28.544.544 0 0 1-.013-.564L8.472.278c.21-.37.847-.37 1.056 0l8.4 14.878zM8 5.99v4.02A1 1 0 0 0 9 11c.556 0 1-.444 1-.99V5.99A1 1 0 0 0 9 5c-.556 0-1 .444-1 .99zM8 13c0 .556.448 1 1 1 .556 0 1-.448 1-1 0-.556-.448-1-1-1-.556 0-1 .448-1 1z" fill-rule="evenodd"/></svg>'
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

		if (window.skin !== 'monobook') {
			require(['wikia.onScroll'], function (onScroll) {
				onScroll.bind(handleScrolling);
			});
		}

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
		if (window.skin !== 'monobook') {
			$container.height($container.find(wrapperSelector).height());
		}
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
		} else if (window.skin === 'monobook') {
			$container = $('#content');
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
