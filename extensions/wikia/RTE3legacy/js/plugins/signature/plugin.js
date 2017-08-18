CKEDITOR.plugins.add('rte-signature',
{
	init: function(editor) {
		// register "Add Signature" command
		editor.addCommand('addsignature', {
			exec: function(editor) {
				var sig = RTE.getInstance().document.createText(editor.config.signature_markup);

				// insert signature (wrapped inside jQuery object)
				RTE.tools.insertElement( $(sig.$) );
			}
		});

		// register "Signature" toolbar button
		editor.ui.addButton('Signature', {
			title: editor.lang.signature.add,
			label: editor.lang.signature.label,
			className: 'cke_label_button cke_button_signature',
			command: 'addsignature'
		});
	}
});

// wikimarkup of signature to be added
CKEDITOR.config.signature_markup = '~~~~';
