/**
 * Provides click tracking interface for edit page modules
 * FIXME: This file is useless now because $.tracker is gone.
 * Get rid of references to these functions across EditPageLayout.
 *
 * @author macbre
 */

(function(window,$){

	var WE = window.WikiaEditor = window.WikiaEditor || (new Observable());

	WE.plugins.tracker = $.createClass(WE.plugin,{

		trackerFn: false,
		eventTrackerFn: false,
		trackerRoot: 'editpage',

		// visualMode / sourceMode
		currentMode: false,
		initialMode: false,

		beforeInit: function() {
			var noop = function(){};

			// Update trackerRoot for the MiniEditor
			if (this.editor.config.isMiniEditor) {
				this.trackerRoot = 'MiniEditor';
			}

			this.setTrackingFunction(noop);
			this.eventTrackerFn = noop;
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

		trackEdgecaseReason: function() {
			var edgecase = this.getEdgecaseType();

			if (edgecase !== false) {
				var initialMode;

				switch(this.editor.mode) {
					case 'wysiwyg':
						initialMode = 'visualMode';
						break;

					case 'source':
						initialMode = 'sourceMode';

						// fallback to mediawiki editor
						if (window.RTEDisabledReason) {
							switch(window.RTEDisabledReason) {
								// RTE disabled in user preferences
								case 'userpreferences':
									initialMode = 'sourceModeLockedByPref';
									break;

								// NS_TEMPLATE / NS_MEDIAWIKI
								case 'namespace':
								// $wgWysiwygDisabledNamespaces
								case 'disablednamespace':
									initialMode = 'sourceModeLockedByArticle';
									break;
							}
						}
						// fallback aka edgecase
						else if (this.getEdgecaseType() !== false) {
							initialMode = 'sourceModeFallback';
						}
						break;
				}

				this.track('initEditor', initialMode, 'reason', edgecase);
			}
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

			// track reason of fallback to source mode
			this.trackEdgecaseReason();
		},

		onStateChange: function(editor, state) {
			var states = editor.states;

			switch (state) {
				// editor loading is done / mode is switched
				case states.IDLE:
					this.reportLoadTime();
					break;

				// page is being saved
				case states.SAVING:
					this.track('save');

					// track time spent on the edit page (BugId:2948)
					if (window.wgNow) {
						var timeSpent = Math.round((new Date() - wgNow) / 1000),
							browserName = this.getBrowserInfo().name;

						this.trackEvent('editpage', 'editTime', browserName, timeSpent);
					}
					break;

				// switch to source mode
				case states.LOADING_SOURCE:
					this.track(this.getTrackerInitialMode(), 'modeSwitch', 'visual2source');
					break;

				// switch to wysiwyg mode
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

		// measure how long it takes to fully load the editor (BugId:6907)
		reportLoadTime: function() {
			if (!this.loadTimeReported) {
				var now = +new Date(),
					browserInfo = this.getBrowserInfo().name,
					editButtonClickTimestamp = parseInt($.storage.get('unloadstamp'));

				// time it took to load the editor fully (since the moment user clicked the "edit" button)
				var loadTimeTotal = editButtonClickTimestamp ? now - editButtonClickTimestamp : false;

				// ignore higher times (caused by people closing their browsers while being on edit page)
				if (loadTimeTotal !== false && loadTimeTotal < 60000 /* 60 sec */) {
					this.editor.log('Editor loaded in ' + (loadTimeTotal / 1000) + ' s (after "edit" was clicked)');
					this.trackEvent(this.trackerRoot, 'loadTimeTotal', browserInfo, loadTimeTotal);
				}

				// time it took to load the editor fully (within current page view)
				if (window.wgNow) {
					var loadTime = now - window.wgNow;

					this.editor.log('Editor loaded in ' + (loadTime / 1000) + ' s (after HTML has arrived)');
					this.trackEvent(this.trackerRoot, 'loadTime', browserInfo, loadTime);
				}

				// send this report just once
				this.loadTimeReported = true;
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


		track: function(action, label, value) {
			// common tracking "prefix" + function arguments
			var args = [this.trackerRoot].concat(Array.prototype.slice.call(arguments));

			if (this.trackerFn) {
				this.trackerFn.call(window, args.join('/'));
			}
		},

		// @see http://code.google.com/intl/pl-PL/apis/analytics/docs/tracking/eventTrackerGuide.html
		trackEvent: function(category, action, opt_label, opt_value) {
			if (this.eventTrackerFn) {
				this.eventTrackerFn.apply(window, arguments);
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
					// caused either by user preferences or an edgecase
					if (window.RTEDisabledReason || (this.getEdgecaseType() !== false)) {
						this.initialMode = 'sourceModeLocked';
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