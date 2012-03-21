(function(window, $, undefined) {

	// Private helper function for element loading status indicators
	function loading($element) {
		$element.css('visibility', 'hidden').closest(MiniEditor.wrapperSelector).find('.loading-indicator').show();
	}

	// This object handles the bootstrapping of MiniEditor for on-demand loading
	// As well as creating new wikiaEditor instances
	var MiniEditor = {
		assetsLoaded: false,
		loadingAssets: false,

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
		editorIsLoading: false,

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

			if (!this.assetsLoaded) {
				return;
			}

			// If RTE is present, we are using the CKEDITOR suite
			if (typeof RTE != 'undefined') {
				this.ckeditorEnabled = true;
				this.editorSuite = 'ckeditorsuite';
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

		// Loads the resources needed for MiniEditor
		loadAssets: function(callback) {
			var self = this;

			if (this.loadingAssets || this.assetsLoaded) {
				if ($.isFunction(callback)) {
					callback();
				}

				return;
			}

			// Start load timer
			this.loadTimer = new Date();
			$().log('Start resource loading', 'MiniEditor');

			// Mark assets as loading
			this.loadingAssets = true;

			// Grab all of the global variables needed for mini editor functionality
			$.nirvana.sendRequest({
				controller: 'MiniEditorController',
				method: 'makeGlobalVariables',
				type: 'POST', //this cann't be cache
				callback: function(data) {

					// wgMiniEditorAssets might already contain assets to load, as given by the
					// extension we are implementing into. Merge these into whatever editor assets
					// we got from the makeGlobalVariables function here.
					if (typeof window.wgMiniEditorAssets != 'undefined' && $.isArray(window.wgMiniEditorAssets)) {
						data.wgMiniEditorAssets = data.wgMiniEditorAssets.concat(window.wgMiniEditorAssets);
					}

					// Globalize
					// FYI, these override any global variables already set. So, kinda dangerous.
					for (var v in data) {
						window[v] = data[v];
					}

					// Load scripts and css. wgMiniEditorAssets is an array set by the makeGlobalVariables
					// FIXME: when loading scripts without allinone mode on, errors will occur because
					// scripts are not executed in the proper order.
					$.getResources(window.wgMiniEditorAssets, $.proxy(function() {

						// End load timer
						this.loadTime = (new Date().getTime() - this.loadTimer.getTime());
						$().log('End resource loading (' + this.loadTime + 'ms)', 'MiniEditor');

						this.assetsLoaded = true;
						this.loadingAssets = false;

						// Now we can configure MiniEditor
						this.configure();

						// Fire the callback
						if ($.isFunction(callback)) {
							callback();
						}
					}, self));
				}
			});
		},

		initEditor: function(element, options) {
			var $element = $(element);

			// If assets are loading, disregard this call
			if (this.loadingAssets) {
				return;
			}

			// Assets haven't been loaded yet, load them now
			if (!this.assetsLoaded) {
				loading($element);

				// Load all the required assets then call this method again
				return this.loadAssets($.proxy(function() {
					this.initEditor(element, options);
				}, this));
			}

			var wikiaEditor = $element.data('wikiaEditor');

			// Already exists
			if (wikiaEditor && wikiaEditor.ready) {
				wikiaEditor.fire('editorActivated');

			// Current instance is not done initializing
			} else if ((wikiaEditor || (wikiaEditor = WikiaEditor.getInstance())) && !wikiaEditor.ready) {
				wikiaEditor.fire('editorBeforeReady');

			// Current instance does not exist or is done initializing, we can initialize
			// another instance at this point.
			} else {

				// Start init timer
				this.initTimer = new Date();
				$().log('Start initialization', 'MiniEditor');

				// Make sure we have an options object
				options = $.extend(true, {}, $.fn.miniEditor.options, options);

				var self = this,
					$wrapper = $element.closest(this.wrapperSelector),
					events = $.extend({}, options.events);

				// Wrap existing editorReady function with our own
				events.editorReady = function() {
					self.editorIsLoading = false;

					if ($.isFunction(options.events.editorReady)) {
						options.events.editorReady.apply(self, arguments);
					}
				}

				// Bind events to the element before we initialize
				$element.bind(events);

				// Set content
				if (options.content !== undefined) {
					$element.html(options.content);
				}

				// An editor instance is loading
				loading($element);
				this.editorIsLoading = true;

				// Create the instance for this element
				wikiaEditor = WikiaEditor.create(this.plugins, $.extend(true, {}, this.config, {
					body: $element,
					element: $wrapper.addClass(this.editorSuite),
					minHeight: $element.data('min-height') || 200,

					// Force source mode if edge cases were found (BugId:24375)
					mode: $.isArray(options.edgeCases) && options.edgeCases.length ? 'source' : this.config.mode,
					maxHeight: $element.data('max-height') || 400
				}, options.config));

				// Store a reference to wikiaEditor in element
				$element.addClass('wikiaEditor').data('wikiaEditor', wikiaEditor).triggerHandler('editorInit', [wikiaEditor]);
			}
		},

		// Return the startup mode for an editor instance
		getStartupMode: function(element) {
			var $element = $(element);

			if ($element.length) {
				var wikiaEditor = $element.data('wikiaEditor');

				if (wikiaEditor) {
					return wikiaEditor.mode;
				}
			}

			return this.config.mode;
		},

		// Return the 'convertToFormat' parameter for loading content.
		// Either 'richtext' or empty string (because it comes to use as wikitext already)
		getLoadConversionFormat: function(element) {
			return WikiaEditor.modeToFormat(this.getStartupMode(element)) == 'richtext' ? 'richtext' : '';
		},

		// Return the 'convertToFormat' parameter for saving content.
		// Either 'wikitext' or an empty string (because we always save as wikitext)
		getSaveConversionFormat: function(element) {
			return this.getLoadConversionFormat(element) == 'richtext' ? 'wikitext' : '';
		}
	};

	// jQuery fn bridge for use like $(...).miniEditor();
	$.fn.miniEditor = function(options) {
		return this.each(function() {
			MiniEditor.initEditor(this, options);
		});
	};

	// Default options
	$.fn.miniEditor.options = {

		// Use this to override default configuration options
		config: {},

		// Use this to bind to any of the wikiaEditor events
		events: {}
	};

	// On DOM ready...
	$(function() {

		// If assets have been included on page load, mark as
		// initialized and configure now.
		if (!window.wgMiniEditorLoadOnDemand) {
			MiniEditor.assetsLoaded = true;
			MiniEditor.configure();
		}
	});

	// Exports
	window.MiniEditor = MiniEditor;

})(this, jQuery);