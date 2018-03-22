var current;

function licenseSelectorCheck() {
	var selector = document.getElementById( 'wpLicense' );
	var selection = selector.options[selector.selectedIndex].value;
	if( selector.selectedIndex > 0 ) {
		if( selection == '' ) {
			// Option disabled, but browser is broken and doesn't respect this
			selector.selectedIndex = 0;
		}
	}
	// We might show a preview
	wgUploadLicenseObj.fetchPreview( selection );
}

function wgUploadSetup() {
	// Disable URL box if the URL copy upload source type is not selected
	for ( var i = 0; i < wgMaxUploadFiles; i++ ) {
		var e = document.getElementById( 'wpSourceTypeurl' + i );
		if( e ) {
			if( !e.checked ) {
				var ein = document.getElementById( 'wpUploadFileURL' + i );
			}
			else {
				var ein = document.getElementById( 'wpUploadFile' + i );
			}

			if( ein ) {
				ein.setAttribute( 'disabled', 'disabled' );
			}
		}
	}

	// For MSIE/Mac: non-breaking spaces cause the <option> not to render.
	// But for some reason, setting the text to itself works
	var selector = document.getElementById( 'wpLicense' );
	if ( selector ) {
		var ua = navigator.userAgent;
		var isMacIe = ( ua.indexOf( 'MSIE' ) != -1 ) && ( ua.indexOf( 'Mac' ) != -1 );
		if ( isMacIe ) {
			for ( var i = 0; i < selector.options.length; i++ ) {
				selector.options[i].text = selector.options[i].text;
			}
		}
	}

	// Toggle source type
	for ( var i = 0; i < wgMaxUploadFiles; i++ ) {
		var sourceTypeCheckboxes = document.getElementsByName( 'wpSourceType' + i );
		for ( var j = 0; j < sourceTypeCheckboxes.length; j++ ) {
			sourceTypeCheckboxes[j].onchange = toggleUploadInputs;
		}
	}

	// AJAX wpDestFile warnings
	var htmlFormSource = document.getElementById( 'mw-htmlform-source' );
	if ( wgAjaxUploadDestCheck && htmlFormSource ) {
		// Insert an event handler that fetches upload warnings when wpDestFile
		// has been changed
		for ( var i = 0; i < wgMaxUploadFiles; i++ ) {
			document.getElementById( 'wpDestFile' + i ).onchange = function( e ) {
				wgUploadWarningObj.checkNow( this.value );
			};
		}
		// Insert a row where the warnings will be displayed just below the
		// wpDestFile row
		var optionsTable = htmlFormSource.tBodies[0];
		var row = optionsTable.insertRow( 0 );
		var td = document.createElement( 'td' );
		td.id = 'wpDestFile-warning';
		td.colSpan = 2;

		row.appendChild( td );
	}

	if ( wgAjaxLicensePreview ) {
		// License selector check
		document.getElementById( 'wpLicense' ).onchange = licenseSelectorCheck;

		// License selector table row
		var wpLicense = document.getElementById( 'wpLicense' );
		var wpLicenseRow = wpLicense.parentNode.parentNode;
		var wpLicenseTbody = wpLicenseRow.parentNode;

		var row = document.createElement( 'tr' );
		var td = document.createElement( 'td' );
		row.appendChild( td );
		td = document.createElement( 'td' );
		td.id = 'mw-license-preview';
		row.appendChild( td );

		wpLicenseTbody.insertBefore( row, wpLicenseRow.nextSibling );
	}

	// fillDestFile setup
	for ( var i = 0; i < wgUploadSourceIds.length; i++ ) {
		document.getElementById( wgUploadSourceIds[i] ).onchange = function( e ) {
			fillDestFilename( this.id );
		};
	}
}

/**
 * Iterate over all upload source fields and disable all except the selected one.
 *
 * @param enabledId The id of the selected radio button
 * @return emptiness
 */
function toggleUploadInputs() {
	// Iterate over all rows with UploadSourceField
	var rows;
	if ( document.getElementsByClassName ) {
		rows = document.getElementsByClassName( 'mw-htmlform-field-MultipleUploadSourceField' );
	} else {
		// Older browsers don't support getElementsByClassName
		rows = [];

		var allRows = document.getElementsByTagName( 'tr' );
		for ( var i = 0; i < allRows.length; i++ ) {
			if ( allRows[i].className == 'mw-htmlform-field-MultipleUploadSourceField' ) {
				rows.push( allRows[i] );
			}
		}
	}

	for ( var i = 0; i < rows.length; i++ ) {
		var inputs = rows[i].getElementsByTagName( 'input' );

		// Check if this row is selected
		var isChecked = true; // Default true in case wpSourceType is not found
		for ( var j = 0; j < inputs.length; j++ ) {
			if ( inputs[j].name.indexOf( 'wpSourceType' ) == 0 ) {
				isChecked = inputs[j].checked;
			}
		}

		// Disable all unselected rows
		for ( var j = 0; j < inputs.length; j++ ) {
			if ( inputs[j].type != 'radio' ) {
				inputs[j].disabled = !isChecked;
			}
		}
	}
}

var wgUploadWarningObj = {
	'responseCache' : { '' : '&nbsp;' },
	'nameToCheck' : '',
	'typing': false,
	'delay': 500, // ms
	'timeoutID': false,

	'keypress': function() {
		if ( !wgAjaxUploadDestCheck || !sajax_init_object() ) {
			return;
		}

		// Find file to upload
		var destFile = document.getElementById( 'wpDestFile' + current );
		var warningElt = document.getElementById( 'wpDestFile-warning' );
		if ( !destFile || !warningElt ) {
			return;
		}

		this.nameToCheck = destFile.value;

		// Clear timer
		if ( this.timeoutID ) {
			window.clearTimeout( this.timeoutID );
		}
		// Check response cache
		for ( cached in this.responseCache ) {
			if ( this.nameToCheck == cached ) {
				this.setWarning( this.responseCache[this.nameToCheck] );
				return;
			}
		}

		this.timeoutID = window.setTimeout( 'wgUploadWarningObj.timeout()', this.delay );
	},

	'checkNow': function( fname ) {
		if ( !wgAjaxUploadDestCheck || !sajax_init_object() ) {
			return;
		}
		if ( this.timeoutID ) {
			window.clearTimeout( this.timeoutID );
		}
		this.nameToCheck = fname;
		this.timeout();
	},

	'timeout' : function() {
		if ( !wgAjaxUploadDestCheck || !sajax_init_object() ) {
			return;
		}
		injectSpinner( document.getElementById( 'wpDestFile' + current ), 'destcheck' );

		// Get variables into local scope so that they will be preserved for the
		// anonymous callback. fileName is copied so that multiple overlapping
		// AJAX requests can be supported.
		var obj = this;
		sajax_do_call( 'SpecialUpload::ajaxGetExistsWarning', [this.nameToCheck],
			function( result ) {
				obj.processResult( result, obj.fileName );
			}
		);
	},

	'processResult' : function( result, fileName ) {
		removeSpinner( 'destcheck' );
		this.setWarning(result.responseText);
		this.responseCache[fileName] = result.responseText;
	},

	'setWarning' : function( warning ) {
		var warningElt = document.getElementById( 'wpDestFile-warning' );
		var ackElt = document.getElementsByName( 'wpDestFileWarningAck' );

		this.setInnerHTML( warningElt, warning );

		// Set a value in the form indicating that the warning is acknowledged and
		// doesn't need to be redisplayed post-upload
		if ( warning == '' || warning == '&nbsp;' ) {
			ackElt[0].value = '';
		} else {
			ackElt[0].value = '1';
		}

	},
	'setInnerHTML' : function( element, text ) {
		// Check for no change to avoid flicker in IE 7
		if ( element.innerHTML != text ) {
			element.innerHTML = text;
		}
	}
}

function fillDestFilename( id ) {
	if ( !wgUploadAutoFill ) {
		return;
	}
	// Remove any previously flagged errors
	var e = document.getElementById( 'mw-upload-permitted' );
	if( e ) {
		e.className = '';
	}

	var e = document.getElementById( 'mw-upload-prohibited' );
	if( e ) {
		e.className = '';
	}

	var path = document.getElementById( id ).value;
	// Find trailing part
	var slash = path.lastIndexOf( '/' );
	var backslash = path.lastIndexOf( '\\' );
	var fname;
	if ( slash == -1 && backslash == -1 ) {
		fname = path;
	} else if ( slash > backslash ) {
		fname = path.substring( slash + 1 );
	} else {
		fname = path.substring( backslash + 1 );
	}

	// Clear the filename if it does not have a valid extension.
	// URLs are less likely to have a useful extension, so don't include them in the
	// extension check.
	current = id.replace( /[^0-9]/g, '' );
	if( wgFileExtensions && id.indexOf( 'wpUploadFileURL' ) != 0 ) {
		var found = false;
		if( fname.lastIndexOf( '.' ) != -1 ) {
			var ext = fname.substr( fname.lastIndexOf( '.' ) + 1 );
			for( var i = 0; i < wgFileExtensions.length; i++ ) {
				if( wgFileExtensions[i].toLowerCase() == ext.toLowerCase() ) {
					found = true;
					break;
				}
			}
		}
		if( !found ) {
			// Not a valid extension
			// Clear the upload and set mw-upload-permitted to error
			document.getElementById( id ).value = '';
			var e = document.getElementById( 'mw-upload-permitted' );
			if( e ) {
				e.className = 'error';
			}

			var e = document.getElementById( 'mw-upload-prohibited' );
			if( e ) {
				e.className = 'error';
			}

			// Clear wpDestFile as well
			var e = document.getElementById( 'wpDestFile' + current );
			if( e ) {
				e.value = '';
			}

			return false;
		}
	}

	// Capitalise first letter and replace spaces by underscores
	// FIXME: $wgCapitalizedNamespaces
	fname = fname.charAt( 0 ).toUpperCase() + fname.substring( 1 );
	fname = fname.replace( / /g, '_' );

	// Output result
	var destFile = document.getElementById( 'wpDestFile' + current );
	if ( destFile ) {
		destFile.value = fname;
		wgUploadWarningObj.checkNow( fname );
	}
}

function toggleFilenameFiller() {
	var destName = document.getElementById( 'wpDestFile' ).value;
	if ( destName == '' || destName == ' ' ) {
		wgUploadAutoFill = true;
	} else {
		wgUploadAutoFill = false;
	}
}

var wgUploadLicenseObj = {

	'responseCache' : { '' : '' },

	'fetchPreview': function( license ) {
		if( !wgAjaxLicensePreview ) {
			return;
		}
		for ( cached in this.responseCache ) {
			if ( cached == license ) {
				this.showPreview( this.responseCache[license] );
				return;
			}
		}
		injectSpinner( document.getElementById( 'wpLicense' ), 'license' );

		var title = false;
		if(typeof current != 'undefined') {
			title = document.getElementById( 'wpDestFile' + current ).value;
		}

		if ( !title ) {
			title = 'File:Sample.jpg';
		}

		var url = wgScriptPath + '/api' + wgScriptExtension
			+ '?action=parse&text={{' + encodeURIComponent( license ) + '}}'
			+ '&title=' + encodeURIComponent( title )
			+ '&prop=text&pst&format=json';

		var req = sajax_init_object();
		req.onreadystatechange = function() {
			if ( req.readyState == 4 && req.status == 200 ) {
				wgUploadLicenseObj.processResult( eval( '(' + req.responseText + ')' ), license );
			}
		};
		req.open( 'GET', url, true );
		req.send( '' );
	},

	'processResult' : function( result, license ) {
		removeSpinner( 'license' );
		this.responseCache[license] = result['parse']['text']['*'];
		this.showPreview( this.responseCache[license] );
	},

	'showPreview' : function( preview ) {
		var previewPanel = document.getElementById( 'mw-license-preview' );
		if( previewPanel.innerHTML != preview ) {
			previewPanel.innerHTML = preview;
		}
	}

}

addOnloadHook( wgUploadSetup );

/**
 * WIKIA CHANGE
 * Disables submit button until one file is selected.
 * Depends on jQuery
 * This is not a critical component, just a user convenience.  Remove if necessary.
 */
$(function() {
	var $inputs = $('#mw-upload-form tr.mw-htmlform-field-MultipleUploadSourceField input');
	var $submit = $('#mw-upload-form input[name=wpUpload]');
	var empty = true;
	$submit.attr('disabled', 'true');
	$inputs.on('change.multiupload', function(e) {
		if(empty) {
			$inputs.each(function(i) {
				if($(this).val()) {
					empty = false;
					return false; //break
				}
			});
			if(!empty) {
				$submit.removeAttr('disabled');
				$inputs.off('.multiupload');
			}
		}
	});
});
