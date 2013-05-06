( function ( $, mw ) {
	var isReady, toolbar, currentFocused;

	isReady = false;

	// Wikia change - begin - @author: wladek
	// prepare the list of standard buttons that are available in the sprite image
	var standardButtons = {};
	if ( mw.config.get( 'wgIsEditPage' ) ) {
		$.each(
			'bold italic link extlink headline image media math nowiki sig hr wmu wpg vet'.split(' '),
			function(i,v){
				var k = v == 'sig' ? 'signature' : v;
				standardButtons['mw-editbutton-' + k] = 'button-'+v;
			}
		);
	}
	// Wikia change - end - @author: wladek

	toolbar = {
		$toolbar: false,
		buttons: [],
		/**
		 * If you want to add buttons, use
		 * mw.toolbar.addButton( imageFile, speedTip, tagOpen, tagClose, sampleText, imageId, selectText );
		 */
		addButton: function () {
			if ( isReady ) {
				toolbar.insertButton.apply( toolbar, arguments );
			} else {
				toolbar.buttons.push( [].slice.call( arguments ) );
			}
		},
		insertButton: function ( imageFile, speedTip, tagOpen, tagClose, sampleText, imageId, selectText, onClick /* Wikia change */ ) {
			// Wikia change - begin (@author macbre)
			// don't add to not existing toolbar
			if (toolbar.$toolbar.length === 0) {
				return false;
			}
			// use blank source image if it's a standard button
			if ( imageId && standardButtons[imageId] ) {
				imageFile = mw.config.get( 'wgBlankImgUrl' );
			}
			// Wikia change - end

			var image = $('<img>', {
				width : 23,
				height: 22,
				src   : imageFile,
				alt   : speedTip,
				title : speedTip,
				id    : imageId || '',
				'class': 'mw-toolbar-editbutton'
			} ).click( function () {
				mw.toolbar.insertTags( tagOpen, tagClose, sampleText, selectText );
				return false;
			} );

			// Wikia change - start
			// add appropriate classes if it's a standard button
			var userLanguage = mw.config.get( 'wgUserLanguage' );
			if ( imageId && standardButtons[imageId] ) {
				image.addClass(standardButtons[imageId]);
				image.addClass(userLanguage+'-'+standardButtons[imageId]);
			}
			// add onclick handlers (@author macbre)
			if (typeof onClick === 'function') {
				image.on('click', onClick);
			}
			// Wikia change - end

			toolbar.$toolbar.append( image );
			return true;
		},

		/**
		 * apply tagOpen/tagClose to selection in textarea,
		 * use sampleText instead of selection if there is none.
		 */
		insertTags: function ( tagOpen, tagClose, sampleText, selectText ) {
			if ( currentFocused && currentFocused.length ) {
				currentFocused.textSelection(
					'encapsulateSelection', {
						'pre': tagOpen,
						'peri': sampleText,
						'post': tagClose
					}
				);

				// Wikia change - begin
				// @author kflorence
				var wikiaEditor = currentFocused.data( 'wikiaEditor' );

				// Let WikiaEditor know when things are inserted
				if ( wikiaEditor ) {
					wikiaEditor.fire( 'editorInsertTags' );
				}
				// Wikia change - end
			}
		},

		// For backwards compatibility
		init: function () {}
	};

	// Legacy (for compatibility with the code previously in skins/common.edit.js)
	window.addButton = toolbar.addButton;
	window.insertTags = toolbar.insertTags;

	// Explose publicly
	mw.toolbar = toolbar;

	$( document ).ready( function () {
		var buttons, i, c, iframe;

		// currentFocus is used to determine where to insert tags
		currentFocused = $( '#wpTextbox1' );

		// Populate the selector cache for $toolbar
		toolbar.$toolbar = $( '#toolbar' );

		// Wikia fix (wladek) - Wikia Editor takes care about MW toolbar itself
		if (typeof window.WikiaEditor == 'undefined') {
			// Legacy: Merge buttons from mwCustomEditButtons
			buttons = [].concat( toolbar.buttons, window.mwCustomEditButtons );
			for ( i = 0; i < buttons.length; i++ ) {
				if ( $.isArray( buttons[i] ) ) {
					// Passes our button array as arguments
					toolbar.insertButton.apply( toolbar, buttons[i] );
				} else {
					// Legacy mwCustomEditButtons is an object
					c = buttons[i];
					toolbar.insertButton( c.imageFile, c.speedTip, c.tagOpen,
						c.tagClose, c.sampleText, c.imageId, c.selectText, c.onclick );
				}
			}
		}

		// This causes further calls to addButton to go to insertion directly
		// instead of to the toolbar.buttons queue.
		// It is important that this is after the one and only loop through
		// the the toolbar.buttons queue
		isReady = true;

		// Make sure edit summary does not exceed byte limit
		$( '#wpSummary' ).byteLimit( 250 );

		/**
		 * Restore the edit box scroll state following a preview operation,
		 * and set up a form submission handler to remember this state
		 */
		( function scrollEditBox() {
			var editBox, scrollTop, $editForm;

			editBox = document.getElementById( 'wpTextbox1' );
			scrollTop = document.getElementById( 'wpScrolltop' );
			$editForm = $( '#editform' );
			if ( $editForm.length && editBox && scrollTop ) {
				if ( scrollTop.value ) {
					editBox.scrollTop = scrollTop.value;
				}
				$editForm.submit( function () {
					scrollTop.value = editBox.scrollTop;
				});
			}
		}() );

		$('body').on( 'focus', 'textarea, input:text', function () { // Wikia change to catch all textarea elements
			currentFocused = $(this);
		});

		// HACK: make currentFocused work with the usability iframe
		// With proper focus detection support (HTML 5!) this'll be much cleaner
		iframe = $( '.wikiEditor-ui-text iframe' );
		if ( iframe.length > 0 ) {
			$( iframe.get( 0 ).contentWindow.document )
				// for IE
				.add( iframe.get( 0 ).contentWindow.document.body )
				.focus( function () {
					currentFocused = iframe;
				} );
		}
	});

}( jQuery, mediaWiki ) );
