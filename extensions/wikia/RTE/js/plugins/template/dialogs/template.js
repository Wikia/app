/**
 *  Wikia template editor
 *
 * @author Maciej Brencz <macbre@wikia-inc.com>
 */
CKEDITOR.dialog.add('rte-template', function(editor)
{
	// return dialog structure definition
	return {
		title: 'Template editor',
		minWidth: 760,
		minHeight: 365,
		buttons: [  // [Ok] and [Choose another template]
			{
				id: 'chooseAnotherTpl',
				type: 'button',
				label: 'Choose another template',
				className: 'cke_dialog_choose_another_tpl',
				buttonType: 'secondary_back',
				onClick: function (ev) {
					// go back to step #1
					RTE.templateEditor.selectStep(1);
				}
			},
			CKEDITOR.dialog.okButton
		],
		contents: [
			{
				// step #1: search / list of popular templates
				id: 'step1',
				label: 'Step 1',
				elements: [
					{
						// template search
						type: 'hbox',
						widths: ['300px', '300px', '30px'],
						children: [
							{
								type: 'html',
								className: 'templateEditorHeader dark_text_2',
								html: 'Search for a template'
							},
							{
								id: 'templateSearchQuery',
								style: 'margin-top: 7px',
								type: 'text'
							},
							{
								id: 'templateDoSearch',
								type: 'button',
								label: 'Insert',
								style: 'position: relative; top: 6px',
								onClick: function() {
									var dialog = this.getDialog();
									var templateName = dialog.getValueOf('step1', 'templateSearchQuery');

									if (templateName == '') {
										return;
									}

									RTE.templateEditor.selectTemplate(dialog, templateName);
								}
							}
						]
					},
					{
						// horizontal line
						type: 'html',
						html: '<hr />'
					},
					{
						// browse for template
						type: 'html',
						className: 'templateEditorHeader',
						html: 'Browse for a template'
					},
					{
						// list of templates / magic words (wrapper)
						type: 'hbox',
						widths: ['510px', '250px'],
						children: [
							{
								// list of templates
								type: 'html',
								html: '<h2>Most Frequently Used</h2>' +
									'<ul id="templateEditorHotTemplates"></ul>'
							},
							{
								// list of magic words
								type: 'html',
								html: '<h2><a id="templateLinkToHelp" target="_blank" href="http://help.wikia.com/wiki/Help:Magic_words">Magic words</a></h2>' +
									'<ul id="templateEditorMagicWords"></ul>'

							}
						]
					}
				]
			},
			{
				// step #2: "visual" template editor (with parameters editor and preview)
				id: 'step2',
				label: 'Step 2',
				elements: [
					{
						// intro
						type: 'html',
						html: '<div id="templateEditorIntro">' +
							'<h1 id="templateEditorTemplateName" class="dark_text_2"></h1>' +
							'<a id="templateEditorViewLink" href="#" target="_blank">view template page (opens a new window)</a>' +
							'<p>Change the values on the left and click to preview. When you\'re done making your edits, click to save</p>' +
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
								html: '<h2>Parameters</h2>' +
									'<dl id="templateParameters"></dl>'
							},
							{
								// preview button
								type: 'button',
								label: 'Preview',
								onClick: function() {
									var self = this;

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
								html: '<h2>Preview</h2>' +
									'<div id="templatePreview" class="reset"></div>'
							}
						]
					}
				]
			}/*,
			{
				// for next dev cycle

				// step #3: "advanced" template editor (wikitext source and preview)
				id: 'step3',
				label: 'Step 3',
				elements: [
					{
						// intro
						type: 'html',
						html: '<div id="templateAdvEditorIntro">' +
							'<p>TBD</p>' +
							'</div>'
					},
					{
						// editor wrapper
						type: 'hbox',
						children: [
							{
								// wikitext source
								type: 'html',
								html: '<h2>Wikitext source</h2>' +
									'<textarea id="templateAdvEditorSource"></textarea>'
							},
							{
								// preview button
								type: 'button',
								label: 'Preview',
								onClick: function() {
									var self = this;

									// disable the button
									this.disable();
									$('#templateAdvPreview').addClass('loading').html('');

									// generate preview and re-enable the button
									var wikitext = $('#templateAdvEditorSource').attr('value');

									RTE.tools.parse(wikitext, function(html) {
										self.enable();
										$('#templateAdvPreview').removeClass('loading').html(html);
									});
								}
							},
							{
								// preview area
								type: 'html',
								html: '<h2>Preview</h2>' +
									'<div id="templateAdvPreview" class="reset"></div>'
							}
						]
					}
				]
			}*/

		],

		// event handlers
		onOk: function() {
			var step = parseInt( RTE.tools.getActiveTab(this).charAt(4) );

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

			// let's decide which screen to show by default start with step #1)
			var step = 1;

			if (typeof info !=  'undefined') {
				RTE.log(info);

				// this is template with params - step #2 (parameters editor)
				step = 2;

				/*
 				// for next dev cycle

				// this is template with params - step #2 (parameters editor)
				if ( (info.type == 'tpl') && (typeof info.availableParams != 'undefined') ) {
					step = 2;
				}

				// this is magic word - step #3 (advanced editor)
				if (info.type == 'variable') {
					step = 3;
				}
				*/
			}

			// let's show it
			RTE.templateEditor.selectStep(step);
		}
	};
});
