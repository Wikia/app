CKEDITOR.plugins.add('rte-toolbar', {
	// register separator item
	beforeInit : function(editor) {
		editor.ui.addHandler(CKEDITOR.UI_SEPARATOR, CKEDITOR.ui.separator.handler);
		editor.ui.add('|', CKEDITOR.UI_SEPARATOR, {});
	}
});

// UI items separator
CKEDITOR.UI_SEPARATOR = 10;

CKEDITOR.ui.separator = function() {};
CKEDITOR.ui.separator.handler = {
	create: function(definition) {
		return new CKEDITOR.ui.separator();
	}
};
CKEDITOR.ui.separator.prototype = {
	render: function(editor, output) {
		output.push('<span class="cke_separator">&nbsp;</span>');
	}
};
