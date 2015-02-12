/*
 * Handles the color-coded notification messages that generally appear at the top the screen or inside a modal.
 * Use like:
 * GlobalNotification.show('Some success message', 'confirm')
 * GlobalNotification.show('Some error message', 'error', $('.myDiv'), 3000)
 */
var GlobalNotification = {

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

		// If there's already a global notification on page load, set up JS
		GlobalNotification.dom = $('.global-notification');
		if (GlobalNotification.dom.length) {
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
		if (!GlobalNotification.dom.length) {
			GlobalNotification.dom = $('<div class="global-notification">' +
				'<button class="close wikia-chiclet-button">' +
				'<img src="' + window.stylepath + '/oasis/images/icon_close.png">' +
				'</button><div class="msg"></div></div>')
				.hide();
			GlobalNotification.setUpClose();
		}

		// allow notification wrapper element to be passed by extension
		if (element instanceof jQuery) {
			element.prepend(GlobalNotification.dom).show();

		// handle modal implementations
		} else if (isModal) {
			GlobalNotification.modal.prepend(GlobalNotification.dom);

		// handle non-modal implementation
		} else {
			this.pageContainer.prepend(GlobalNotification.dom);
		}

		GlobalNotification.msg = GlobalNotification.dom.find('.msg');
	},

	/**
	 * Main entry point for this feature - shows the notification
	 * @param {string} content - message to be displayed
	 * @param {string} type - See GlobalNotification.options for supported types
	 * @param {jQuery} [element] Element to prepend notification to
	 * @param {number} [timeout] Optional time (in ms) after which notification will disappear.
	 */
	show: function (content, type, element, timeout) {
		'use strict';

		var isModal,
			classes = Object.keys(GlobalNotification.options).join(' ');
		GlobalNotification.content = content;

		function callback() {
			isModal = GlobalNotification.isModal();

			// Modal notifications have no close button so set a timeout
			if (isModal && typeof timeout !== 'number') {
				timeout = GlobalNotification.defaultTimeout;
			}

			GlobalNotification.createDom(element, isModal);
			GlobalNotification.msg.html(GlobalNotification.content);
			GlobalNotification.dom.removeClass(classes).addClass(type);

			// Share scroll event with WikiaFooterApp's toolbar floating (BugId:33365)
			if (window.WikiaFooterApp) {
				window.WikiaFooterApp.addScrollEvent();
			}

			GlobalNotification.dom.fadeIn('slow');

			// Close notification after specified amount of time
			if (typeof timeout === 'number') {
				setTimeout(function () {
					GlobalNotification.hide();
				}, timeout);
			}
		}

		// close any existing notifications before adding a new one
		GlobalNotification.hide(callback);
	},

	/**
	 * Hides the notification and executes an optional callback
	 * @param {function} [callback]
	 */
	hide: function (callback) {
		'use strict';
		if (!GlobalNotification.dom) {
			return;
		}
		if (GlobalNotification.dom.length) {
			GlobalNotification.dom.animate({
				'height': 0,
				'padding': 0,
				'opacity': 0
			}, 400, function () {
				GlobalNotification.dom.remove();
				GlobalNotification.dom = [];
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
		GlobalNotification.modal = $('.modalWrapper, .yui-panel, .modal');

		// returns false if there's no modal or it's hidden
		return GlobalNotification.modal.is(':visible');
	},

	/**
	 * Bind close event to close button
	 */
	setUpClose: function () {
		'use strict';
		GlobalNotification.dom.find('.close').on('click', GlobalNotification.hide);
	},

	/**
	 * Pin the notification to the top of the screen when scrolled down the page.
	 * Shares the scroll event with WikiaFooter.js
	 */
	onScroll: function () {
		'use strict';

		var containerTop;

		if (!GlobalNotification.dom || !GlobalNotification.dom.length) {
			return;
		}

		// get the position of the wrapper element relative to the top of the viewport
		containerTop = GlobalNotification.pageContainerElem.getBoundingClientRect().top;

		if (containerTop < GlobalNotification.headerHeight) {
			GlobalNotification.dom.addClass('float');
		} else {
			GlobalNotification.dom.removeClass('float');
		}
	}
};

$(function () {
	'use strict';
	GlobalNotification.init();
});
