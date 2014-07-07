define('wikia.ui.drawer', ['jquery', 'wikia.window'], function ($, w) {
	'use strict';

	var DRAWER_ID = 'drawer-',
		SUBDRAWER_ID = 'subdrawer-',
		BLACKOUT_ID = 'drawer-blackout-',
		CLOSEBUTTON_ID = 'drawer-close-button-',
		OPEN_CLASS = 'open',
		HIDDEN_CLASS = 'hidden',
		VISIBLE_CLASS = 'visible',
		ANIMATION_DURATION = 200, //ms
		drawerDefaults = {
			type: 'default',
			vars: {
				side: 'right',
				closeText: 'Close'
			}
		},
		uiComponent,
		$body = $(w.document.body);

	/**
	 * THIS FUNCTION IS REQUIRED FOR EACH COMPONENT WITH AMD JS WRAPPER !!!!
	 *
	 * It's used by UI Component class 'createComponent' method as a shortcut for rendering, appending to DOM
	 * and initializing component with a single function call.
	 *
	 * Sets a reference to UI component object configured for rendering / creating modals
	 * and creates new instance of modal class passing mustache params to constructor call.
	 *
	 * @param {Object} params - mustache params for rendering modal
	 * @param {Object} component - UI Component configured for creating modal
	 * @returns {Object} - new instance of Modal object
	 */

	function createComponent(params, component) {
		uiComponent = component; // set reference to UI Component

		return new Drawer(params);
	}

	function Drawer(params) {
		var self = this,
			side = ( typeof params === 'object' ) ? params.vars.side : params, // drawer side
			closeFunc = function (ev) {
				ev.preventDefault();

				self.close();
			};

		if (typeof( uiComponent ) === 'undefined') {
			throw 'Need uiComponent to render drawer with side ' + side;
		}

		// extend default drawer params with the one passed in constructor call
		params = $.extend(true, {}, drawerDefaults, params);

		// render drawer markup and append to DOM
		$body.append(uiComponent.render(params));

		// cache important elements
		this.$drawer = $('#' + DRAWER_ID + side);
		this.$subdrawer = $('#' + SUBDRAWER_ID + side);
		this.$blackout = $('#' + BLACKOUT_ID + side).click(closeFunc);

		$('#' + CLOSEBUTTON_ID + side).click(closeFunc);
	}

	/**
	 * Open drawer
	 */
	Drawer.prototype.open = function () {
		this.$drawer.scrollTop(0);
		this.$drawer.addClass(OPEN_CLASS);
		this.$subdrawer.removeClass(HIDDEN_CLASS);
		this.$blackout.addClass(VISIBLE_CLASS);
	};

	/**
	 * Close drawer
	 */
	Drawer.prototype.close = function () {
		var self = this,
			animate = function () {
				self.$drawer.removeClass(OPEN_CLASS);
				self.$subdrawer.addClass(HIDDEN_CLASS);
				self.$blackout.removeClass(VISIBLE_CLASS);
			};
		if (this.isOpenSub()) {
			this.closeSub();
			setTimeout(animate, ANIMATION_DURATION);
		} else {
			animate();
		}
	};

	/**
	 * Returns drawer open status
	 *
	 * @return bool
	 */
	Drawer.prototype.isOpen = function () {
		return this.$drawer.hasClass(OPEN_CLASS);
	};

	/**
	 * Set drawer's content
	 *
	 * @param content HTML Content
	 */
	Drawer.prototype.setContent = function (content) {
		this.$subdrawer.html(content);
	};

	/**
	 * Open subdrawer
	 */
	Drawer.prototype.openSub = function () {
		var self = this,
			animate = function () {
				self.$subdrawer.scrollTop(0);
				self.$subdrawer.addClass(OPEN_CLASS);
			};

		if (!this.isOpen()) {
			this.open();
			setTimeout(animate, ANIMATION_DURATION);
		} else {
			animate();
		}
	};

	/**
	 * Close subdrawer
	 */
	Drawer.prototype.closeSub = function () {
		this.$subdrawer.removeClass(OPEN_CLASS);
	};

	/**
	 * Returns subdrawer open status
	 *
	 * @return bool
	 */
	Drawer.prototype.isOpenSub = function () {
		return this.$subdrawer.hasClass(OPEN_CLASS);
	};

	/**
	 * Set subdrawer's content
	 *
	 * @param subcontent HTML Content
	 */
	Drawer.prototype.setSubContent = function (subcontent) {
		this.$subdrawer.html(subcontent);
	};

	/**
	 * Hide subdrawer, ser subdrawer content and show subdrawer
	 *
	 * @param subcontent  HTML Content
	 */
	Drawer.prototype.swipeSub = function (subcontent) {
		var self = this,
			animate = function () {
				if (subcontent) {
					self.setSubContent(subcontent);
				}
				self.openSub();
			};
		if (this.isOpenSub()) {
			this.closeSub();
			setTimeout(animate, ANIMATION_DURATION);
		} else {
			animate();
		}
	};

	/** Public API */

	return {
		createComponent: createComponent
	};
});
