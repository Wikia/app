/**
 * JavaScript file for the PictureGame extension
 *
 * @file
 * @ingroup Extensions
 * @author Jack Phoenix <jack@countervandalism.net>
 * @date 25 June 2011
 */
var PictureGame = {
	currImg: 0, // from editpanel.js

	/**
	 * Unflags an image
	 *
	 * @param id Integer:
	 */
	unflag: function( id ) {
		jQuery( '.admin-container #' + id ).fadeOut();
		jQuery.get(
			wgScript,//mw.config.get( 'wgScript' ),
			{
				title: 'Special:PictureGameHome',
				picGameAction: 'adminPanelUnflag',
				chain: __admin_panel_now__,
				key: __admin_panel_key__,
				id: id
			},
			function( data ) {
				alert( data );
			}
		);
	},

	/**
	 * Deletes the images
	 *
	 * @param id Integer
	 * @param img1 String: MediaWiki image name
	 * @param img2 String: MediaWiki image name
	 */
	deleteimg: function( id, imageName1, imageName2 ) {
		jQuery( '.admin-container #' + id ).fadeOut();
		jQuery.get(
			wgScript,//mw.config.get( 'wgScript' ),
			{
				title: 'Special:PictureGameHome',
				picGameAction: 'adminPanelDelete',
				chain: __admin_panel_now__,
				key: __admin_panel_key__,
				id: id,
				img1: imageName1,
				img2: imageName2
			},
			function( data ) {
				alert( data );
			}
		);
	},

	/**
	 * Unprotects an image
	 *
	 * @param id Integer:
	 */
	unprotect: function( id ) {
		jQuery( '.admin-container #' + id ).fadeOut();
		jQuery.get(
			wgScript,//mw.config.get( 'wgScript' ),
			{
				title: 'Special:PictureGameHome',
				picGameAction: 'unprotectImages',
				chain: __admin_panel_now__,
				key: __admin_panel_key__,
				id: id
			},
			function( data ) {
				alert( data );
			}
		);
	},

	/* Shows the upload frame */
	loadUploadFrame: function( filename, img ) {
		PictureGame.currImg = img;

		if( img == 1 ) {
			document.getElementById( 'edit-image-text' ).innerHTML =
				'<h2> ' + __picturegame_editing_imgone__ + ' </h2>';
		} else {
			document.getElementById( 'edit-image-text' ).innerHTML =
				'<h2> ' + __picturegame_editing_imgtwo__ + ' </h2>';
		}

		document.getElementById( 'upload-frame' ).src = wgScript +
			'?title=Special:PictureGameAjaxUpload&wpOverwriteFile=true&wpDestFile=' +
			filename;
		document.getElementById( 'edit-image-frame' ).style.display = 'block';
		document.getElementById( 'edit-image-frame' ).style.visibility = 'visible';
	},

	uploadError: function( message ) {
		document.getElementById( 'loadingImg' ).style.display = 'none';
		document.getElementById( 'loadingImg' ).style.visibility = 'hidden';
		alert( message );
		document.getElementById( 'edit-image-frame' ).style.display = 'block';
		document.getElementById( 'edit-image-frame' ).style.visibility = 'visible';
		document.getElementById( 'upload-frame' ).src = document.getElementById( 'upload-frame' ).src;
	},

	/* Called when the upload starts */
	completeImageUpload: function() {
		var frame = document.getElementById( 'edit-image-frame' );
		var loadingImg = document.getElementById( 'loadingImg' );
		if ( frame ) {
			frame.style.display = 'none';
			frame.style.visibility = 'hidden';
		}
		if ( loadingImg ) {
			loadingImg.style.display = 'block';
			loadingImg.style.visibility = 'visible';
		}
	},

	/**
	 * Called when the upload is complete
	 *
	 * @param imgSrc String: the HTML for the image thumbnail
	 * @param imgName String: the MediaWiki image name
	 * @param imgDesc String: the MediaWiki image description [unused]
	 */
	uploadComplete: function( imgSrc, imgName, imgDesc ) {
		document.getElementById( 'loadingImg' ).style.display = 'none';
		document.getElementById( 'loadingImg' ).style.visibility = 'hidden';

		if( PictureGame.currImg == 1 ) {
			document.getElementById( 'image-one-tag' ).innerHTML = imgSrc;
		} else {
			document.getElementById( 'image-two-tag' ).innerHTML = imgSrc;
		}
	},

	/**
	 * Flags an image set
	 *
	 * @param msg String
	 */
	flagImg: function( msg ) {
		var ask = confirm( msg );
		if( ask ) {
			jQuery.get(
				wgScript,//mw.config.get( 'wgScript' ),
				{
					title: 'Special:PictureGameHome',
					picGameAction: 'flagImage',
					key: document.getElementById( 'key' ).value,
					id: document.getElementById( 'id' ).value
				},
				function( data ) {
					document.getElementById( 'serverMessages' ).innerHTML =
						'<strong>' + data + '</strong>';
				}
			);
		}
	},

	doHover: function( divID ) {
		if( divID == 'imageOne' ) {
			document.getElementById( divID ).style.backgroundColor = '#4B9AF6';
		} else {
			document.getElementById( divID ).style.backgroundColor = '#FF1800';
		}
	},

	endHover: function( divID ) {
		document.getElementById( divID ).style.backgroundColor = '';
	},

	editPanel: function() {
		document.location = '?title=Special:PictureGameHome&picGameAction=editPanel&id=' +
			document.getElementById( 'id' ).value;
	},

	protectImages: function( msg ) {
		var ask = confirm( msg );
		if( ask ) {
			jQuery.get(
				wgScript,//mw.config.get( 'wgScript' ),
				{
					title: 'Special:PictureGameHome',
					picGameAction: 'protectImages',
					key: document.getElementById( 'key' ).value,
					id: document.getElementById( 'id' ).value
				},
				function( data ) {
					document.getElementById( 'serverMessages' ).innerHTML =
						'<strong>' + data + '</strong>';
				}
			);
		}
	},

	castVote: function( picID ) {
		if( document.getElementById( 'lightboxText' ) !== null ) {
			// pop up the lightbox
			var objLink = {};
			//objLink.href = '../../images/common/ajax-loader.gif';
			objLink.href = '#';
			objLink.title = '';

			LightBox.show( objLink );

			LightBox.setText(
				'<embed src="' + wgScriptPath + '/extensions/PictureGame/picturegame/ajax-loading.swf" quality="high" wmode="transparent" bgcolor="#ffffff"' +
				'pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"' +
				'type="application/x-shockwave-flash" width="100" height="100">' +
				'</embed>'
			);

			document.picGameVote.lastid.value = document.getElementById( 'id' ).value;
			document.picGameVote.img.value = picID;
			jQuery.post(
				wgScript,//mw.config.get( 'wgScript' ),
				{
					title: 'Special:PictureGameHome',
					picGameAction: 'castVote',
					key: document.getElementById( 'key' ).value,
					id: document.getElementById( 'id' ).value,
					img: picID,
					nextid: document.getElementById( 'nextid' ).value
				},
				function( data ) {
					window.location =
						'?title=Special:PictureGameHome&picGameAction=startGame&lastid=' +
						document.getElementById( 'id' ).value + '&id=' +
						document.getElementById( 'nextid' ).value;
				}
			);
		}
	},

	reupload: function( id ) {
		var isReload = true;

		if( id == 1 ) {
			document.getElementById( 'imageOne' ).style.display = 'none';
			document.getElementById( 'imageOne' ).style.visibility = 'hidden';
			document.getElementById( 'imageOneLoadingImg' ).style.display = 'block';
			document.getElementById( 'imageOneLoadingImg' ).style.visibility = 'visible';

			document.getElementById( 'imageOneUpload-frame' ).onload = function handleResponse( st, doc ) {
				document.getElementById( 'imageOneLoadingImg' ).style.display = 'none';
				document.getElementById( 'imageOneLoadingImg' ).style.visibility = 'hidden';
				document.getElementById( 'imageOneUpload-frame' ).style.display = 'block';
				document.getElementById( 'imageOneUpload-frame' ).style.visibility = 'visible';
				this.onload = function( st, doc ) { return; };
			};

			// passes in the description of the image
			document.getElementById( 'imageOneUpload-frame' ).src =
				document.getElementById( 'imageOneUpload-frame' ).src +
				'&wpUploadDescription=' + document.getElementById( 'picOneDesc' ).value;
		} else {
			document.getElementById( 'imageTwo' ).style.display = 'none';
			document.getElementById( 'imageTwo' ).style.visibility = 'hidden';
			document.getElementById( 'imageTwoLoadingImg' ).style.display = 'block';
			document.getElementById( 'imageTwoLoadingImg' ).style.visibility = 'visible';

			document.getElementById( 'imageTwoUpload-frame' ).onload = function handleResponse( st, doc ) {
				document.getElementById( 'imageTwoLoadingImg' ).style.display = 'none';
				document.getElementById( 'imageTwoLoadingImg' ).style.visibility = 'hidden';
				document.getElementById( 'imageTwoUpload-frame' ).style.display = 'block';
				document.getElementById( 'imageTwoUpload-frame' ).style.visibility = 'visible';
				this.onload = function( st, doc ) { return; };
			};
			// passes in the description of the image
			document.getElementById( 'imageTwoUpload-frame' ).src =
				document.getElementById( 'imageTwoUpload-frame' ).src +
				'&wpUploadDescription=' +
				document.getElementById( 'picTwoDesc' ).value;
		}
	},

	/**
	 * Eh, there should be a smarter way of doing this instead of epic code
	 * duplication, really...
	 */
	imageOne_uploadError: function( message ) {
		document.getElementById( 'imageOneLoadingImg' ).style.display = 'none';
		document.getElementById( 'imageOneLoadingImg' ).style.visibility = 'hidden';

		document.getElementById( 'imageOneUploadError' ).innerHTML = '<h1>' + message + '</h1>';
		document.getElementById( 'imageOneUpload-frame' ).src =
			document.getElementById( 'imageOneUpload-frame' ).src;

		document.getElementById( 'imageOneUpload-frame' ).style.display = 'block';
		document.getElementById( 'imageOneUpload-frame' ).style.visibility = 'visible';
	},

	imageTwo_uploadError: function( message ) {
		document.getElementById( 'imageTwoLoadingImg' ).style.display = 'none';
		document.getElementById( 'imageTwoLoadingImg' ).style.visibility = 'hidden';

		document.getElementById( 'imageTwoUploadError' ).innerHTML = '<h1>' + message + '</h1>';
		document.getElementById( 'imageTwoUpload-frame' ).src =
			document.getElementById( 'imageTwoUpload-frame' ).src;
		document.getElementById( 'imageTwoUpload-frame' ).style.display = 'block';
		document.getElementById( 'imageTwoUpload-frame' ).style.visibility = 'visible';
	},

	imageOne_completeImageUpload: function() {
		document.getElementById( 'imageOneUpload-frame' ).style.display = 'none';
		document.getElementById( 'imageOneUpload-frame' ).style.visibility = 'hidden';
		document.getElementById( 'imageOneLoadingImg' ).style.display = 'block';
		document.getElementById( 'imageOneLoadingImg' ).style.visibility = 'visible';
	},

	imageTwo_completeImageUpload: function() {
		document.getElementById( 'imageTwoUpload-frame' ).style.display = 'none';
		document.getElementById( 'imageTwoUpload-frame' ).style.visibility = 'hidden';
		document.getElementById( 'imageTwoLoadingImg' ).style.display = 'block';
		document.getElementById( 'imageTwoLoadingImg' ).style.visibility = 'visible';
	},

	imageOne_uploadComplete: function( imgSrc, imgName, imgDesc ) {
		document.getElementById( 'imageOneLoadingImg' ).style.display = 'none';
		document.getElementById( 'imageOneLoadingImg' ).style.visibility = 'hidden';
		document.getElementById( 'imageOneUpload-frame' ).style.display = 'none';
		document.getElementById( 'imageOneUpload-frame' ).style.visibility = 'hidden';

		document.getElementById( 'imageOne' ).innerHTML =
			'<p><b>' + imgDesc + '</b></p>' + imgSrc +
			'<p><a href="javascript:PictureGame.reupload(1)">' +
			window.parent.__picturegame_edit__ + '</a></p>';

		document.picGamePlay.picOneURL.value = imgName;
		//document.picGamePlay.picOneDesc.value = imgDesc;

		// as per http://www.mediawiki.org/wiki/Special:Code/MediaWiki/68271
		var imgOne = jQuery( '#imageOne' );
		imgOne.fadeIn( 2000 );

		if(
			document.picGamePlay.picTwoURL.value !== '' &&
			document.picGamePlay.picOneURL.value !== ''
		)
		{
			// as per http://www.mediawiki.org/wiki/Special:Code/MediaWiki/68271
			var button = jQuery( '#startButton' );
			button.fadeIn( 2000 );
		}
	},

	imageTwo_uploadComplete: function( imgSrc, imgName, imgDesc ) {
		document.getElementById( 'imageTwoLoadingImg' ).style.display = 'none';
		document.getElementById( 'imageTwoLoadingImg' ).style.visibility = 'hidden';
		document.getElementById( 'imageTwoUpload-frame' ).style.display = 'none';
		document.getElementById( 'imageTwoUpload-frame' ).style.visibility = 'hidden';

		document.getElementById( 'imageTwo' ).innerHTML =
			'<p><b>' + imgDesc + '</b></p>' + imgSrc +
			'<p><a href="javascript:PictureGame.reupload(2)">' +
			window.parent.__picturegame_edit__ + '</a></p>';

		document.picGamePlay.picTwoURL.value = imgName;
		//document.picGamePlay.picTwoDesc.value = imgDesc;

		// as per http://www.mediawiki.org/wiki/Special:Code/MediaWiki/68271
		var imgTwo = jQuery( '#imageTwo' );
		imgTwo.fadeIn( 2000 );

		if( document.picGamePlay.picOneURL.value !== '' ) {
			// as per http://www.mediawiki.org/wiki/Special:Code/MediaWiki/68271
			var button = jQuery( '#startButton' );
			button.fadeIn( 2000 );
		}
	},

	startGame: function() {
		var isError = false;
		var gameTitle = document.getElementById( 'picGameTitle' ).value;
		var imgOneURL = document.getElementById( 'picOneURL' ).value;
		var imgTwoURL = document.getElementById( 'picTwoURL' ).value;
		var errorText = '';

		if( gameTitle.length === 0 ) {
			isError = true;
			document.getElementById( 'picGameTitle' ).style.borderStyle = 'solid';
			document.getElementById( 'picGameTitle' ).style.borderColor = 'red';
			document.getElementById( 'picGameTitle' ).style.borderWidth = '2px';
			errorText = errorText + __picturegame_error_title__ + '<br />';
		}

		if( imgOneURL.length === 0 ) {
			isError = true;
			document.getElementById( 'imageOneUpload' ).style.borderStyle = 'solid';
			document.getElementById( 'imageOneUpload' ).style.borderColor = 'red';
			document.getElementById( 'imageOneUpload' ).style.borderWidth = '2px';
			errorText = errorText + __picturegame_upload_imgone__ + '<br />';
		}

		if( imgTwoURL.length === 0 ) {
			isError = true;
			document.getElementById( 'imageTwoUpload' ).style.borderStyle = 'solid';
			document.getElementById( 'imageTwoUpload' ).style.borderColor = 'red';
			document.getElementById( 'imageTwoUpload' ).style.borderWidth = '2px';
			errorText = errorText + __picturegame_upload_imgtwo__ + '<br />';
		}

		if( !isError ) {
			document.picGamePlay.submit();
		} else {
			document.getElementById( 'picgame-errors' ).innerHTML = errorText;
		}
	},

	skipToGame: function() {
		document.location = 'index.php?title=Special:PictureGameHome&picGameAction=startGame';
	}
};