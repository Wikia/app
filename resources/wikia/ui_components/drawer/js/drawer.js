define('wikia.ui.drawer', ['jquery', 'wikia.window'], function ($, w) {
	'use strict';

	var DRAWER_ID = 'drawer-',
		BLACKOUT_ID = 'drawer-blackout-',
		OPEN_CLASS = 'open',
		CLOSED_CLASS = 'closed',
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
			side = ( typeof params === 'object' ) ? params.vars.side : params, // drawer side
			id = DRAWER_ID + side,
			blackoutId = BLACKOUT_ID + side;

		if ( typeof( uiComponent ) === 'undefined' ) {
			throw 'Need uiComponent to render drawer with side ' + side;
		}

		// extend default drawer params with the one passed in constructor call
		params = $.extend( true, {}, drawerDefaults, params );

		// render drawer markup and append to DOM
		$body.append( uiComponent.render( params ) );

		this.$drawer = $('#' + id);
		this.$blackout = $('#' + blackoutId);

		this.$blackout.click(function(e) {
			e.preventDefault();

			self.close();
		});
	}

	Drawer.prototype.open = function() {
		this.$drawer.addClass('open');
		this.$blackout.addClass('visible');
	};

	Drawer.prototype.close = function() {
		this.$drawer.removeClass('open');
		this.$blackout.removeClass('visible');
	};

	Drawer.prototype.isOpen = function() {
		return this.$drawer.hasClass('open');
	};

	/** Public API */

	return {
		createComponent: createComponent
	};
});
