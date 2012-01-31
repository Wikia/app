(function(window,$){
	var LayoutBuilderFormEditorLoader = $.createClass(Object,{

		element: false,

		constructor: function() {
			this.body = $('<div/>'); // FIXME!!
			this.element = $('<div/>');
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
			var e = window.editorInstance = window.WikiaEditor.create(data.plugins,data.config);
			this.element.data('wikiaeditor',e);
			$('#wpSave').removeAttr('disabled');
		}
	});

	$(function(){
		var editor = new LayoutBuilderFormEditorLoader();
		$().log(editor);
		editor.init();
	});

})(this,jQuery);