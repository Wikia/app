define('wikia.ui.drawer', ['jquery', 'wikia.window'], function ($, w) {
	'use strict';

	var DRAWER_ID = 'drawer-',
		SUBDRAWER_ID = 'subdrawer-',
		BLACKOUT_ID = 'drawer-blackout-',
		OPEN_CLASS = 'open',
		VISIBLE_CLASS = 'visible',
		ANIMATION_DURATION = 200, //ms
		drawerDefaults = {
			type: 'default',
			vars: {
				style: '',
				side: 'right'
			}
		},
		uiComponent,
		$body = $( w.document.body );

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

	function createComponent( params, component ) {
		uiComponent = component; // set reference to UI Component

		return new Drawer( params );
	}

	function Drawer( params ) {
		var self = this,
			side = ( typeof params === 'object' ) ? params.vars.side : params; // drawer side

		if ( typeof( uiComponent ) === 'undefined' ) {
			throw 'Need uiComponent to render drawer with side ' + side;
		}

		// extend default drawer params with the one passed in constructor call
		params = $.extend( true, {}, drawerDefaults, params );

		// render drawer markup and append to DOM
		$body.append( uiComponent.render( params ) );

		this.$drawer = $('#' + DRAWER_ID + side);
		this.$subdrawer = $('#' + SUBDRAWER_ID + side);
		this.$blackout = $('#' + BLACKOUT_ID + side);

		this.$blackout.click(function(e) {
			e.preventDefault();

			self.close();
		});
	}

	Drawer.prototype.open = function() {
		this.$drawer.addClass(OPEN_CLASS);
		this.$blackout.addClass(VISIBLE_CLASS);
	};

	Drawer.prototype.close = function() {
		var self = this,
			animate = function() {
				self.$drawer.removeClass(OPEN_CLASS);
				self.$blackout.removeClass(VISIBLE_CLASS);
			};
		if ( this.isOpenSub() ) {
			this.closeSub();
			setTimeout(animate, ANIMATION_DURATION);
		} else {
			animate();
		}
	};

	Drawer.prototype.isOpen = function() {
		return this.$drawer.hasClass(OPEN_CLASS);
	};

	Drawer.prototype.openSub = function() {
		var self = this,
			animate = function() {
				self.$subdrawer.addClass(OPEN_CLASS);
			};

		if ( !this.isOpen() ) {
			this.open();
			setTimeout(animate, ANIMATION_DURATION);
		} else {
			animate();
		}
	};

	Drawer.prototype.closeSub = function() {
		this.$subdrawer.removeClass(OPEN_CLASS);
	};

	Drawer.prototype.isOpenSub = function() {
		return this.$subdrawer.hasClass(OPEN_CLASS);
	};

	Drawer.prototype.setSubcontent = function(subcontent) {
		this.$subdrawer.html(subcontent);
	};

	Drawer.prototype.swipeSubcontent = function(subcontent) {
		var self = this,
			animate = function() {
				self.setSubcontent(subcontent);
				self.openSub();
			};
		if ( this.isOpenSub() ) {
			this.closeSub();
			setTimeout(animate, ANIMATION_DURATION);
		} else {
			animate();
		}
	}

	/** Public API */

	return {
		createComponent: createComponent
	};
});
