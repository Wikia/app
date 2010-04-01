/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.dialog.add( 'link', function( editor )
{
	var plugin = CKEDITOR.plugins.link;
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
		this.enableSuggesionsOn(this.getContentElement('internal', 'name'));
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

		// return CKEDITOR DOM element for just created link
		var link = new CKEDITOR.dom.element(node[0]);

		// create selection after link (RT #37703)
		if (CKEDITOR.env.gecko || CKEDITOR.env.webkit) {
			var dirty = new CKEDITOR.dom.text(' ', editor.document);
			dirty.insertAfter(link);
			selection.selectElement(dirty);

			if (CKEDITOR.env.gecko) {
				// In Webkit we have to keep this text node (cursor is lost on removal of selected node)
				dirty.remove();
			}
		}

		return link;
	};

	var lang = editor.lang.link;

	return {
		title : editor.lang.link.title,
		minWidth : 500,
		minHeight : 175,
		contents : [
			{
				id : 'internal',
				label : lang.internal.tab,
				title : lang.internal.tab,
				elements : [
					{
						'type': 'text',
						'label': lang.internal.pageName,
						'id': 'name',

						validate: function() {
							var activeTab = this.getDialog().getActiveTab();
							if (activeTab == 'external') {
								return true;
							}

							// validate page name and anchors (RT #34047)
							var re = new RegExp('^(#(.+))|[' + RTE.constants.validTitleChars + ']+$');
							var validPageNameFunc = CKEDITOR.dialog.validate.regex(re, editor.lang.link.error.badPageTitle);

							return validPageNameFunc.apply(this);
						}
					},
					{
						'type': 'text',
						'label': lang.internal.linkText,
						'id': 'label'
					}
				]
			},
			{
				id : 'external',
				label : lang.external.tab,
				title : lang.external.tab,
				elements : [
					{
						'type': 'text',
						'label': lang.external.url,
						'id': 'url',

						validate: function() {
							var activeTab = this.getDialog().getActiveTab();
							if (activeTab == 'internal') {
								return true;
							}

							// validate URL
							var re = new RegExp('^(' + RTE.constants.urlProtocols + ')');
							var validUrlFunc = CKEDITOR.dialog.validate.regex(re, editor.lang.link.error.badUrl);

							return validUrlFunc.apply(this);
						}
					},
					{
						'type': 'text',
						'label': lang.external.linkText,
						'id': 'label'
					},
					{
						'type': 'checkbox',
						'label': lang.external.numberedLink,
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

			element = plugin.getSelectedLink( editor );
			if ( element && element.getAttribute( 'href' ) )
				selection.selectElement( element );
			else
				element = null;

			// setup editor fields
			setupDialog.apply( this, [editor, element] );

			// tracking
			var self = this;

			// tabs
			var tabs = this._.tabs;
			tabs.external[0].on('click', function(ev) {
				RTE.track('link', 'dialog', 'tab', 'internal2external');
			});
			tabs.internal[0].on('click', function(ev) {
				RTE.track('link', 'dialog', 'tab', 'external2internal');
			});

			// setup dialog tracking code (close / cancel)
			this.setupTracking('link');
		},

		// create new link / update link' meta data
		onOk : function()
		{
			// RT #37023 - wait until dialog is hidden
			if (this._.dontHide) {
				return;
			}

			// for tracking
			var type = '';

			// get selected tab
			var currentTab = this.getActiveTab();

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

					type = 'externalNamed';

					if (this.getValueOf('external', 'autonumber')) {
						// autonumbered link
						data.linktype = 'autonumber';
						data.text = '[1]';

						element.addClass('autonumber');

						type = 'externalNumbered';
					}

					if (data.text == '') {
						// no link text provided? generate external raw link
						data.type = 'external-raw';

						type = 'externalSimple';
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

					if (data.text == '') {
						type = 'internalSimple';
					}
					else {
						type = 'internalNamed';
					}

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

			RTE.track('link', 'dialog', 'type', type);
		}
	};
} );
