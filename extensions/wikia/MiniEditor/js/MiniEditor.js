(function($, window, undefined) {

	// Fix wgAction (for inserting images)
	window.wgAction = 'edit';

	// This object handles the bootstrapping of MiniEditor for on-demand loading
	// As well as creating new wikiaEditor instances for each instanceId
	var MiniEditor = {
		instances: {},
		initialized: false, 

		// Benchmarking
		initTime: 0,
		initTimer: null,
		loadTime: 0,
		loadTimer: null,

		// The main point of this function is load the resources needed for MiniEditor
		// and then pass off the init call for a specific id to the initEditor function.
		init: function(element) {

			// This code should only be run once
			if (this.initialized) {
				return;
			}

			var self = this,
				wrapper = element.closest('.MiniEditorWrapper');

			// Start load timer
			this.loadTimer = new Date();
			$().log('Start resource loading', 'MiniEditor');

			// Show the loading indicator and hide the textarea while we load stuff
			element.css('visibility', 'hidden');
			wrapper.find('.loading-indicator').show();

			// Grab all of the global variables needed for mini editor functionality
			$.nirvana.sendRequest({
				controller: 'MiniEditorController',
				method: 'makeGlobalVariables',
				type: 'GET',
				data: {
					cb: wgStyleVersion
				},
				callback: function (data) {	

					// Globalize
					// FYI, these override any global variables already set. So, kinda dangerous.
					for (var v in data) {
						window[v] = data[v];
					}

					// Load scripts and css. wgMiniEditorAssets is an array set by the makeGlobalVariables
					// FIXME: when loading scripts without allinone mode on, errors will occur because
					// scripts are not executed in the proper order.
					$.getResources(wgMiniEditorAssets, function() {

						// End load timer
						self.loadTime = (new Date().getTime() - self.loadTimer.getTime());
						$().log('End resource loading (' + self.loadTime + 'ms)', 'MiniEditor');

						// Begin initialization
						self.initEditor(element);
						
						// Keep focus when modals are open that are outside WikiaEditor
						self.modalFocus();
						
						// Handle MiniEditor-specific RTEOverlay actions
						self.RTEOverlay(); 

					});

					self.initialized = true;
				}
			});

		},

		initEditor: function(element) {
			
			// Start init timer
			this.initTimer = new Date();
			$().log('Start initialization', 'MiniEditor');

			var loader = new MiniEditorLoader(element),
				wikiaEditor = loader.init();

			// Store ID and a reference to wikiaEditor in element
			element.data('MiniEditor', wikiaEditor);
		},

		show: function(element) {

			if (!this.initialized) {
				this.init(element);

			} else if (!element.data('MiniEditor')) {
				this.initEditor(element);

			} else {
				element.data('MiniEditor').fire('editorFocus');
			}
		},
		
		modalFocus: function() {
			// Handle MiniEditor focus when WMU and VET modals are open
			// (BugId:18713) TODO: fix this with (BugId:7846)
			$('.yui-panel-container').live('click.MiniEditor', function() {
				WikiaEditor.getInstance().plugins.MiniEditor.hasFocus = true;
			});
		},
		
		RTEOverlay: function() {
			RTE.overlayNode.bind('click.MiniEditor', function() {
				// clicking on RTEOverlay node will update the editor instance. 
				var wikiaEditor = RTE.overlayNode.data('editor');
				wikiaEditor.fire('editorFocus');
			});
		}
	};

	// jQuery fn bridge for use like $(...).miniEditor();
	$.fn.miniEditor = function() {
		return this.each(function() {
			var element = $(this);

			MiniEditor.show(element);
		});
	};

	// Exports
	window.MiniEditor = MiniEditor;

})(jQuery, window);