(function(window, $) {

	/**
	 * Wikia Editor loader for the MiniEditor
	 */
	window.MiniEditorLoader = $.createClass(Object, {

		element: false,

		constructor: function(element) {
			this.element = element.closest('.MiniEditorWrapper');
			this.body = element.addClass('body');
		},

		getToolbarsConfig: function() {
			var layout = {
				tabs: [],
				toolbar: [],
				rail: []
			};

			// RTE buttons
			if (typeof window.RTE != 'undefined') {
				layout.toolbar.push('ModeSwitch');
				layout.toolbar.push('FormatMiniEditor');
			}

			// Mediawiki/Source mode buttons
			layout.toolbar.push('FormatMiniEditorSource');
			// Insert buttons (image/video)
			layout.toolbar.push('InsertMiniEditor');

			return layout;
		},

		getData: function() {
			var self = this,
				ckeEnabled = typeof window.RTE != 'undefined',
				mode = ckeEnabled ? (window.RTEInitMode || 'wysiwyg') : 'source';

			return {
				plugins: [
					'MiniEditor',
					ckeEnabled ? 'ckeditorsuite' : 'mweditorsuite',
					'loadingstatus',
					'cssloadcheck'
				],
				config: {
					// The element being replaced, where text was entered
					body: self.body,
					// The element's wrapper
					element: self.element,
					// Minimum and maximum heights for animations
					minHeight: self.element.attr('data-min-height') || 200,
					maxHeight: self.element.attr('data-max-height') || 400,
					mode: mode,
					spaces: {
						toolbar: self.element.find('.toolbar')
					},
					toolbars: self.getToolbarsConfig(),
					// default UI elements which should to be registered in the editor
					uiElements: window.wgEditorExtraButtons || {},
					// this wikiaEditor is a mini editor
					isMiniEditor: true
				}
			};
		},

		init: function() {
			var data = this.getData();

			// Expose wikiaEditor instance to MiniEditor
			// It can also be referenced through the loader var, but this is more straightforward
			return (this.wikiaEditor = WikiaEditor.create(data.plugins, data.config));
		}
	});

})(this,jQuery);