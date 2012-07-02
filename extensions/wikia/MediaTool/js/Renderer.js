MediaTool.Renderer = $.createClass(Observable,{

	constructor: function() {
		MediaTool.Renderer.superclass.constructor.call(this);

		MediaTool.bind('editDone', this.onEditDone, this);
	},

	onEditDone: function(cart) {
		RTE.mediaEditor.addVideo(this.getWikitext(cart), {});

		// @todo use events for that
		cart.clear();
	},

	getWikitext: function(cart) {
		var result = '';
		$.each(cart.items, function(i, item) {
			result += "[["+item.file+"]]\n";
		});
		return result;
	}

});
