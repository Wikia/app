var FanBoxes = {
	// Display right side of fanbox as user inputs info
	displayRightSide: function() {
		var rightSideOutput = document.form1.inputRightSide.value;
		document.getElementById( 'fanBoxRightSideOutput2' ).innerHTML = rightSideOutput;
	},

	/**
	 * Display left side as user inputs info and sets imagename value to empty
	 * (just in case he previously uploaded an image)
	 */
	displayLeftSide: function() {
		var leftSideOutput = document.form1.inputLeftSide.value;
		document.getElementById( 'fanBoxLeftSideOutput2' ).innerHTML = leftSideOutput;
		document.getElementById( 'fantag_image_name' ).value = '';
	},

	/**
	 * If user uploaded image, and then typed in text, and now wants to insert
	 * image again, he can just click it
	 */
	insertImageToLeft: function() {
		var imageElement = document.getElementById( 'fanbox_image' );
		document.getElementById( 'fantag_image_name' ).value = imageElement.value;
		document.getElementById( 'fanBoxLeftSideOutput2' ).innerHTML = imageElement.innerHTML;
		document.getElementById( 'inputLeftSide' ).value = '';
	},

	// Countdown as user types characters
	limitText: function( limitField, limitCount, limitNum ) {
		if( limitField.value.length > limitNum ) {
			limitField.value = limitField.value.substring( 0, limitNum );
		} else {
			limitCount.value = limitNum - limitField.value.length;
		}
	},

	// Limits the left side fanbox so user can't type in tons of characters without a space
	leftSideFanBoxFormat: function() {
		var str_left_side = document.form1.inputLeftSide.value;
		var str_left_side_length = document.form1.inputLeftSide.value.length;
		var space_position = str_left_side.substring(
			str_left_side_length - 5, str_left_side_length ).search( ' ' );
		if( str_left_side.length < 6 ) {
			document.form1.inputLeftSide.maxLength = 11;
		}
		if( space_position == -1 && str_left_side.length > 6 ) {
			document.form1.inputLeftSide.maxLength = str_left_side.length;
		}
		if( space_position == -1 && str_left_side.length == 6 ) {
			document.form1.inputLeftSide.value =
				document.form1.inputLeftSide.value.substring( 0, 5 ) + ' ' +
				document.form1.inputLeftSide.value.substring( 5, 6 );
			document.getElementById( 'fanBoxLeftSideOutput2' ).innerHTML =
				document.form1.inputLeftSide.value.substring( 0, 5 ) + ' ' +
				document.form1.inputLeftSide.value.substring( 5, 7 );
		}
		if( str_left_side.length >= 5 ) {
			document.getElementById( 'fanBoxLeftSideOutput2' ).style.fontSize = '14px';
			document.getElementById( 'textSizeLeftSide' ).value = 'mediumfont';
		} else {
			document.getElementById( 'fanBoxLeftSideOutput2' ).style.fontSize = '20px';
			document.getElementById( 'textSizeLeftSide' ).value = 'bigfont';
		}
	},

	/**
	 * Limits right side so user can't type in tons of characters without a
	 * space
	 */
	rightSideFanBoxFormat: function() {
		var str_right_side = document.form1.inputRightSide.value;
		var str_right_side_length = document.form1.inputRightSide.value.length;
		var space_position = str_right_side.substring(
			str_right_side_length - 17, str_right_side_length ).search( ' ' );
		if( str_right_side.length < 18 ) {
			document.form1.inputRightSide.maxLength = 70;
		}
		if( space_position == -1 && str_right_side.length > 18 ) {
			document.form1.inputRightSide.maxLength = str_right_side.length;
		}
		if( space_position == -1 && str_right_side.length == 18 ) {
			document.form1.inputRightSide.value =
				document.form1.inputRightSide.value.substring( 0, 17 ) + ' ' +
				document.form1.inputRightSide.value.substring( 17, 18 );
			document.getElementById( 'fanBoxRightSideOutput2' ).innerHTML =
				document.form1.inputRightSide.value.substring( 0, 17 ) + ' ' +
				document.form1.inputRightSide.value.substring( 17, 19 );
		}

		if( str_right_side.length >= 52 ) {
			document.getElementById( 'fanBoxRightSideOutput2' ).style.fontSize = '12px';
			document.getElementById( 'textSizeRightSide' ).value = 'smallfont';
		} else {
			document.getElementById( 'fanBoxRightSideOutput2' ).style.fontSize = '14px';
			document.getElementById( 'textSizeRightSide' ).value = 'mediumfont';
		}
	},

	/**
	 * The below 3 functions are used to open, add/remove, and close the fanbox
	 * popup box when you click on it
	 */
	openFanBoxPopup: function( popupBox, fanBox ) {
		popupBox = document.getElementById( popupBox );
		fanBox = document.getElementById( fanBox );
		popupBox.style.display = ( popupBox.style.display == 'block' ) ? 'none' : 'block';
		fanBox.style.display = ( fanBox.style.display == 'none' ) ? 'block' : 'none';
	},

	closeFanboxAdd: function( popupBox, fanBox ) {
		popupBox = document.getElementById( popupBox );
		fanBox = document.getElementById( fanBox );
		popupBox.style.display = 'none';
		fanBox.style.display = 'block';
	},

	/**
	 * Display image box
	 */
	displayAddImage: function( el, el2, el3 ) {
		el = document.getElementById( el );
		el.style.display = ( el.style.display == 'block' ) ? 'none' : 'block';
		el2 = document.getElementById( el2 );
		el3 = document.getElementById( el3 );
		el2.style.display = 'none';
		el3.style.display = 'inline';
	},

	/**
	 * Insert a tag (category) from the category cloud into the inputbox below
	 * it on Special:UserBoxes
	 *
	 * @param tagname String: category name
	 * @param tagnumber Integer
	 */
	insertTag: function( tagname, tagnumber ) {
		document.getElementById( 'tag-' + tagnumber ).style.color = '#CCCCCC';
		document.getElementById( 'tag-' + tagnumber ).innerHTML = tagname;
		// Funny...if you move this getElementById call into a variable and use
		// that variable here, this won't work as intended
		document.getElementById( 'pageCtg' ).value += ( ( document.getElementById( 'pageCtg' ).value ) ? ', ' : '' ) + tagname;
	},

	showMessage: function( addRemove, title, fantagId ) {
		document.getElementById( 'show-message-container' + fantagId ).style.display = 'none';
		document.getElementById( 'show-message-container' + fantagId ).style.visibility = 'hidden';
		sajax_request_type = 'POST';
		sajax_do_call( 'wfFanBoxShowaddRemoveMessage', [ addRemove, title, fantagId ], function( request ) {
			document.getElementById( 'show-message-container' + fantagId ).innerHTML = request.responseText;
			jQuery( '#show-message-container' + fantagId ).fadeIn( 2000 );
			document.getElementById( 'show-message-container' + fantagId ).style.display = 'block';
			document.getElementById( 'show-message-container' + fantagId ).style.visibility = 'visible';
		});
	},

	showAddRemoveMessageUserPage: function( addRemove, id, style ) {
		document.getElementById( 'show-message-container' + id ).style.display = 'none';
		document.getElementById( 'show-message-container' + id ).style.visibility = 'hidden';
		sajax_request_type = 'POST';
		sajax_do_call( 'wfMessageAddRemoveUserPage', [ addRemove, id, style ], function( request ) {
			document.getElementById( 'show-message-container' + id ).innerHTML = request.responseText;
			jQuery( '#show-message-container' + id ).fadeIn( 2000 );
			document.getElementById( 'show-message-container' + id ).style.display = 'block';
			document.getElementById( 'show-message-container' + id ).style.visibility = 'visible';
		});
	},

	/**
	 * Create a fantag, performing various checks before submitting the
	 * document.
	 *
	 * Moved from SpecialFanBoxes.php
	 */
	createFantag: function() {
		if( !document.getElementById( 'inputRightSide' ).value ) {
			alert( __FANBOX_MUSTENTER_RIGHT_OR__ );
			return '';
		}

		if(
			!document.getElementById( 'inputLeftSide' ).value &&
			!document.getElementById( 'fantag_image_name' ).value
		)
		{
			alert( __FANBOX_MUSTENTER_LEFT__ );
			return '';
		}

		var title = document.getElementById( 'wpTitle' ).value;
		if( !title ) {
			alert( __FANBOX_MUSTENTER_TITLE__ );
			return '';
		}

		if( title.indexOf( '#' ) > -1 ) {
			alert( __FANBOX_HASH__ );
			return '';
		}

		// Encode ampersands
		title = title.replace( '&', '%26' );

		sajax_request_type = 'POST';
		sajax_do_call(
			'wfFanBoxesTitleExists',
			[ encodeURIComponent( document.getElementById( 'wpTitle' ) ) ],
			function( req ) {
				if( req.responseText.indexOf( 'OK' ) >= 0 ) {
					document.form1.submit();
				} else {
					alert( __FANBOX_CHOOSE_ANOTHER__ );
				}
			}
		);
	},

	/**
	 * Simpler version of FanBoxes.createFantag(); this one checks that the
	 * right side input has something and that the left side input has
	 * something and then submits the form.
	 */
	createFantagSimple: function() {
		if( !document.getElementById( 'inputRightSide' ).value ) {
			alert( __FANBOX_MUSTENTER_RIGHT__ );
			return '';
		}

		if(
			!document.getElementById( 'inputLeftSide' ).value &&
			!document.getElementById( 'fantag_image_name' ).value
		)
		{
			alert( __FANBOX_MUSTENTER_LEFT__ );
			return '';
		}

		document.form1.submit();
	},

	resetUpload: function() {
		var frame = document.getElementById( 'imageUpload-frame' );
		frame.src = wgScriptPath + '/index.php?title=Special:FanBoxAjaxUpload';
		frame.style.display = 'block';
		frame.style.visibility = 'visible';
	},

	completeImageUpload: function() {
		var html = '<div style="margin:0px 0px 10px 0px;"><img height="30" width="30" src="' +
			wgScriptPath + '/extensions/FanBoxes/ajax-loader-white.gif" alt="" /></div>';
		document.getElementById( 'fanbox_image' ).innerHTML = html;
		document.getElementById( 'fanBoxLeftSideOutput2' ).innerHTML = html;
	},

	uploadComplete: function( img_tag, img_name ) {
		document.getElementById( 'fanbox_image' ).innerHTML = img_tag;
		document.getElementById( 'fanbox_image2' ).innerHTML =
			'<p><a href="javascript:FanBoxes.resetUpload();">' +
			__FANBOX_UPLOAD_NEW_IMAGE__ + '</a></p>';
		document.getElementById( 'fanbox_image' ).value = img_name;

		document.getElementById( 'fanBoxLeftSideOutput2' ).innerHTML = img_tag;
		document.getElementById( 'fantag_image_name' ).value = img_name;

		document.getElementById( 'inputLeftSide' ).value = '';
		document.getElementById( 'imageUpload-frame' ).style.display = 'none';
		document.getElementById( 'imageUpload-frame' ).style.visibility = 'hidden';
	}
};