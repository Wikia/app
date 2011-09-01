(function(window){

	var WE = window.WikiaEditor;

	WE.modules.Autolinker = $.createClass(WE.modules.base,{
		modes: 'wysiwyg',

		headerClass: 'autolinker',
		headerTextId: 'autolinker-title',

		template: '<p><%=text%></p>',
		getData: function() {
			return {
				text: $.msg('wikia-editor-modules-autolinker-message', 0)
			};
		},

		afterRender: function() {
			$().log(this.el);
		}
	});

	// register additional module
	WE.on('wikiaeditorspaceslayout', function(element, layout, data) {
		if (layout && layout.rail) {
			layout.rail.push('Autolinker');
		}
	});

})(this);