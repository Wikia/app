(function(window, $, undefined) {

	// This object handles the bootstrapping of MiniEditor for on-demand loading
	// As well as creating new wikiaEditor instances
	var MiniEditor = {
		initialized: false,

		// The selector used for the MiniEditor wrapper
		wrapperSelector: '.MiniEditorWrapper',

		// Benchmarking
		initTime: 0,
		initTimer: null,
		loadTime: 0,
		loadTimer: null,

		// MiniEditor defaults to using Mediawiki editor
		// CKEDITOR will be used if RTE is detected after loading assets
		ckeditorEnabled: false,
		editorSuite: 'mweditorsuite',

		// Default configuration settings.
		// These will be modified after assets are loaded and per instance
		config: {
			isMiniEditor: true,
			mode: 'source',
			toolbars: {
				tabs: [],
				toolbar: ['FormatMiniEditorSource', 'InsertMiniEditor'],
				rail: []
			}
		},

		// Required WikiaEditor plugins (the editor suite is added later, in init)
		plugins: ['MiniEditor', 'loadingstatus'],

		// Used to configure MiniEditor.
		// Should be called after all dependencies are satisfied.
		configure: function() {

			// Must be initialized!
			if (!this.initialized) {
				return;
			}

			// If RTE is present, we are using the CKEDITOR suite
			if (typeof RTE != 'undefined') {
				this.editorSuite = 'ckeditorsuite';
				this.ckeditorEnabled = true;
				this.config.mode = window.RTEInitMode || 'wysiwyg';
				this.config.toolbars.toolbar = ['ModeSwitch', 'FormatMiniEditor'].concat(this.config.toolbars.toolbar);

				// Add CSS for ckeditor iframe
				RTE.contentsCss.push($.getSassLocalURL('extensions/wikia/MiniEditor/css/core/content.scss'));

				// Make sure we are using the correct instance for RTE overlays
				RTE.overlayNode.bind('click.MiniEditor', function() {
					RTE.overlayNode.data('editor').setAsActiveInstance();
				});
			}

			// Add the appropriate editor suite to the beginning of our list of plugins
			this.plugins.unshift(this.editorSuite);

			// Add buttons
			this.config.uiElements = window.wgEditorExtraButtons || {};

			// Fire a global event when initialization is complete
			GlobalTriggers.fire('MiniEditorReady');
		},

		// The main point of this function is load the resources needed for MiniEditor
		// and then pass off the init call for a specific id to the initEditor function.
		init: function(element, options) {
			var self = this;

			// Already initialized
			if (this.initialized) {
				return this.initEditor(element, options);
			}

			// Show the loading indicator and hide the textarea while we load stuff
			element.css('visibility', 'hidden');
			element.bind('keydown.LoadingStatus', function(e) {
				e.preventDefault();
			});

			element.closest(this.wrapperSelector).find('.loading-indicator').show();
			
			// Start load timer
			this.loadTimer = new Date();
			$().log('Start resource loading', 'MiniEditor');

			// Grab all of the global variables needed for mini editor functionality
			$.nirvana.sendRequest({
				controller: 'MiniEditorController',
				method: 'makeGlobalVariables',
				type: 'GET',
				data: { cb: window.wgStyleVersion },
				callback: function(data) {

					// wgMiniEditorAssets might already contain assets to load, as given by the
					// extension we are implementing into. Merge these into whatever editor assets
					// we got from the makeGlobalVariables function here.
					if (typeof window.wgMiniEditorAssets != 'undefined' && $.isArray(window.wgMiniEditorAssets)) {
						window.wgMiniEditorAssets = data.wgMiniEditorAssets.concat(window.wgMiniEditorAssets);
					}

					// Globalize
					// FYI, these override any global variables already set. So, kinda dangerous.
					for (var v in data) {
						window[v] = data[v];
					}

					// Load scripts and css. wgMiniEditorAssets is an array set by the makeGlobalVariables
					// FIXME: when loading scripts without allinone mode on, errors will occur because
					// scripts are not executed in the proper order.
					$.getResources(window.wgMiniEditorAssets, function() {

						// End load timer
						self.loadTime = (new Date().getTime() - self.loadTimer.getTime());
						$().log('End resource loading (' + self.loadTime + 'ms)', 'MiniEditor');

						// Now we can configure MiniEditor
						self.configure.call(self);

						// Initialize the editor for this element
						self.initEditor(element, options);
					});
				}
			});

			// Don't initialize again
			this.initialized = true;
		},

		initEditor: function(element, options) {
			var wikiaEditor = element.data('wikiaEditor');

			// Already exists
			if (wikiaEditor) {
				wikiaEditor.fire('editorActivated');

			// Current instance is not done initializing
			} else if ((wikiaEditor = WikiaEditor.getInstance()) && !wikiaEditor.ready) {

				// Attempt to blur the element
				element.trigger('blur');

			// Current instance does not exist or is done initializing, we can initialize
			// another instance at this point.
			} else {

				// Start init timer
				this.initTimer = new Date();
				$().log('Start initialization', 'MiniEditor');

				var wrapper = element.closest(this.wrapperSelector);

				// Bind events to the element before we initialize
				if (options.events) {
					element.bind(options.events);
				}

				// Create the instance for this element
				wikiaEditor = WikiaEditor.create(this.plugins, $.extend(true, {}, this.config, {
					body: element,
					element: wrapper,
					minHeight: element.data('min-height') || 200,
					maxHeight: element.data('max-height') || 400,
					tabIndex: false // (BugID:19737) - IE doesn't like it when there's a tab index attribute so just get rid of it. 
				}));

				// Store ID and a reference to wikiaEditor in element
				element.addClass('wikiaEditor').data('wikiaEditor', wikiaEditor);
			}
		},

		show: function(element, options) {
			if (!this.initialized) {
				this.init(element, options);

			} else {
				this.initEditor(element, options);
			}
		}
	};

	// jQuery fn bridge for use like $(...).miniEditor();
	$.fn.miniEditor = function(options) {
		options = $.extend(true, {}, $.fn.miniEditor.options, options);

		return this.each(function() {
			MiniEditor.show($(this), options);
		});
	};

	// Default options
	$.fn.miniEditor.options = {

		// Use this to bind to any of the wikiaEditor events
		events: {}
	};

	// If not loading on demand, configure on DOM ready
	$(function() {
		if (!window.wgMiniEditorLoadOnDemand) {
			MiniEditor.initialized = true;
			MiniEditor.configure();
		}
	});

	// Exports
	window.MiniEditor = MiniEditor;

})(this, jQuery);