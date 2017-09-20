(function($, window) {
	var LayoutBuilderFormEditorLoader = $.createClass(Object,{

		element: false,

		constructor: function() {
			this.body = this.element = $('<div/>');
		},

		getData: function() {
			var plugins = [ 'plbpagecontrols' ];
			var config = {
				body: this.body,
				element: this.element,
				mode: 'source'
			};
			
			return { plugins: plugins, config: config };
		},
		
		init: function() {
			var data = this.getData();

			window.WikiaEditor.create(data.plugins,data.config);

			$('#wpSave').removeAttr('disabled');
		}
	});

	$(function() {
		var editor = new LayoutBuilderFormEditorLoader();
		editor.init();
	});

})(jQuery, window);