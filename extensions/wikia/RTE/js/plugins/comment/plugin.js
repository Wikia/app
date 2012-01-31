CKEDITOR.plugins.add('rte-comment',
{
	init: function(editor) {
		// register comments editor dialog
		CKEDITOR.dialog.add('rte-comment', this.path + 'dialogs/comment.js');
	}
});

// object used between plugin and comment editor
RTE.commentEditor = {
	// reference to placeholder of currently edited template / magic word
	placeholder: {},

	// reference to CKEDITOR.dialog object
	dialog: {},

	// show comment editor
	showCommentEditor: function(placeholder) {
		RTE.log('calling comment editor...');

		// open editor for this element
		RTE.commentEditor.placeholder = placeholder;

		// open comment editor
		RTE.getInstance().openDialog('rte-comment');
	}
};
