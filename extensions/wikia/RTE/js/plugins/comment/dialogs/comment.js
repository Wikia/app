/**
 *  Wikia comment editor
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */
CKEDITOR.dialog.add('rte-comment', function(editor)
{
	// return dialog structure definition
	return {
		title: editor.lang.commentEditor.title,
		resizable: CKEDITOR.DIALOG_RESIZE_NONE,
		minWidth: 400,
		minHeight: 150,
		contents: [
			{
				id: 'comment',
				label: 'Comment',
				elements: [
					{
						// content of edited comment
						type: 'textarea',
						id: 'content'
					}
				]
			}
		],

		// event handlers
		onOk: function() {
			var content = this.getValueOf('comment', 'content');
			var placeholder =  RTE.commentEditor.placeholder;

			// if all text is removed from edit area and saved, remove comment
			if (content == '') {
				RTE.log('removing comment');
				RTE.track('visualMode', 'comment', 'dialog', 'delete');

				placeholder.remove();
				return;
			}

			RTE.log('storing modified comment data: ' + content);
			RTE.track('visualMode', 'comment', 'dialog', 'save');

			// update placeholder
			var wikitext = '<!-- ' + content + ' -->';
			placeholder.setData({wikitext: wikitext});

			// regenerate comment preview
			placeholder.removeData('preview');
		},
		onShow: function() {
			// add class to template editor dialog wrapper
			this._.element.addClass('wikiaEditorDialog');
			this._.element.addClass('commentEditorDialog');

			// set value of textarea
			var data = RTE.commentEditor.placeholder.getData();

			// exclude comment beginning and end markers
			var wikitext = data.wikitext.replace(/^<!--\s+/, '').replace(/\s+-->$/, '');

			this.setValueOf('comment', 'content', wikitext);
		}
	};
});
