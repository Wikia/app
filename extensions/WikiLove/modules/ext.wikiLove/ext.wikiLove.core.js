( function( $ ) {

var	options = {}, // options modifiable by the user
	$dialog = null, // dialog jQuery object
	currentTypeId = null, // id of the currently selected type (e.g. 'barnstar' or 'makeyourown')
	currentSubtypeId = null, // id of the currently selected subtype (e.g. 'original' or 'special')
	currentTypeOrSubtype = null, // content of the current (sub)type (i.e. an object with title, descr, text, etc.)
	rememberData = null, // input data to remember when switching types or subtypes
	emailable = false,
	gallery = {};

$.wikiLove = {
	/**
	 * Opens the dialog and builds it if necessary.
	 */
	openDialog: function() {
		if ( $dialog === null ) {
			// Test to see if the 'E-mail this user' link exists
			emailable = $( '#t-emailuser' ).length ? true : false;

			// Build a type list like this:
			var	$typeList = $( '<ul id="mw-wikilove-types"></ul>' ),
				type;
			for ( var typeId in options.types ) {
				type = options.types[typeId];
				if ( !$.isPlainObject( type ) ) {
					continue;
				}
				var	$button = $( '<a href="#"></a>' ),
					$buttonInside = $( '<div class="mw-wikilove-inside"></div>' );

				if ( typeof type.icon == 'string' ) {
					$buttonInside.append( '<div class="mw-wikilove-icon-box"><img src="'
						+ mw.html.escape( type.icon ) + '"/></div>' );
				} else {
					$buttonInside.addClass( 'mw-wikilove-no-icon' );
				}

				$buttonInside.append( '<div class="mw-wikilove-link-text">' + mw.html.escape( type.name ) + '</div>' );

				$button.data( 'typeId', typeId );
				$button.append( '<div class="mw-wikilove-l-cap"></div>');
				$button.append( $buttonInside );
				$button.append( '<div class="mw-wikilove-r-cap"></div>');
				$typeList.append( $( '<li tabindex="0"></li>' ).append( $button ) );
			}

			var commonsLink = $( '<a>' )
					.attr( 'href', mw.msg( 'wikilove-commons-url' ) )
					.attr( 'target', '_blank' )
					.text( mw.msg( 'wikilove-commons-link' ) )
					.wrap( '<div>' ) // or .html() will only return the link text
					.parent()
					.html();
			var termsLink = $( '<a> ')
					.attr( 'href', mw.msg( 'wikilove-terms-url' ) )
					.attr( 'target', '_blank' )
					.text( mw.msg( 'wikilove-terms-link' ) )
					.wrap( '<div>' )
					.parent()
					.html();

			$dialog = $( '\
<div id="mw-wikilove-dialog">\
<div id="mw-wikilove-select-type">\
	<span class="mw-wikilove-number">1</span>\
	<h3><html:msg key="wikilove-select-type"/></h3>\
	<ul id="mw-wikilove-types"></ul>\
</div>\
<div id="mw-wikilove-get-started">\
	<h2><html:msg key="wikilove-get-started-header"/></h2>\
	<ol>\
		<li><html:msg key="wikilove-get-started-list-1"/></li>\
		<li><html:msg key="wikilove-get-started-list-2"/></li>\
		<li><html:msg key="wikilove-get-started-list-3"/></li>\
	</ol>\
	<p><a target="_blank" href="' + mw.html.escape( mw.msg( 'wikilove-what-is-this-link' ) ) + '">\
		<html:msg key="wikilove-what-is-this"/>\
	</a></p>\
	<p id="mw-wikilove-anon-warning"><strong><html:msg key="wikilove-anon-warning"/></strong></p>\
</div>\
<div id="mw-wikilove-add-details">\
	<span class="mw-wikilove-number">2</span>\
	<h3><html:msg key="wikilove-add-details"/></h3>\
	<form id="mw-wikilove-preview-form">\
		<div id="mw-wikilove-image-preview">\
			<div id="mw-wikilove-image-preview-spinner" class="mw-wikilove-spinner"></div>\
			<div id="mw-wikilove-image-preview-content"></div>\
		</div>\
		<label for="mw-wikilove-subtype" id="mw-wikilove-subtype-label"></label>\
		<select id="mw-wikilove-subtype"></select>\
		<div id="mw-wikilove-subtype-description"></div>\
		<label id="mw-wikilove-gallery-label"><html:msg key="wikilove-select-image"/></label>\
		<div id="mw-wikilove-gallery">\
			<div id="mw-wikilove-gallery-error">\
				<html:msg key="wikilove-err-gallery"/>\
				<a href="#" id="mw-wikilove-gallery-error-again"><html:msg key="wikilove-err-gallery-again"/></a>\
			</div>\
			<div id="mw-wikilove-gallery-spinner" class="mw-wikilove-spinner"></div>\
			<div id="mw-wikilove-gallery-content"></div>\
		</div>\
		<label for="mw-wikilove-header" id="mw-wikilove-header-label"><html:msg key="wikilove-header"/></label>\
		<input type="text" class="text" id="mw-wikilove-header"/>\
		<label for="mw-wikilove-title" id="mw-wikilove-title-label"><html:msg key="wikilove-title"/></label>\
		<input type="text" class="text" id="mw-wikilove-title"/>\
		<label for="mw-wikilove-image" id="mw-wikilove-image-label"><html:msg key="wikilove-image"/></label>\
		<span class="mw-wikilove-note" id="mw-wikilove-image-note"><html:msg key="wikilove-image-example"/></span>\
		<input type="text" class="text" id="mw-wikilove-image"/>\
		<div id="mw-wikilove-commons-text">\
		' + mw.html.escape( mw.msg( 'wikilove-commons-text' ) ).replace( /\$1/, commonsLink ) + '\
		</div>\
		<label for="mw-wikilove-message" id="mw-wikilove-message-label"><html:msg key="wikilove-enter-message"/></label>\
		<span class="mw-wikilove-note" id="mw-wikilove-message-note"><html:msg key="wikilove-omit-sig"/></span>\
		<textarea id="mw-wikilove-message"></textarea>\
		<div id="mw-wikilove-notify">\
			<input type="checkbox" id="mw-wikilove-notify-checkbox" name="notify"/>\
			<label for="mw-wikilove-notify-checkbox"><html:msg key="wikilove-notify"/></label>\
		</div>\
		<button class="submit" id="mw-wikilove-button-preview" type="submit"></button>\
		<div id="mw-wikilove-preview-spinner" class="mw-wikilove-spinner"></div>\
	</form>\
</div>\
<div id="mw-wikilove-preview">\
	<span class="mw-wikilove-number">3</span>\
	<h3><html:msg key="wikilove-preview"/></h3>\
	<div id="mw-wikilove-preview-area"></div>\
	<div id="mw-wikilove-terms">\
	' + mw.html.escape( mw.msg( 'wikilove-terms' ) ).replace( /\$1/, termsLink ) + '\
	</div>\
	<form id="mw-wikilove-send-form">\
		<button class="submit" id="mw-wikilove-button-send" type="submit"></button>\
		<div id="mw-wikilove-send-spinner" class="mw-wikilove-spinner"></div>\
	</form>\
</div>\
</div>' );
			$dialog.localize();

			$dialog.dialog({
					width: 800,
					position: ['center', 80],
					autoOpen: false,
					title: mw.msg( 'wikilove-dialog-title' ),
					modal: true,
					resizable: false
				});

			if ( mw.config.get( 'skin' ) == 'vector' ) {
				$( '#mw-wikilove-button-preview' ).button( {
					label: mw.msg( 'wikilove-button-preview' ),
					icons: {
						primary:'ui-icon-search'
					}
				} );
			} else {
				$( '#mw-wikilove-button-preview' ).button( {
					label: mw.msg( 'wikilove-button-preview' )
				} );
			}
			$( '#mw-wikilove-button-send' ).button( {
				label: mw.msg( 'wikilove-button-send' )
			} );
			$( '#mw-wikilove-add-details' ).hide();
			$( '#mw-wikilove-preview' ).hide();
			$( '#mw-wikilove-types' ).replaceWith( $typeList );
			$( '#mw-wikilove-gallery-error-again' ).click( $.wikiLove.showGallery );
			$( '#mw-wikilove-types a' ).click( $.wikiLove.clickType );
			$( '#mw-wikilove-subtype' ).change( $.wikiLove.changeSubtype );
			$( '#mw-wikilove-preview-form' ).submit( $.wikiLove.validatePreviewForm );
			$( '#mw-wikilove-send-form' ).click( $.wikiLove.submitSend );
			$( '#mw-wikilove-message' ).elastic(); // have the message textarea grow automatically

			if ( mw.config.get( 'wikilove-anon' ) === 0 ) {
				$( '#mw-wikilove-anon-warning' ).hide();
			}

			// When the image changes, we want to reset the preview and error message.
			$( '#mw-wikilove-image' ).change( function() {
				$( '#mw-wikilove-dialog' ).find( '.mw-wikilove-error' ).remove();
				$( '#mw-wikilove-preview' ).hide();
			} );
		}

		$dialog.dialog( 'open' );
	},

	/**
	 * Handler for the left menu. Selects a new type and initialises next section
	 * depending on whether or not to show subtypes.
	 */
	clickType: function( e ) {
		e.preventDefault();
		$.wikiLove.rememberInputData(); // remember previously entered data
		$( '#mw-wikilove-get-started' ).hide(); // always hide the get started section

		var newTypeId = $( this ).data( 'typeId' );
		if( currentTypeId != newTypeId ) { // only do stuff when a different type is selected
			currentTypeId = newTypeId;
			currentSubtypeId = null; // reset the subtype id

			$( '#mw-wikilove-types' ).find( 'a' ).removeClass( 'selected' );
			$( this ).addClass( 'selected' ); // highlight the new type in the menu

			if( typeof options.types[currentTypeId].subtypes == 'object' ) {
				// we're dealing with subtypes here
				currentTypeOrSubtype = null; // reset the (sub)type object until a subtype is selected
				$( '#mw-wikilove-subtype' ).html( '' ); // clear the subtype menu

				for( var subtypeId in options.types[currentTypeId].subtypes ) {
					// add all the subtypes to the menu while setting their subtype ids in jQuery data
					var subtype = options.types[currentTypeId].subtypes[subtypeId];
					if ( typeof subtype.option != 'undefined' ) {
						$( '#mw-wikilove-subtype' ).append(
							$( '<option></option>' ).text( subtype.option ).data( 'subtypeId', subtypeId )
						);
					}
				}
				$( '#mw-wikilove-subtype' ).show();

				// change and show the subtype label depending on the type
				$( '#mw-wikilove-subtype-label' ).text( options.types[currentTypeId].select || mw.msg( 'wikilove-select-type' ) );
				$( '#mw-wikilove-subtype-label' ).show();
				$.wikiLove.changeSubtype(); // update controls depending on the currently selected (i.e. first) subtype
			}
			else {
				// there are no subtypes, just use this type for the current (sub)type
				currentTypeOrSubtype = options.types[currentTypeId];
				$( '#mw-wikilove-subtype' ).hide();
				$( '#mw-wikilove-subtype-label' ).hide();
				$( '#mw-wikilove-image-preview' ).hide();
				$.wikiLove.updateAllDetails(); // update controls depending on this type
			}

			$( '#mw-wikilove-add-details' ).show();
			$( '#mw-wikilove-preview' ).hide();
		}
	},

	/**
	 * Handler for changing the subtype.
	 */
	changeSubtype: function() {
		$.wikiLove.rememberInputData(); // remember previously entered data

		// find out which subtype is selected
		var newSubtypeId = $( '#mw-wikilove-subtype option:selected' ).first().data( 'subtypeId' );
		if( currentSubtypeId != newSubtypeId ) { // only change stuff when a different subtype is selected
			currentSubtypeId = newSubtypeId;
			currentTypeOrSubtype = options.types[currentTypeId]
				.subtypes[currentSubtypeId];
			$( '#mw-wikilove-subtype-description' ).html( currentTypeOrSubtype.descr );

			if( currentTypeOrSubtype.gallery === undefined && currentTypeOrSubtype.image ) { // not a gallery
				$.wikiLove.showImagePreview();
			} else {
				$( '#mw-wikilove-image-preview' ).hide();
			}

			$.wikiLove.updateAllDetails();
			$( '#mw-wikilove-preview' ).hide();
		}
	},

	/**
	 * Remember data the user entered if it is different from the default.
	 */
	rememberInputData: function() {
		if ( rememberData === null) {
			rememberData = {
				header : '',
				title  : '',
				message: '',
				image  : ''
			};
		}
		if ( currentTypeOrSubtype !== null ) {
			if ( $.inArray( 'header', currentTypeOrSubtype.fields ) >= 0 &&
				( !currentTypeOrSubtype.header || $( '#mw-wikilove-header' ).val() != currentTypeOrSubtype.header ) )
			{
				rememberData.header = $( '#mw-wikilove-header' ).val();
			}
			if ( $.inArray( 'title', currentTypeOrSubtype.fields ) >= 0 &&
				( !currentTypeOrSubtype.title || $( '#mw-wikilove-title' ).val() != currentTypeOrSubtype.title ) )
			{
				rememberData.title = $( '#mw-wikilove-title' ).val();
			}
			if ( $.inArray( 'message', currentTypeOrSubtype.fields ) >= 0 &&
				( !currentTypeOrSubtype.message || $( '#mw-wikilove-message' ).val() != currentTypeOrSubtype.message ) )
			{
				rememberData.message = $( '#mw-wikilove-message' ).val();
			}
			if ( currentTypeOrSubtype.gallery === undefined && $.inArray( 'image', currentTypeOrSubtype.fields ) >= 0  &&
				( !currentTypeOrSubtype.image || $( '#mw-wikilove-image' ).val() != currentTypeOrSubtype.image ) )
			{
				rememberData.image = $( '#mw-wikilove-image' ).val();
			}
		}
	},

	/**
	 * Show a preview of the image for a subtype.
	 */
	showImagePreview: function() {
		$( '#mw-wikilove-image-preview' ).show();
		$( '#mw-wikilove-image-preview-content' ).html( '' );
		$( '#mw-wikilove-image-preview-spinner' ).fadeIn( 200 );
		var title = $.wikiLove.normalizeFilename( currentTypeOrSubtype.image );
		var loadingType = currentTypeOrSubtype;
		$.ajax({
			url: mw.config.get( 'wgServer' ) + mw.config.get( 'wgScriptPath' ) + '/api.php?',
			data: {
				'action'      : 'query',
				'format'      : 'json',
				'prop'        : 'imageinfo',
				'iiprop'      : 'mime|url',
				'titles'      : title,
				'iiurlwidth'  : 75,
				'iiurlheight' : 68
			},
			dataType: 'json',
			type: 'POST',
			success: function( data ) {
				if ( !data || !data.query || !data.query.pages ) {
					$( '#mw-wikilove-image-preview-spinner' ).fadeOut( 200 );
					return;
				}
				if ( loadingType != currentTypeOrSubtype ) {
					return;
				}
				$.each( data.query.pages, function( id, page ) {
					if ( page.imageinfo && page.imageinfo.length ) {
						// build an image tag with the correct url
						var $img = $( '<img/>' )
							.attr( 'src', page.imageinfo[0].thumburl )
							.hide()
							.load( function() {
								$( '#mw-wikilove-image-preview-spinner' ).hide();
								$( this ).css( 'display', 'inline-block' );
							} );
						$( '#mw-wikilove-image-preview-content' ).append( $img );
					}
				});
			},
			error: function() {
				$( '#mw-wikilove-image-preview-spinner' ).fadeOut( 200 );
			}
		});
	},

	/**
	 * Called when type or subtype changes, updates controls.
	 */
	updateAllDetails: function() {
		$( '#mw-wikilove-dialog' ).find( '.mw-wikilove-error' ).remove();

		// use remembered data for fields that can be set by the user
		var currentRememberData = {
			'header' : ( $.inArray( 'header', currentTypeOrSubtype.fields )  >= 0 ? rememberData.header : '' ),
			'title'  : ( $.inArray( 'title', currentTypeOrSubtype.fields )   >= 0 ? rememberData.title : '' ),
			'message': ( $.inArray( 'message', currentTypeOrSubtype.fields ) >= 0 ? rememberData.message : '' ),
			'image'  : ( $.inArray( 'image', currentTypeOrSubtype.fields )   >= 0 ? rememberData.image : '' )
		};

		// only show the description if it exists for this type or subtype
		if( typeof currentTypeOrSubtype.descr == 'string' ) {
			$( '#mw-wikilove-subtype-description').show();
		} else {
			$( '#mw-wikilove-subtype-description').hide();
		}

		// show or hide header label and textbox depending on fields configuration
		$( '#mw-wikilove-header, #mw-wikilove-header-label' )
			.toggle( $.inArray( 'header', currentTypeOrSubtype.fields ) >= 0 );

		// set the new text for the header textbox
		$( '#mw-wikilove-header' ).val( currentRememberData.header || currentTypeOrSubtype.header || '' );

		// show or hide title label and textbox depending on fields configuration
		$( '#mw-wikilove-title, #mw-wikilove-title-label')
			.toggle( $.inArray( 'title', currentTypeOrSubtype.fields ) >= 0 );

		// set the new text for the title textbox
		$( '#mw-wikilove-title' ).val( currentRememberData.title || currentTypeOrSubtype.title || '' );

		// show or hide image label and textbox depending on fields configuration
		$( '#mw-wikilove-image, #mw-wikilove-image-label, #mw-wikilove-image-note, #mw-wikilove-commons-text' )
			.toggle( $.inArray( 'image', currentTypeOrSubtype.fields ) >= 0 );

		// set the new text for the image textbox
		$( '#mw-wikilove-image' ).val( currentRememberData.image || currentTypeOrSubtype.image || '' );

		if( typeof currentTypeOrSubtype.gallery == 'object'
			&& $.isArray( currentTypeOrSubtype.gallery.imageList )
		) {
			$( '#mw-wikilove-gallery, #mw-wikilove-gallery-label' ).show();
			$.wikiLove.showGallery(); // build gallery from array of images
		}
		else {
			$( '#mw-wikilove-gallery, #mw-wikilove-gallery-label' ).hide();
		}

		// show or hide message label and textbox depending on fields configuration
		$( '#mw-wikilove-message, #mw-wikilove-message-label, #mw-wikilove-message-note' )
			.toggle( $.inArray( 'message', currentTypeOrSubtype.fields ) >= 0 );

		// set the new text for the message textbox
		$( '#mw-wikilove-message' ).val( currentRememberData.message || currentTypeOrSubtype.message || '' );

		if( $.inArray( 'notify', currentTypeOrSubtype.fields ) >= 0 && emailable ) {
			$( '#mw-wikilove-notify' ).show();
		} else {
			$( '#mw-wikilove-notify' ).hide();
			$( '#mw-wikilove-notify-checkbox' ).attr('checked', false);
		}
	},

	/**
	 * Handler for clicking the preview button.
	 */
	validatePreviewForm: function( e ) {
		e.preventDefault();
		$( '#mw-wikilove-preview' ).hide();
		$( '#mw-wikilove-dialog' ).find( '.mw-wikilove-error' ).remove();

		// Check for a header if it is required
		if( $.inArray( 'header', currentTypeOrSubtype.fields ) >= 0 && $( '#mw-wikilove-header' ).val().length === 0 ) {
			$.wikiLove.showAddDetailsError( 'wikilove-err-header' ); return false;
		}

		// Check for a title if it is required, and otherwise use the header text
		if( $.inArray( 'title', currentTypeOrSubtype.fields ) >= 0 && $( '#mw-wikilove-title' ).val().length === 0 ) {
			$( '#mw-wikilove-title' ).val( $( '#mw-wikilove-header' ).val() );
		}

		if( $.inArray( 'message', currentTypeOrSubtype.fields ) >= 0 ) {
			// Check for a message if it is required
			if ( $( '#mw-wikilove-message' ).val().length <= 0 ) {
				$.wikiLove.showAddDetailsError( 'wikilove-err-msg' ); return false;
			}
			// If there's a signature already in the message, throw an error
			if ( $( '#mw-wikilove-message' ).val().indexOf( '~~~' ) >= 0 ) {
				$.wikiLove.showAddDetailsError( 'wikilove-err-sig' ); return false;
			}
		}

		// Split image validation depending on whether or not it is a gallery
		if ( typeof currentTypeOrSubtype.gallery == 'undefined' ) { // not a gallery
			if ( $.inArray( 'image', currentTypeOrSubtype.fields ) >= 0 ) { // asks for an image
				if ( $( '#mw-wikilove-image' ).val().length === 0 ) { // no image entered
					// Give them the default image and continue with preview.
					$( '#mw-wikilove-image' ).val( options.defaultImage );
					$.wikiLove.submitPreview();
				} else { // image was entered by user
					// Make sure the image exists
					var imageTitle = $.wikiLove.normalizeFilename( $( '#mw-wikilove-image' ).val() );
					$( '#mw-wikilove-preview-spinner' ).fadeIn( 200 );

					$.ajax( {
						url: mw.config.get( 'wgServer' ) + mw.config.get( 'wgScriptPath' ) + '/api.php?',
						data: {
							'action': 'query',
							'format': 'json',
							'titles': imageTitle,
							'prop': 'imageinfo'
						},
						dataType: 'json',
						success: function( data ) {
							// See if image exists locally or through InstantCommons
							if ( !data.query.pages[-1] || data.query.pages[-1].imageinfo) {
								// Image exists
								$.wikiLove.submitPreview();
								$.wikiLove.logCustomImageUse( imageTitle, 1 );
							} else {
								// Image does not exist
								$.wikiLove.showAddDetailsError( 'wikilove-err-image-bad' );
								$.wikiLove.logCustomImageUse( imageTitle, 0 );
								$( '#mw-wikilove-preview-spinner' ).fadeOut( 200 );
							}
						},
						error: function() {
							$.wikiLove.showAddDetailsError( 'wikilove-err-image-api' );
							$( '#mw-wikilove-preview-spinner' ).fadeOut( 200 );
						}
					} );
				}
			} else { // doesn't ask for an image
				$.wikiLove.submitPreview();
			}
		} else { // a gallery
			if ( $( '#mw-wikilove-image' ).val().length === 0 ) { // no image selected
				// Display an error telling them to select an image.
				$.wikiLove.showAddDetailsError( 'wikilove-err-image' ); return false;
			} else { // image was selected
				$.wikiLove.submitPreview();
			}
		}
	},

	/**
	 * After the form is validated, perform preview.
	 */
	submitPreview: function() {
		var text = $.wikiLove.prepareMsg( currentTypeOrSubtype.text || options.types[currentTypeId].text || options.defaultText );
		$.wikiLove.doPreview( '==' + $( '#mw-wikilove-header' ).val() + "==\n" + text );
	},

	showAddDetailsError: function( errmsg ) {
		$( '#mw-wikilove-add-details' ).append( $( '<div class="mw-wikilove-error"></div>' ).text( mw.msg( errmsg ) ) );
	},

	showPreviewError: function( errmsg ) {
		$( '#mw-wikilove-preview' ).append( $( '<div class="mw-wikilove-error"></div>' ).text( mw.msg( errmsg ) ) );
	},

	/**
	 * Prepares a message or e-mail body by replacing placeholders.
	 * $1: message entered by the user
	 * $2: title of the item
	 * $3: title of the image
	 * $4: image size
	 * $5: background color
	 * $6: border color
	 * $7: username of the recipient
	 */
	prepareMsg: function( msg ) {

		msg = msg.replace( '$1', $( '#mw-wikilove-message' ).val() ); // replace the raw message
		msg = msg.replace( '$2', $( '#mw-wikilove-title' ).val() ); // replace the title
		var imageName = $.wikiLove.normalizeFilename( $( '#mw-wikilove-image' ).val() );
		msg = msg.replace( '$3', imageName ); // replace the image
		msg = msg.replace( '$4', currentTypeOrSubtype.imageSize || options.defaultImageSize ); // replace the image size
		msg = msg.replace( '$5', currentTypeOrSubtype.backgroundColor || options.defaultBackgroundColor ); // replace the background color
		msg = msg.replace( '$6', currentTypeOrSubtype.borderColor || options.defaultBorderColor ); // replace the border color
		msg = msg.replace( '$7', '<nowiki>' + mw.config.get( 'wikilove-recipient' ) + '</nowiki>' ); // replace the username we're sending to

		return msg;
	},

	/**
	 * Normalize a filename.
	 * This function will extract a filename from a URL or add a "File:" prefix if there isn't
	 * already a media namespace prefix.
	 */
	normalizeFilename: function( filename ) {
		// If a URL is given, extract and decode the filename
		var index = filename.lastIndexOf( "/" ) + 1;
		filename = filename.substr( index );
		if ( index > 0 ) filename = decodeURI( filename );
		// Can't use mw.Title in 1.17
		var	prefixSplit = filename.split( ':' ),
			// Make sure the we don't fail in case input is like "File.jpg"
			prefix = prefixSplit[1] ? prefixSplit[0] : '',
			normalized = $.trim( prefix ).toLowerCase().replace( /\s/g, '_' );
		// wgNamespaceIds is missing 'file' in 1.17 on non-English wikis
		if ( mw.config.get( 'wgNamespaceIds' )[normalized] !== 6 && normalized !== 'file' ) {
			filename = 'File:' + filename;
		}
		return filename;
	},

	/**
	 * Log each time a user attempts to use a custom image via the Make your own feature.
	 */
	logCustomImageUse: function( imageTitle, success ) {
		$.ajax( {
			url: mw.config.get( 'wgServer' ) + mw.config.get( 'wgScriptPath' ) + '/api.php?',
			data: {
				'action': 'wikiloveimagelog',
				'image': imageTitle,
				'success': success,
				'format': 'json'
			},
			dataType: 'json'
		} );
	},

	/**
	 * Fires AJAX request for previewing wikitext.
	 */
	doPreview: function( wikitext ) {
		$( '#mw-wikilove-preview-spinner' ).fadeIn( 200 );
		$.ajax({
			url: mw.config.get( 'wgServer' ) + mw.config.get( 'wgScriptPath' ) + '/api.php?',
			data: {
				'action': 'parse',
				'title': mw.config.get( 'wgPageName' ),
				'format': 'json',
				'text': wikitext,
				'prop': 'text',
				'pst': true
			},
			dataType: 'json',
			type: 'POST',
			success: function( data ) {
				$.wikiLove.showPreview( data.parse.text['*'] );
				$( '#mw-wikilove-preview-spinner' ).fadeOut( 200 );
			},
			error: function() {
				$.wikiLove.showAddDetailsError( 'wikilove-err-preview-api' );
				$( '#mw-wikilove-preview-spinner' ).fadeOut( 200 );
			}
		});
	},

	/**
	 * Callback for the preview function. Sets the preview area with the HTML and fades it in.
	 */
	showPreview: function( html ) {
		$( '#mw-wikilove-preview-area' ).html( html );
		$( '#mw-wikilove-preview' ).fadeIn( 200 );
	},

	/**
	 * Handler for the send (final submit) button. Builds the data for the AJAX request.
	 * The type sent for statistics is 'typeId-subtypeId' when using subtypes,
	 * or simply 'typeId' otherwise.
	 */
	submitSend: function( e ) {
		e.preventDefault();
		$( '#mw-wikilove-dialog' ).find( '.mw-wikilove-error' ).remove();

		// Check for a header if it is required
		if( $.inArray( 'header', currentTypeOrSubtype.fields ) >= 0 && $( '#mw-wikilove-header' ).val().length === 0 ) {
			$.wikiLove.showAddDetailsError( 'wikilove-err-header' ); return false;
		}

		// Check for a title if it is required, and otherwise use the header text
		if( $.inArray( 'title', currentTypeOrSubtype.fields ) >= 0 && $( '#mw-wikilove-title' ).val().length === 0 ) {
			$( '#mw-wikilove-title' ).val( $( '#mw-wikilove-header' ).val() );
		}

		if( $.inArray( 'message', currentTypeOrSubtype.fields ) >= 0 ) {
			// If there's a signature already in the message, throw an error
			if ( $( '#mw-wikilove-message' ).val().indexOf( '~~~' ) >= 0 ) {
				$.wikiLove.showAddDetailsError( 'wikilove-err-sig' ); return false;
			}
		}

		// We don't need to do any image validation here since its not actually possible to click
		// Send WikiLove without having a valid image entered.

		var submitData = {
			'header': $( '#mw-wikilove-header' ).val(),
			'text': $.wikiLove.prepareMsg( currentTypeOrSubtype.text || options.types[currentTypeId].text || options.defaultText ),
			'message': $( '#mw-wikilove-message' ).val(),
			'type': currentTypeId
				+ (currentSubtypeId !== null ? '-' + currentSubtypeId : '')
		};
		if ( $( '#mw-wikilove-notify-checkbox:checked' ).val() && emailable ) {
			submitData.email = $.wikiLove.prepareMsg( currentTypeOrSubtype.email );
		}
		$.wikiLove.doSend( submitData.header, submitData.text,
			submitData.message, submitData.type, submitData.email );
	},

	/**
	 * Fires the final AJAX request and then redirects to the talk page where the content is added.
	 */
	doSend: function( subject, wikitext, message, type, email ) {
		$( '#mw-wikilove-send-spinner' ).fadeIn( 200 );

		var sendData = {
			action: 'wikilove',
			format: 'json',
			title: mw.config.get( 'wgPageName' ),
			type: type,
			text: wikitext,
			message: message,
			subject: subject,
			token: mw.config.get( 'wikilove-edittoken' ) // after 1.17 this can become mw.user.tokens.get( 'editToken' )
		};

		if ( email ) {
			sendData.email = email;
		}

		$.ajax( {
			url: mw.config.get( 'wgScriptPath' ) + '/api.php',
			data: sendData,
			dataType: 'json',
			type: 'POST',
			success: function( data ) {
				$( '#mw-wikilove-send-spinner' ).fadeOut( 200 );

				if ( data.error !== undefined ) {
					$.wikiLove.showPreviewError( data.error.info );
					return;
				}

				if ( data.redirect !== undefined ) {
					var	targetBaseUrl = mw.util.wikiGetlink( data.redirect.pageName ),
						// currentBaseUrl is the current URL minus the hash fragment
						currentBaseUrl = window.location.href.split("#")[0];

					// Set window location to user talk page URL + WikiLove anchor hash.
					// Unfortunately, in the most common scenario (starting from the user talk
					// page) this won't reload the page since the browser will simply try to jump
					// to the anchor within the existing page (which doesn't exist). This does,
					// however, prepare us for the subsequent reload, making sure that the user is
					// directed to the WikiLove message instead of just being left at the top of
					// the page. In the case that we are starting from a different page, this sends
					// the user immediately to the new WikiLove message on the user talk page.
					window.location = targetBaseUrl + '#' + data.redirect.fragment; // data.redirect.fragment is already encoded

					// If we were already on the user talk page, then reload the page so that the
					// new WikiLove message is displayed.
					// @todo: an expandUrl() would be very nice indeed!
					if (
						mw.config.get( 'wgServer' ) + targetBaseUrl === currentBaseUrl
						// Compatibility with 1.17 (mw.util.wikiGetlink prepends wgServer in 1.17)
						|| targetBaseUrl === currentBaseUrl
						// Compatibility with protocol-relative URLs in 1.18+
						|| window.location.protocol + mw.config.get( 'wgServer' ) + targetBaseUrl === currentBaseUrl
						// Compatibility with protocol-relative URLs in 1.17
						|| window.location.protocol + targetBaseUrl === currentBaseUrl
					) {
						window.location.reload();
					}
				} else {
					$.wikiLove.showPreviewError( 'wikilove-err-send-api' );
				}
			},
			error: function() {
				$.wikiLove.showPreviewError( 'wikilove-err-send-api' );
				$( '#mw-wikilove-send-spinner' ).fadeOut( 200 );
			}
		});
	},

	/**
	 * This function is called if the gallery is an array of images. It retrieves the image
	 * thumbnails from the API, and constructs a thumbnail gallery with them.
	 */
	showGallery: function() {
		$( '#mw-wikilove-gallery-content' ).html( '' );
		gallery = {};
		$( '#mw-wikilove-gallery-spinner' ).fadeIn( 200 );
		$( '#mw-wikilove-gallery-error' ).hide();

		if ( currentTypeOrSubtype.gallery.number === undefined
		    || currentTypeOrSubtype.gallery.number <= 0
		) {
			currentTypeOrSubtype.gallery.number = currentTypeOrSubtype.gallery.imageList.length;
		}

		var titles = '';
		var imageList = currentTypeOrSubtype.gallery.imageList.slice( 0 );
		for ( var i=0; i<currentTypeOrSubtype.gallery.number; i++ ) {
			// get a random image from imageList and add it to the list of titles to be retrieved
			var id = Math.floor( Math.random() * imageList.length );
			titles = titles + $.wikiLove.normalizeFilename( imageList[id] ) + '|';

			// remove the randomly selected image from imageList so that it can't be added twice
			imageList.splice(id, 1);
		}

		var	index = 0,
			loadingType = currentTypeOrSubtype,
			loadingIndex = 0;
		$.ajax({
			url: mw.config.get( 'wgServer' ) + mw.config.get( 'wgScriptPath' ) + '/api.php?',
			data: {
				'action'      : 'query',
				'format'      : 'json',
				'prop'        : 'imageinfo',
				'iiprop'      : 'mime|url',
				'titles'      : titles,
				'iiurlwidth'  : currentTypeOrSubtype.gallery.width,
				'iiurlheight' : currentTypeOrSubtype.gallery.height
			},
			dataType: 'json',
			type: 'POST',
			success: function( data ) {
				if ( !data || !data.query || !data.query.pages ) {
					$( '#mw-wikilove-gallery-error' ).show();
					$( '#mw-wikilove-gallery-spinner' ).fadeOut( 200 );
					return;
				}

				if ( loadingType != currentTypeOrSubtype ) {
					return;
				}
				var galleryNumber = currentTypeOrSubtype.gallery.number;

				$.each( data.query.pages, function( id, page ) {
					if ( page.imageinfo && page.imageinfo.length ) {
						// build an image tag with the correct url
						var $img = $( '<img/>' )
							.attr( 'src', page.imageinfo[0].thumburl )
							.hide()
							.load( function() {
								$( this ).css( 'display', 'inline-block' );
								loadingIndex++;
								if ( loadingIndex >= galleryNumber ) {
									$( '#mw-wikilove-gallery-spinner' ).fadeOut( 200 );
								}
							} );
						$( '#mw-wikilove-gallery-content' ).append(
							$( '<a href="#"></a>' )
								.attr( 'id', 'mw-wikilove-gallery-img-' + index )
								.append( $img )
								.click( function( e ) {
									e.preventDefault();
									$( '#mw-wikilove-gallery a' ).removeClass( 'selected' );
									$( this ).addClass( 'selected' );
									$( '#mw-wikilove-image' ).val( gallery[$( this ).attr( 'id' )] );
								})
						);
						gallery['mw-wikilove-gallery-img-' + index] = page.title;
						index++;
					}
				} );
				// Pre-select first image
				/* $('#mw-wikilove-gallery-img-0 img').trigger('click'); */
			},
			error: function() {
				$( '#mw-wikilove-gallery-error' ).show();
				$( '#mw-wikilove-gallery-spinner' ).fadeOut( 200 );
			}
		});
	},

	/**
	 * Init function which is called upon page load. Binds the WikiLove icon to opening the dialog.
	 */
	init: function() {
		var $wikiLoveLink = $( [] );
		options = $.wikiLoveOptions;

		if ( $( '#ca-wikilove' ).length ) {
			$wikiLoveLink = $( '#ca-wikilove' ).find( 'a' );
		} else { // legacy skins
			$wikiLoveLink = $( '#topbar a:contains(' + mw.msg( 'wikilove-tab-text' ) + ')' );
		}
		$wikiLoveLink.unbind( 'click' );
		$wikiLoveLink.click( function( e ) {
			e.preventDefault();
			$.wikiLove.openDialog();
		});
	}

	/**
	 * This is a bit of a hack to show some random images. A predefined set of image infos are
	 * retrieved using the API. Then we randomise this set ourselves and select some images to
	 * show. Eventually we probably want to make a custom API call that does this properly and
	 * also allows for using remote galleries such as Commons, which is now prohibited by JS.
	 *
	 * For now this function is disabled. It also shares code with the current gallery function,
	 * so when enabling it again it should be implemented cleaner with a custom API call, and
	 * without duplicate code between functions
	 */
	/*
	makeGallery: function() {
		$( '#mw-wikilove-gallery-content' ).html( '' );
		gallery = {};
		$( '#mw-wikilove-gallery-spinner' ).fadeIn( 200 );

		$.ajax({
			url: mw.config.get( 'wgServer' ) + mw.config.get( 'wgScriptPath' ) + '/api.php?',
			data: {
				'action'      : 'query',
				'format'      : 'json',
				'prop'        : 'imageinfo',
				'iiprop'      : 'mime|url',
				'iiurlwidth'  : currentTypeOrSubtype.gallery.width,
				'generator'   : 'categorymembers',
				'gcmtitle'    : currentTypeOrSubtype.gallery.category,
				'gcmnamespace': 6,
				'gcmsort'     : 'timestamp',
				'gcmlimit'    : currentTypeOrSubtype.gallery.total
			},
			dataType: 'json',
			type: 'POST',
			success: function( data ) {
				// clear
				$( '#mw-wikilove-gallery-content' ).html( '' );
				gallery = {};

				// if we have any images at all
				if( data.query) {
					// get the page keys which are just ids
					var keys = Object.keys( data.query.pages );

					// try to find "num" images to show
					for( var i=0; i<currentTypeOrSubtype.gallery.num; i++ ) {
						// continue looking for a new image until we have found one thats valid
						// or until we run out of images
						while( keys.length > 0 ) {
							// get a random page
							var id = Math.floor( Math.random() * keys.length );
							var page = data.query.pages[keys[id]];

							// remove the random page from the keys array
							keys.splice(id, 1);

							// only add the image if it's actually an image
							if( page.imageinfo[0].mime.substr(0,5) == 'image' ) {
								// build an image tag with the correct url and width
								var $img = $( '<img/>' )
									.attr( 'src', page.imageinfo[0].url )
									.attr( 'width', currentTypeOrSubtype.gallery.width )
									.hide()
									.load( function() { $( this ).css( 'display', 'inline-block' ); } );

								// append the image to the gallery and also make sure it's selectable
								$( '#mw-wikilove-gallery-content' ).append(
									$( '<a href="#"></a>' )
										.attr( 'id', 'mw-wikilove-gallery-img-' + i )
										.append( $img )
										.click( function( e ) {
											e.preventDefault();
											$( '#mw-wikilove-gallery a' ).removeClass( 'selected' );
											$( this ).addClass( 'selected' );
											$( '#mw-wikilove-image' ).val( gallery[$( this ).attr( 'id' )] );
										})
								);

								// save the page title into an array so we know which image id maps to which title
								gallery['mw-wikilove-gallery-img-' + i] = page.title;
								break;
							}
						}
					}
				}
				if( gallery.length === 0 ) {
					$( '#mw-wikilove-gallery' ).hide();
					$( '#mw-wikilove-gallery-label' ).hide();
				}

				$( '#mw-wikilove-gallery-spinner' ).fadeOut( 200 );
			}
		});
	},
	*/
};


$( document ).ready( $.wikiLove.init );
} ) ( jQuery );
