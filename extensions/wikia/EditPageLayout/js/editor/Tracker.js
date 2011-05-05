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
		initialMode: false,

		beforeInit: function() {
			this.setTrackingFunction(jQuery.tracker.byStr);
		},

		init: function() {
			this.trackEditPageView();
			this.trackBrowser();

			// editor is ready
			this.editor.on('editorReady', this.proxy(this.onEditorReady));

			// mode switches / save
			this.editor.on('state', this.proxy(this.onStateChange));

			// store name of the current mode
			this.editor.on('mode', this.proxy(this.onModeSwitch));
		},

		trackEditPageView: function() {
			var pageType;

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
		},

		trackBrowser: function() {
			var browserInfo = this.getBrowserInfo();

			this.track('browser', 'init', browserInfo.name, browserInfo.version);

			this.editor.on('state', this.proxy(function(editor, state) {
				if (state == editor.states.SAVING) {
					this.track('browser', 'save', browserInfo.name, browserInfo.version);
				}
			}));
		},

		onEditorReady: function() {
			if (typeof window.wgNow == 'undefined') {
				return;
			}

			// load time in seconds
			var loadTime = (new Date() - window.wgNow) / 1000;

			// load time in ms (3.141 s will be reported as .../3100)
			loadTime = parseInt(loadTime * 10) * 100;

			this.track('initEditor', this.getTrackerInitialMode(), loadTime);

			// track edgecases
			var edgecase = this.getEdgecaseType();
			if (edgecase !== false) {
				this.track('initEditor', this.getTrackerInitialMode(), 'reason', edgecase);
			}
		},

		onStateChange: function(editor, state) {
			var states = editor.states;

			switch (state) {
				case states.SAVING:
					this.track('save');
					break;

				case states.LOADING_SOURCE:
					this.track(this.getTrackerInitialMode(), 'modeSwitch', 'visual2source');
					break;

				case states.LOADING_VISUAL:
					this.track(this.getTrackerInitialMode(), 'modeSwitch', 'source2visual');
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
				this.editor.getTrackerInitialMode = this.proxy(this.getTrackerInitialMode);

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

		// return name of the mode editor was initialized in
		getTrackerInitialMode: function() {
			if (this.initialMode !== false) {
				return this.initialMode;
			}
			
			switch(this.editor.mode) {
				case 'wysiwyg':
					this.initialMode = 'visualMode';
					break;

				case 'source':
					this.initialMode = 'sourceMode';

					// fallback to mediawiki editor
					if (window.RTEDisabledReason) {
						switch(window.RTEDisabledReason) {
							// RTE disabled in user preferences
							case 'usepreferences':
								this.initialMode = 'sourceModeLockedByPref';
								break;

							// NS_TEMPLATE / NS_MEDIAWIKI
							case 'namespace':
							// $wgWysiwygDisabledNamespaces
							case 'disablednamespace':
								this.initialMode = 'sourceModeLockedByArticle';
								break;
						}
					}
					// fallback aka edgecase
					else if (this.getEdgecaseType() !== false) {
						this.initialMode = 'sourceModeFallback';
					}
					break;
			}

			return this.initialMode;
		},

		// returns "visualMode" or "sourceMode"
		getTrackerMode: function() {
			return this.currentMode;
		},

		// returns browser engine and its version
		getBrowserInfo: function() {
			var env = $.browser;

			// keep the names compatible with old tracking system
			var name = (
				env.msie ? 'ie' :
				env.mozilla ? 'gecko' :
				env.opera ? 'opera' :
				env.webkit ? 'webkit' :
				'unknown'
			);

			return {
				name: name,
				version: env.version
			};
		},

		// get edgecase type
		getEdgecaseType: function() {
			return window.RTEEdgeCase || false;
		}
	});
})(this,jQuery);