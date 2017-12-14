/**
 *  Wikia template editor
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */
CKEDITOR.dialog.add('infobox-parameters', function(editor)
{
	var lang = editor.lang.templateEditor;

	// help link for magic words
	var magicWordsLink = window.wgArticlePath.replace(/\$1/, lang.dialog.magicWordsLink.replace(/ /g, '_'))

	// return dialog structure definition
	return {
		title: lang.title,
		minWidth: 760,
		minHeight: 365,
		buttons: [  // [Ok] and [Choose another template]
			{
				id: 'chooseAnotherTpl',
				type: 'button',
				label: lang.editor.chooseAnotherTpl,
				className: 'cke_dialog_choose_another_tpl',
				buttonType: 'secondary',
				onClick: function (ev) {
					WikiaEditor.track( 'dialog-rte-template-button-choose-another' );

					// go back to step #1
					RTE.templateEditor.selectStep(1);
				}
			},
			CKEDITOR.dialog.okButton,
			// "fake" Cancel button to let the user close this dialog by pressing ESC (RT #37696)
			CKEDITOR.dialog.cancelButton
		],
		contents: [
			{
				id: 'ckeditorInfoboxParametersEditDialog',
				label: 'Editing infobox parameters',
				elements: [
					{
						// intro
						type: 'html',
						html: '<div id="templateEditorIntro">' +
							'<h1 id="templateEditorTemplateName" class="dark_text_2"></h1>' +
							'<a id="templateEditorViewLink" href="#" target="_blank">' + lang.editor.viewTemplate + '</a>' +
							'<p>' + lang.editor.intro  + '</p>' +
							'</div>'
					},
					{
						// editor wrapper
						type: 'hbox',
						widths: ['330px', '100px', '330px'],
						children: [
							{
								// list of parameters and their values
								type: 'html',
								html: '<h2>' + lang.editor.parameters + '</h2>' +
									'<dl id="templateParameters"></dl>'
							},
							{
								// preview button
								type: 'button',
								label: lang.editor.previewButton,
								onClick: function() {
									var self = this;

									WikiaEditor.track( 'dialog-rte-template-button-preview' );

									// disable the button
									this.disable();

									// generate preview and re-enable the button
									RTE.templateEditor.doPreview.apply(RTE.templateEditor, [function() {
										self.enable();
									}]);
								}
							},
							{
								// preview area
								type: 'html',
								html: '<h2>' + lang.editor.previewTitle  + '</h2>' +
									'<div id="templatePreview" class="reset"></div>'
							}
						]
					}
				]
			}
		],

		// event handlers
		onOk: function() {
			var step = parseInt( this.getActiveTab().charAt(4) );

			// save changes from template editor
			switch(step) {
				// popular templates / search
				case 1:
					// "submit" template search form when user hits Enter
					this.getContentElement('step1', 'templateDoSearch').fire('click');

					// prevent dialog close
					return false;

				// parameters editor
				case 2:
					// force preview generation -> new wikitext will be generated from current set of parameters
					RTE.templateEditor.doPreview(function() {
						RTE.templateEditor.commitChanges();
					});
					break;

				// advanced editor
				case 3:
					// TODO: validate wikitext
					RTE.templateEditor.data.wikitext = $('#templateAdvEditorSource').attr('value');

					// just save changes
					RTE.templateEditor.commitChanges();
					break;
			}
		},
		onShow: function() {
			// add class to template editor dialog wrapper
			this._.element.addClass('wikiaEditorDialog');
			this._.element.addClass('templateEditorDialog');

			// save reference to dialog
			RTE.templateEditor.dialog = this;

			// save reference meta data
			RTE.templateEditor.data = RTE.templateEditor.placeholder.getData();

			// get RTE double brackets info
			var info = RTE.templateEditor.placeholder.data('info');

			// let's decide which screen to show (by default start with step #1 - template chooser)
			var step = 1;

			if (info) {
				RTE.log(info);

				// this is template with params - step #2 (parameters editor)
				step = 2;
			}
		},
		// don't focus on first page when starting template editor on second page
		onFocus: function() {}
	};
});
