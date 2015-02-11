/*
 * Handles the color-coded notification messages that generally appear
 * at the top the screen or inside a modal.
 * Use like:
 * BannerNotifications.show('Some success message', 'confirm')
 * BannerNotifications.show('Some error message', 'error', $('.myDiv'), 3000)
 */
var BannerNotifications = {

	defaultTimeout: 10000,
	/**
	 * All the possible class names and colors this module supports
	 */
	options: {
		'notify': 'blue',
		'confirm': 'green',
		'error': 'red',
		'warn': 'yellow'
	},

	/**
	 * Called once to instantiate this feature
	 */
	init: function () {
		'use strict';

		// If there's already a banner notification on page load, set up JS
		BannerNotifications.dom = $('.global-notification');
		if (BannerNotifications.dom.length) {
			this.setUpClose();
		}

		this.pageContainer = $('.WikiaPageContentWrapper');
		this.pageContainerElem = this.pageContainer[0];
		this.wikiaHeader = $('#globalNavigation');
		this.headerHeight = this.wikiaHeader.height();
	},

	/**
	 * Build the notification DOM element and attach it to the DOM
	 * @param {object} [element] Element to prepend the notification to
	 * @param {boolean} [isModal] Whether or not a modal is present and visible on the page
	 */
	createDom: function (element, isModal) {
		'use strict';

		// create and store dom
		if (!BannerNotifications.dom.length) {
			BannerNotifications.dom = $('<div class="global-notification">' +
				'<button class="close wikia-chiclet-button">' +
				'<img src="' + window.stylepath + '/oasis/images/icon_close.png">' +
				'</button><div class="msg"></div></div>')
				.hide();
			BannerNotifications.setUpClose();
		}

		// allow notification wrapper element to be passed by extension
		if (element instanceof jQuery) {
			element.prepend(BannerNotifications.dom).show();

		// handle modal implementations
		} else if (isModal) {
			BannerNotifications.modal.prepend(BannerNotifications.dom);

		// handle non-modal implementation
		} else {
			this.pageContainer.prepend(BannerNotifications.dom);
		}

		BannerNotifications.msg = BannerNotifications.dom.find('.msg');
	},

	/**
	 * Main entry point for this feature - shows the notification
	 * @param {string} content - message to be displayed
	 * @param {string} type - See BannerNotifications.options for supported types
	 * @param {jQuery} [element] Element to prepend notification to
	 * @param {number} [timeout] Optional time (in ms) after which notification will disappear.
	 */
	show: function (content, type, element, timeout) {
		'use strict';

		var isModal,
			classes = Object.keys(BannerNotifications.options).join(' ');
		BannerNotifications.content = content;

		function callback() {
			isModal = BannerNotifications.isModal();

			// Modal notifications have no close button so set a timeout
			if (isModal && typeof timeout !== 'number') {
				timeout = BannerNotifications.defaultTimeout;
			}

			BannerNotifications.createDom(element, isModal);
			BannerNotifications.msg.html(BannerNotifications.content);
			BannerNotifications.dom.removeClass(classes).addClass(type);

			// Share scroll event with WikiaFooterApp's toolbar floating (BugId:33365)
			if (window.WikiaFooterApp) {
				window.WikiaFooterApp.addScrollEvent();
			}

			BannerNotifications.dom.fadeIn('slow');

			// Close notification after specified amount of time
			if (typeof timeout === 'number') {
				setTimeout(function () {
					BannerNotifications.hide();
				}, timeout);
			}
		}

		// close any existing notifications before adding a new one
		BannerNotifications.hide(callback);
	},

	/**
	 * Hides the notification and executes an optional callback
	 * @param {function} [callback]
	 */
	hide: function (callback) {
		'use strict';
		if (!BannerNotifications.dom) {
			return;
		}
		if (BannerNotifications.dom.length) {
			BannerNotifications.dom.animate({
				'height': 0,
				'padding': 0,
				'opacity': 0
			}, 400, function () {
				BannerNotifications.dom.remove();
				BannerNotifications.dom = [];
				if (typeof callback === 'function') {
					callback();
				}
			});
		} else {
			if (typeof callback === 'function') {
				callback();
			}
		}
	},

	/**
	 * Determine if a modal is present and visible so we can apply the notification to the modal instead of the page.
	 * @returns {boolean}
	 */
	isModal: function () {
		'use strict';

		// handle all types of modals since the begining of time!
		BannerNotifications.modal = $('.modalWrapper, .yui-panel, .modal');

		// returns false if there's no modal or it's hidden
		return BannerNotifications.modal.is(':visible');
	},

	/**
	 * Bind close event to close button
	 */
	setUpClose: function () {
		'use strict';
		BannerNotifications.dom.find('.close').on('click', BannerNotifications.hide);
	},

	/**
	 * Pin the notification to the top of the screen when scrolled down the page.
	 * Shares the scroll event with WikiaFooter.js
	 */
	onScroll: function () {
		'use strict';

		var containerTop;

		if (!BannerNotifications.dom || !BannerNotifications.dom.length) {
			return;
		}

		// get the position of the wrapper element relative to the top of the viewport
		containerTop = BannerNotifications.pageContainerElem.getBoundingClientRect().top;

		if (containerTop < BannerNotifications.headerHeight) {
			BannerNotifications.dom.addClass('float');
		} else {
			BannerNotifications.dom.removeClass('float');
		}
	}
};

$(function () {
	'use strict';
	BannerNotifications.init();
});
