// Rename the "Source" button to "Wikitext".
FCKToolbarItems.RegisterItem( 'Source', new FCKToolbarButton( 'Source', 'Wikitext', null, FCK_TOOLBARITEM_ICONTEXT, true, true, 1 ) ) ;

// Here we change the SwitchEditMode function to make the Ajax call when
// switching from Wikitext.
(function() {
	var original = FCK.SwitchEditMode ;

	FCK.SwitchEditMode = function() {
		var args = arguments;

		var loadWikisyntaxToHtml = function( result ) {
			var res = result.responseText.split('--||--');
			FCK.EditingArea.Textarea.value = res[0];
			window.parent.document.getElementById('wysiwygData').value = res[1];
			original.apply( FCK, args );
		}

		var loadHtmlToWikisyntax = function( result ) {
			FCK.EditingArea.Textarea.value = result.responseText;
		}

		if ( FCK.EditMode == FCK_EDITMODE_SOURCE ) {
			window.parent.sajax_request_type = 'POST';
			window.parent.sajax_do_call( 'wfWikisyntaxToHtml', [FCK.EditingArea.Textarea.value], loadWikisyntaxToHtml) ;
		} else {
			original.apply( FCK, args );
			window.parent.sajax_request_type = 'POST';
			window.parent.sajax_do_call( 'wfHtmlToWikisyntax', [FCK.EditingArea.Textarea.value, window.parent.document.getElementById('wysiwygData').value], loadHtmlToWikisyntax) ;
		}
	}
})() ;