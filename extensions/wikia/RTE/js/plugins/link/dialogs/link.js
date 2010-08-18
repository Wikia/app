/*
Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.dialog.add( 'link', function( editor )
{
	var plugin = CKEDITOR.plugins.link;
	var linkTextDirty = false;
	var existsTimeout;
	var setMode = function( mode )
	{
		var linkDialog = CKEDITOR.dialog.getCurrent();

		// two things must be set to switch between int/ext mode,
		// the upper-right mode label and the radio button
		if( mode == 'external' ){
			var radios = linkDialog.getContentElement('internal','linktype');
			if( radios.getValue() != 'ext' ){
				radios.setValue('ext');
			}
			$(".link-type-note span").html(editor.lang.link.status.external);
			$(".link-type-note img")[0].className = 'sprite external';
			
			// disable suggestions on the name box if external url
		}else if( mode == 'internal' ){
			var radios = linkDialog.getContentElement('internal','linktype');
			if( radios.getValue() != 'wiki' ){
				radios.setValue('wiki');
			}
			//$(".link-type-note span").html(editor.lang.link.status.notexists);
			//$(".link-type-note span").html(editor.lang.link.status.exists);
			//$(".link-type-note img")[0].className = 'link-icon link-yes';
			checkStatus();

			// setup MW suggest
			linkDialog.enableSuggesionsOn(linkDialog.getContentElement('internal', 'name'));
		}
	};
	var checkStatus = function()
	{
		var pageName = CKEDITOR.dialog.getCurrent().getContentElement('internal','name').getValue();
		if( pageName ){
			$(".link-type-note span").html(editor.lang.link.status.checking);
			$(".link-type-note img")[0].className = 'sprite progress';
			
			// check our page name for validity
			RTE.ajax('checkInternalLink', {title: pageName}, function(data){
				if( data.exists ){
					$(".link-type-note span").html(editor.lang.link.status.exists);
					$(".link-type-note img")[0].className = 'link-icon link-yes';
				}else{
					$(".link-type-note span").html(editor.lang.link.status.notexists);
					$(".link-type-note img")[0].className = 'link-icon link-no';
				}
			});
		}
		existsTimeout = null;
	};
	var setupDialog = function( editor, element )
	{
		// set value of link dialog fields
		function setValues(tab, link, label) {
			var dialog = CKEDITOR.dialog.getCurrent();
			// only one tab, so tab is ignored but kept for future use
			dialog.setValueOf('internal', 'name', link);
			dialog.setValueOf('internal', 'label', label || '');
		}

		RTE.log('opening link dialog');

		// get link' meta data
		var data = element ? $(element.$).getData() : null;

		if (data) {
			// handle existing links

			// detect pasted links (RT #47454)
			if (typeof data.type == 'undefined') {
				RTE.log('pasted link detected');

				// detect external links
				var href = element.getAttribute('href');

				if (RTE.tools.isExternalLink(href)) {
					data = {
						type: 'external',
						link: href,
						text: element.getText()
					};
					setMode('external');
				}
			}else{
				// select a mode for our two proper link types
				if( data.type == 'internal' ){
					setMode('internal');
					setTimeout(checkStatus,200);
				}else if( data.type == 'external' ){
					setMode('external');
				}
			}

			RTE.log(data);

			var linkTextField = this.getContentElement('internal', 'label');
			switch (data.type) {
				case 'external':
					setValues('internal', data.link);

					// handle autonumbered external links
					if( data.linktype != 'autonumber' ) {
						this.setValueOf('internal', 'label', data.text);
						linkTextDirty = true;
					}
					break;

				// case 'external-raw':
				// 	setValues('external', data.link);
				// 	break;

				case 'internal':
					setValues('internal', data.link, data.text);
					linkTextDirty = true;
					break;
			}
		}
		else {
			var linkTextField = this.getContentElement('internal', 'label');
			//linkTextField.enable();
			
			// creating new link from selection
			var selectionContent = RTE.tools.getSelectionContent();
			setMode('internal');
			var tab = 'internal';

			if( selectionContent ){
				// check for external link (RT #47454)
				if (RTE.tools.isExternalLink(selectionContent)) {
					setMode('external');
					tab = 'external';
				}

				setValues(tab, selectionContent);

				RTE.log('link: using selected text "' + selectionContent + '" for new '+tab+' link');
			}else{
				
				RTE.log('link: fresh link');
			}
		}

		// Record down the selected element in the dialog.
		this._.selectedElement = element;

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
		minHeight : 185,
		contents : [
			{
				id : 'internal',
				label : lang.internal.tab,
				title : lang.internal.tab,
				elements : [
					{
						'type': 'html',
						'html': '<p class="link-type-note"><span>...</span><img alt="Link Status" class="" src="http://images1.wikia.nocookie.net/__cb21710/common/skins/common/blank.gif" /></p>',
						'id': 'linkdisplay'
					},
					{
						'type': 'text',
						'label': editor.lang.link.label.target,
						'id': 'name',
						onKeyUp: function() {
							var linkTextField = this.getDialog().getContentElement('internal', 'label');
							
							// set mode to external if we detect a link
							if( RTE.tools.isExternalLink(this.getValue()) ){
								setMode('external');
							}
							
							var linktype = this.getDialog().getContentElement('internal', 'linktype').getValue();
							if( linktype == 'wiki' ){
								// pretend we're checking for the page name,
								// but don't really check until 1000ms after we stop typing
								if( existsTimeout ){
									clearTimeout(existsTimeout);
								}
								$(".link-type-note span").html(editor.lang.link.status.checking);
								$(".link-type-note img")[0].className = 'sprite progress';
								existsTimeout = setTimeout(checkStatus,1000);
							}
							
							if( linkTextField.getValue() == '' ){
								linkTextDirty = false;
							}
							// match link text field if we're typing an internal link
							if( !linkTextDirty && linkTextField.isEnabled() ){
								linkTextField.setValue(this.getValue());
							}
						},
						validate: function() {
							var linktype = this.getDialog().getContentElement('internal', 'linktype').getValue();
							if( linktype == 'wiki' ){
								// validate page name and anchors (RT #34047)
								var re = new RegExp('^(#(.+))|[' + RTE.constants.validTitleChars + ']+$');
								var validPageNameFunc = CKEDITOR.dialog.validate.regex(re, editor.lang.link.error.badPageTitle);
								
								return validPageNameFunc.apply(this);
							}
							else{
								// validate URL
								var re = new RegExp('^(' + RTE.constants.urlProtocols + ')');
								var validUrlFunc = CKEDITOR.dialog.validate.regex(re, editor.lang.link.error.badUrl);

								return validUrlFunc.apply(this);
							}
						}
					},
					{
						'type': 'text',
						'label': editor.lang.link.label.display,
						'id': 'label',
						onFocus: function()
						{
							// no longer autofill when a user selects the link text
							linkTextDirty = true;
						}
					},
					{
						'type': 'radio',
						'items': [[editor.lang.link.label.internal,'wiki'],[editor.lang.link.label.external,'ext']],
						'default': 'wiki',
						'id': 'linktype',
						'onChange': function( e )
						{ // mode change should only happen when we're showing a dialog
							if( CKEDITOR.dialog.getCurrent() ){
								RTE.log("mode changed to "+e.data.value);
								if( e.data && e.data.value == 'ext' ){
									setMode('external');
								}else{
									setMode('internal');
								}
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
			
			// reset our dirty tracking
			linkTextDirty = false;

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

			// get selected type
			var currentType = this.getContentElement('internal', 'linktype').getValue();

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

			// check for full link to local wiki article pasted into 'internal link' tab ((RT #47456)
			if (currentType == 'wiki') {
				var href = this.getValueOf('internal', 'name');

				if (href.indexOf(window.wgServer) == 0) {
					// URL to local wiki provided - get article name from it
					var re = new RegExp( window.wgArticlePath.replace(/\$1/, '(.*)') );
					var matches = href.match(re);

					if (matches) {
						var pageName = matches[1];

						// decode page name
						pageName = decodeURIComponent(pageName);
						pageName = pageName.replace(/_/g, ' ');

						// move values to "internal" tab
						this.setValueOf('internal', 'name', pageName);
						this.setValueOf('internal', 'label', this.getValueOf('external', 'label') );

						RTE.log('internal full URL detected: ' + href + ' > ' + pageName);
					}
				}
			}

			switch (currentType) {
				case 'ext':
					data = {
						'type': 'external',
						'link': this.getValueOf('internal', 'name'),
						'text': this.getValueOf('internal', 'label'),
						'wikitext': null
					};

					type = 'externalNamed';

					if ( data.text == '' ) {
						// autonumbered link
						data.linktype = 'autonumber';
						data.text = '[1]';

						element.addClass('autonumber');

						type = 'externalNumbered';
					}
					
					element.setAttribute('href',data.link);

					// set content and class of link element
					element.setText(data.text != '' ? data.text : data.link);
					element.addClass('external');
					element.removeClass('new');
					break;
				case 'wiki':
					data = {
						'type': 'internal',
						'link': this.getValueOf('internal', 'name'),
						'text': this.getValueOf('internal', 'label'),

						// reset these fields
						'noforce': true,
						'wikitext': null
					};

					// set content of link element

					// don't modify links containing HTML formatting (RT #37706)
					if (element.getText() == element.getHtml()) {
						element.setText(data.text != '' ? data.text : data.link);
					}

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
