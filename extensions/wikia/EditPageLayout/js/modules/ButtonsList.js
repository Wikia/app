(function(window){

	var WE = window.WikiaEditor;

	WE.modules.ButtonsList = $.createClass(WE.modules.base,{
		items: [],
		getItems: function() {
			return this.items;
		},
		template: '<span class="{{className}}">{{#elements}}{{{.}}}{{/elements}}</span>',
		getData: function() {
			var items = this.getItems(),
				elements = [];
			for(var n=0; n<items.length; n++) {
				elements.push(this.ui.create(items[n]));
			}
			return {
				className: 'cke_buttons cke_toolbar_' + this.headerClass,
				elements: elements
			};
		}
	});

})(this);