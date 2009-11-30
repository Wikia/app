/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.dialog.add( 'link', function( editor )
{
	var setupDialog = function( editor, element )
	{
		RTE.log('opening link dialog');

		// get link' meta data
		var data = element ? $(element.$).getData() : null;

		if (data) {
			RTE.log(data);

			// get "Link text" field
			var linkTextField = this.getContentElement('external', 'label');

			linkTextField.enable();

			// select tab and fill editor
			switch (data.type) {
				case 'external':
					this.selectPage('external');

					this.setValueOf('external', 'url', data.link);

					// handle autonumbered external links
					if (data.linktype == 'autonumber') {
						this.setValueOf('external', 'autonumber', true);

						// "Link text" field should be disabled
						linkTextField.disable();
					}
					else {
						this.setValueOf('external', 'label', data.text);
					}

					break;

				case 'external-raw':
					this.selectPage('external');

					this.setValueOf('external', 'url', data.link);
					this.setValueOf('external', 'label', '');
					break;

				case 'internal':
					this.selectPage('internal');

					this.setValueOf('internal', 'name', data.link);
					this.setValueOf('internal', 'label', data.text);
					break;
			}
		}
		else {
			// creating new link from selection
			var selectionContent = RTE.tools.getSelectionContent();

			RTE.log('link: using selected text "' + selectionContent + '" for new link');

			this.selectPage('internal');

			this.setValueOf('internal', 'name', selectionContent);
			this.setValueOf('internal', 'label', '');
		}

		// Record down the selected element in the dialog.
		this._.selectedElement = element;

		// setup MW suggest
		RTE.tools.enableSuggesionsOn(this, this.getContentElement('internal', 'name'));
	};

	var createNewLink = function(editor) {
		// Create element if current selection is collapsed.
		var selection = editor.getSelection(),
			ranges = selection.getRanges();
		if ( ranges.length == 1 && ranges[0].collapsed )
		{
			var text = new CKEDITOR.dom.text( '', editor.document );
			ranges[0].insertNode( text );
			ranges[0].selectNodeContents( text );
			selection.selectRanges( ranges );
		}

		// Apply style.
		var style = new CKEDITOR.style( { element : 'a', attributes: {'_rte_new_link': true} } );
		style.type = CKEDITOR.STYLE_INLINE;		// need to override... dunno why.
		style.apply( editor.document );

		// get just created link using _rte_new_link attribute
		var node = RTE.getEditor().find('a[_rte_new_link]');
		node.removeAttr('_rte_new_link');

		// return CKEDITOR DOM element
		var element = new CKEDITOR.dom.element(node[0]);
		return element;
	};

	return {
		title : editor.lang.link.title,
		minWidth : 500,
		minHeight : 175,
		contents : [
			{
				id : 'internal',
				label : 'Internal link',
				title : 'Internal link',
				elements : [
					{
						'type': 'text',
						'label': 'Page name',
						'id': 'name',

						validate: function() {
							var activeTab = RTE.tools.getActiveTab(this.getDialog());

							var re = new RegExp('^[' + RTE.constants.validTitleChars + ']+$');
							var validPageNameFunc = CKEDITOR.dialog.validate.regex(re, editor.lang.link.noUrl);

							return (activeTab == 'external') || validPageNameFunc.apply(this);
						}
					},
					{
						'type': 'text',
						'label': 'Link text',
						'id': 'label'
					}
				]
			},
			{
				id : 'external',
				label : 'External link',
				title : 'External link',
				elements : [
					{
						'type': 'text',
						'label': 'URL',
						'id': 'url',

						validate: function() {
							var activeTab = RTE.tools.getActiveTab(this.getDialog());

							var re = new RegExp('^(' + RTE.constants.urlProtocols + ')');
							var validUrlFunc = CKEDITOR.dialog.validate.regex(re, editor.lang.link.noUrl);

							return (activeTab == 'internal') || validUrlFunc.apply(this);
						}
					},
					{
						'type': 'text',
						'label': 'Link text',
						'id': 'label'
					},
					{
						'type': 'checkbox',
						'label': 'Create a numbered link',
						'id': 'autonumber',

						onChange: function() {
							var linkTextField = this.getDialog().getContentElement('external', 'label');

							// disable link text field when autonumber is selected
							if (this.getValue()) {
								linkTextField.disable();
							}
							else {
								linkTextField.enable();
							}
						}
					}
				]
			}
		],
		// get selected link and populate dialog data
		onShow : function()
		{
			// add class to template editor dialog wrapper
			this._.element.addClass('wikiaEditorDialog');
			this._.element.addClass('linkEditorDialog');

			this.fakeObj = false;

			var editor = this.getParentEditor(),
				selection = editor.getSelection(),
				ranges = selection.getRanges(),
				element = null,
				me = this;
			// Fill in all the relevant fields if there's already one link selected.
			if ( ranges.length == 1 )
			{
				var rangeRoot = ranges[0].getCommonAncestor( true );
				element = rangeRoot.getAscendant( 'a', true );
				if ( element && element.getAttribute( 'href' ) )
				{
					selection.selectElement( element );
				}
				else
					element = null;
			}

			// setup editor fields
			setupDialog.apply( this, [editor, element] );
		},
		// create new link / update link' meta data
		onOk : function()
		{
			// get selected tab
			var currentTab = RTE.tools.getActiveTab(this);

			//RTE.log('link: selected tab "' + currentTab + '"');

			// create new link
			if (!this._.selectedElement) {
				RTE.log('creating new link...');
				var element = createNewLink.apply(this, [editor]);
			}
			else {
				var element = this._.selectedElement;
			}

			// extra check
			if (!element) {
				return;
			}

			// CSS classes (prepare)
			element.removeClass('external');
			element.removeClass('autonumber');

			// set / update meta data and link text
			var data = {};

			switch (currentTab) {
				case 'external':
					data = {
						'type': 'external',
						'link': this.getValueOf('external', 'url'),
						'text': this.getValueOf('external', 'label'),
						'wikitext': null
					};

					if (this.getValueOf('external', 'autonumber')) {
						// autonumbered link
						data.linktype = 'autonumber';
						data.text = '[1]';

						element.addClass('autonumber');
					}

					if (data.text == '') {
						// no link text provided? generate external raw link
						data.type = 'external-raw';
					}

					// set content and class of link element
					element.setText(data.text != '' ? data.text : data.link);
					element.addClass('external');
					element.removeClass('new');
					break;

				case 'internal':
					data = {
						'type': 'internal',
						'link': this.getValueOf('internal', 'name'),
						'text': this.getValueOf('internal', 'label'),

						// reset these fields
						'noforce': true,
						'wikitext': null
					};

					// set content of link element
					element.setText(data.text != '' ? data.text : data.link);

					// add .new CSS class if needed
					RTE.tools.checkInternalLink(element, data.link);
					break;
			}

			$(element.$).setData(data);

			// log updated meta data entry
			RTE.log('updating link data');
			RTE.log( [element, $(element.$).getData()] );

			// regenerate numbers of external "autonumber" links
			RTE.tools.renumberExternalLinks();

			// hide MW suggest results container
			if (typeof this._.suggestContainer != 'undefined') {
				this._.suggestContainer.css('visibility', 'hidden');
			}
		}
	};
} );
