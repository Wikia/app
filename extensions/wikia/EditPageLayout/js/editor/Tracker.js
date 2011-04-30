/**
 * Provides click tracking interface for edit page modules
 *
 * @author macbre
 */

(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable);

	WE.plugins.tracker = $.createClass(WE.plugin,{

		trackerFn: false,
		trackerRoot: 'editpage',

		// visualMode / sourceMode
		currentMode: false,

		beforeInit: function() {
			this.setTrackingFunction(jQuery.tracker.byStr);
		},

		init: function() {
			var self = this,
				pageType;

			// page types
			switch(window.wgCanonicalSpecialPageName) {
				case 'CreatePage':
					pageType = 'createPage';
					break;

				case 'CreateBlogPage':
					pageType = 'createBlogPage';
					break;

				case 'PageLayoutBuilder':
					pageType = 'layoutBuilder';
					break;

				default:
					pageType = window.wgIsMainpage ? 'mainPage' : 'genericEdit';
			}

			this.track('view', pageType);

			// mode switches / save
			this.editor.on('state', this.proxy(this.onStateChange));

			// store name of the current mode
			this.editor.on('mode', this.proxy(this.onModeSwitch));
		},

		onStateChange: function(editor, state) {
			var states = editor.states;

			switch (state) {
				case states.SAVING:
					this.track('save');
					break;

				case states.LOADING_SOURCE:
					this.track('visualMode', 'modeSwitch', 'visual2source');
					break;

				case states.LOADING_VISUAL:
					this.track('visualMode', 'modeSwitch', 'source2visual');
					break;
			}
		},

		onModeSwitch: function(editor, mode) {
			switch(mode) {
				case 'source':
					this.currentMode = 'sourceMode';
					break;

				case 'wysiwyg':
					this.currentMode = 'wysiwygMode';
					break;
			}
		},

		setTrackingFunction: function(fn) {
			var self = this;

			if (typeof fn == 'function') {
				this.trackerFn = fn;

				// allow WikiaEditor plugins to use tracking methods
				this.editor.track = this.proxy(this.track);
				this.editor.getTrackerMode = this.proxy(this.getTrackerMode);

				// CK editor core & RTE plugins should use our tracker
				if (typeof RTE == 'object') {
					RTE.track = this.proxy(this.track);
				}
			}
		},

		// @see http://code.google.com/intl/pl-PL/apis/analytics/docs/tracking/eventTrackerGuide.html
		track: function(action, label, value) {
			var args = [this.trackerRoot];
			for (i=0; i < arguments.length; i++) {
				args.push(arguments[i]);
			}

			// TODO: use GA event tracking
			// pageTracker._trackEvent.apply(window, args);
			if (this.trackerFn) {
				this.trackerFn.call(window, args.join('/'));
			}
		},

		// returns "visualMode" or "sourceMode"
		getTrackerMode: function() {
			return this.currentMode;
		}
	});
})(this,jQuery);
