/**
 * JavaScript for the CreateAPage extension (its Special:CreatePage page).
 *
 * Classes:
 * CreateAPage
 * -main class
 * CreateAPageInfobox
 * -class for uploading images from infoboxes (I think)
 * CreateAPageCategoryTagCloud
 * -class for managing the category tag cloud
 * CreateAPageListeners
 * -a small class used to handle clicking of the "hide/show" link on
 * Special:CreatePage which hides or shows the list of available createplates
 *
 * Rewritten by Jack Phoenix <jack@countervandalism.net> from YUI to jQuery and
 * to be object-oriented in late September/early October 2011.
 *
 * @file
 */

/**
 * @file
 */
var CreateAPageListeners = {
	/**
	 * @param e Event
	 * @param data Array: [ div, link ]
	 */
	toggle: function( e, data ) {
		e.preventDefault();
		var display = '', text = '', opacity;

		if ( jQuery( '#' + data[0] ).css( 'display' ) !== 'none' ) {
			display = 'none';
			text = mw.msg( 'createpage-show' );
			opacity = 0;

			jQuery( '#' + data[0] ).fadeIn( 5000, function() {
				jQuery( '#' + data[0] ).css( 'display', display );
				jQuery( '#' + data[1] ).text( text );
			});
		} else {
			display = 'block';
			text = mw.msg( 'createpage-hide' );
			opacity = 1;

			jQuery( '#' + data[0] ).css( 'opacity', opacity );
			jQuery( '#' + data[0] ).css( 'display', display );

			jQuery( '#' + data[1] ).text( text );
		}
	}
};

/**
 * A class for managing the category tag cloud.
 */
var CreateAPageCategoryTagCloud = {
	add: function( category, num ) { // previously cloudAdd
		var category_text = document.getElementById( 'wpCategoryTextarea' );

		if ( category_text.value === '' ) {
			category_text.value += decodeURIComponent( category );
		} else {
			category_text.value += '|' + decodeURIComponent( category );
		}

		var this_button = document.getElementById( 'cloud' + num );
		this_button.onclick = function() {
			this.remove( category, num );
			return false;
		};
		this_button.style.color = '#419636';
		return false;
	},

	build: function( o ) { // previously cloudBuild
		var categories = o.value;
		var new_text = '';

		categories = categories.split( '|' );
		for ( var i = 0; i < categories.length; i++ ) {
			if ( categories[i] !== '' ) {
				new_text += '[[' + wgFormattedNamespaces[14] + ':' +
					categories[i] + ']]';
			}
		}

		return new_text;
	},

	inputAdd: function() { // previously cloudInputAdd
		var category_input = document.getElementById( 'wpCategoryInput' );
		var category_text = document.getElementById( 'wpCategoryTextarea' );
		var category = category_input.value;
		if ( category_input.value !== '' ) {
			if ( category_text.value === '' ) {
				category_text.value += decodeURIComponent( category );
			} else {
				category_text.value += '|' + decodeURIComponent( category );
			}
			category_input.value = '';
			var c_found = false;
			var core_cat = category.replace( /\|.*/, '' );
			for ( var j in CreateAPage.foundCategories ) {
				if ( CreateAPage.foundCategories[j] === core_cat ) {
					var this_button = document.getElementById( 'cloud' + j );
					var actual_cloud = CreateAPage.foundCategories[j];
					var cl_num = j;

					this_button.onclick = CreateAPage.onclickCategoryFn( core_cat, j );
					this_button.style.color = '#419636';
					c_found = true;
					break;
				}
			}
			if ( !c_found ) {
				var n_cat = document.createElement( 'a' );
				var s_cat = document.createElement( 'span' );
				var n_cat_count = CreateAPage.foundCategories.length;

				var cat_full_section = document.getElementById( 'createpage_cloud_section' );
				var cat_num = n_cat_count;
				n_cat.setAttribute( 'id', 'cloud' + cat_num );
				n_cat.setAttribute( 'href', '#' );
				n_cat.onclick = CreateAPage.onclickCategoryFn( core_cat, cat_num );
				n_cat.style.color = '#419636';
				n_cat.style.fontSize = '10pt';
				s_cat.setAttribute( 'id', 'tag' + cat_num );
				var t_cat = document.createTextNode( core_cat );
				var space = document.createTextNode( ' ' );
				n_cat.appendChild( t_cat );
				s_cat.appendChild( n_cat );
				s_cat.appendChild( space );
				cat_full_section.appendChild( s_cat );
				CreateAPage.foundCategories[n_cat_count] = core_cat;
			}
		}
	},

	remove: function( category, num ) { // previously cloudRemove
		var category_text = document.getElementById( 'wpCategoryTextarea' );
		var this_pos = category_text.value.indexOf( decodeURIComponent( category ) );
		if ( this_pos !== -1 ) {
			category_text.value = category_text.value.substr( 0, this_pos - 1 ) +
				category_text.value.substr( this_pos + decodeURIComponent( category ).length );
		}
		var this_button = document.getElementById( 'cloud' + num );
		this_button.onclick = function() {
			this.add( category, num );
			return false;
		};
		this_button.style.color = '';
		return false;
	}
};

var CreateAPage = {
	noCanDo: false,
	submitEnabled: false,

	disabledCr: false,

	toolbarButtons: [],

	multiEditTextboxes: [],
	multiEditButtons: [],
	multiEditCustomButtons: [],

	foundCategories: [],

	myId: 0,
	//previewMode: '<?php echo !$ispreview ? 'No' : 'Yes' ?>';
	//redLinkMode: '<?php echo !$isredlink ? 'No' : 'Yes' ?>';

	/**
	 * Copy of CreatePageNormalEdit from extensions/wikiwyg/share/MediaWiki/extensions/CreatePage/js/createpage.js
	 * with a few tweaks (the textarea stuff + i18n).
	 * Asks the user for a confirmation if they want to discard all changes
	 * done via Special:CreatePage and if the answer is yes, takes them to
	 * ?action=edit (normal edit mode).
	 */
	goToNormalEditMode: function() {
		var title = document.getElementById( 'title' );
		var errorMsg = document.getElementById( 'createpage_messenger' );

		if ( title.value === '' ) {
			errorMsg.innerHTML = mw.msg( 'createpage-must-specify-title' );
			errorMsg.style.display = '';
			return;
		}

		/* check for unsaved changes (they will always be *unsaved* here... ) */
		// @todo CHECKME
		var textarea;
		var edit_textareas = CreateAPage.getElementsBy(
			CreateAPage.editTextareaTest,
			'textarea',
			document.getElementById( 'wpTableMultiEdit' ),
			CreateAPage.textareaAddToolbar
		);

		if ( edit_textareas[0].id === 'wpTextboxes0' ) {
			textarea = edit_textareas[0];
			textarea = textarea.replace( '<br>', '' );
		}

		if ( textarea !== '' ) {
			var abandonChanges = confirm(
				mw.msg( 'createpage-unsaved-changes-details' ),
				mw.msg( 'createpage-unsaved-changes' )
			);

			if ( !abandonChanges ) {
				return;
			}
		}

		var fixedArticlePath = wgArticlePath.replace( '$1', '' );
		fixedArticlePath = fixedArticlePath.replace( 'index.php[^\/]', 'index.php?title=' );

		window.location = fixedArticlePath + title.value + '?action=edit';
	},

	callbackTitle: function( data ) {
		var res = '', helperButton;
		document.getElementById( 'cp-title-check' ).innerHTML = '';
		if( /^("(\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/.test( data ) ) {
			res = eval( '(' + data + ')' );
		}
		if ( ( res['text'] !== false ) && ( res['empty'] !== true ) ) {
			var url = res['url'].replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );
			var text = res['text'].replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' );

			document.getElementById( 'cp-title-check' ).innerHTML = '<span style="color: red;">' +
				mw.msg( 'createpage-article-exists' ) + ' <a href="' +
				url + '?action=edit" title="' + text + '">' + text +
				'</a>' + mw.msg( 'createpage-article-exists2' ) + '</span>';
			if ( CreateAPage.Overlay ) {
				CreateAPage.Overlay.show(); // @todo FIXME
				helperButton = document.getElementById( 'wpRunInitialCheck' );
				helperButton.style.display = '';
			} else {
				CreateAPage.contentOverlay();
			}
		} else if ( res['empty'] === true ) {
			document.getElementById( 'cp-title-check' ).innerHTML =
				'<span style="color: red;">' +
				mw.msg( 'createpage-title-invalid' ) +
				'</span>';
			if ( CreateAPage.Overlay ) {
				CreateAPage.resizeOverlay( 0 );
				CreateAPage.Overlay.show(); // @todo FIXME
				helperButton = document.getElementById( 'wpRunInitialCheck' );
				helperButton.style.display = '';
			} else {
				CreateAPage.contentOverlay();
			}
		} else {
			if ( CreateAPage.Overlay ) {
				CreateAPage.Overlay.hide(); // @todo FIXME
				helperButton = document.getElementById( 'wpRunInitialCheck' );
				helperButton.style.display = 'none';
			}
		}
		CreateAPage.noCanDo = false;
	},

	/**
	 * The name of this function is misleading and as such it should be renamed
	 * one day.
	 *
	 * In any case, this function gets called whenever the user inputs
	 * something on the "Article Title" input on Special:CreatePage and moves
	 * the cursor elsewhere on the page or presses the "Proceed to edit" button.
	 * This function then shows a progress bar image and checks whether there
	 * is or isn't a page with the given title.
	 *
	 * If there isn't a page with the given title, the overlay on the editor is
	 * removed.
	 * If such a page however exists, a red error message ("This article
	 * already exists. Edit <article name> or specify another title.") is shown
	 * to the user.
	 */
	watchTitle: function() {
		document.getElementById( 'cp-title-check' ).innerHTML =
			'<img src="' + wgServer + wgScriptPath +
			'/extensions/CreateAPage/images/progress_bar.gif" width="70" height="11" alt="' +
			mw.msg( 'createpage-please-wait' ) + '" border="0" />';
		CreateAPage.noCanDo = true;

		jQuery.ajax({ // using .ajax instead of .get for better flexibility
			url: wgScript,
			data: {
				action: 'ajax',
				rs: 'axTitleExists',
				title: document.getElementById( 'Createtitle' ).value
			},
			success: function( data, textStatus, jqXHR ) {
				CreateAPage.callbackTitle( data );
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				document.getElementById( 'cp-title-check' ).innerHTML = '';
			}
		});
	},

	clearInput: function( o ) {
		var cDone = false;
		jQuery( '#wpInfoboxPar' + o.num ).bind( 'focus', function() {
			var previewarea = jQuery( '#createpagepreview' );
			if ( !cDone && ( previewarea === null ) ) {
				cDone = true;
				document.getElementById( 'wpInfoboxPar' + o.num ).value = '';
			}
		});
	},

	goToEdit: function( e ) {
		e.preventDefault();
		jQuery.post(
			wgScript,//mw.config.get( 'wgScript' ),
			{
				action: 'ajax',
				rs: 'axCreatepageAdvancedSwitch'
			},
			function( data ) {
				window.location = wgServer + wgScript + '?title=' +
					encodeURIComponent( document.getElementById( 'Createtitle' ).value ) +
					'&action=edit&editmode=nomulti&createpage=true';
			}
		);
		CreateAPage.warningPanel.hide(); // @todo FIXME
	},

	goToLogin: function( e ) {
		e.preventDefault();
		if ( CreateAPage.redLinkMode ) {
			window.location = wgServer + wgScript +
				'?title=Special:UserLogin&returnto=' +
				encodeURIComponent( document.getElementById( 'Createtitle' ).value );
		} else {
			window.location = wgServer + wgScript +
				'?title=Special:UserLogin&returnto=Special:CreatePage';
		}
	},

	hideWarningPanel: function( e ) {
		if ( CreateAPage.warningPanel ) {
			CreateAPage.warningPanel.hide(); // @todo FIXME
		}
	},

	showWarningPanel: function( e ) {
		e.preventDefault();
		if ( document.getElementById( 'Createtitle' ).value !== '' ) {
			if ( !CreateAPage.warningPanel ) {
				CreateAPage.buildWarningPanel();
			}
			CreateAPage.warningPanel.show(); // @todo FIXME
			jQuery( '#wpCreatepageWarningYes' ).focus();
		} else {
			jQuery( '#cp-title-check' ).html(
				'<span style="color: red;">' +
				mw.msg( 'createpage-give-title' ) +
				'</span>'
			);
		}
	},

	hideWarningLoginPanel: function( e ) {
		if ( CreateAPage.warningLoginPanel ) {
			CreateAPage.warningLoginPanel.hide(); // @todo FIXME
		}
	},

	showWarningLoginPanel: function( e ) {
		e.preventDefault();
		if ( document.getElementById( 'Createtitle' ).value !== '' ) {
			if ( !CreateAPage.warningLoginPanel ) {
				CreateAPage.buildWarningLoginPanel( e );
			}
			CreateAPage.warningLoginPanel.show();
			jQuery( '#wpCreatepageWarningYes' ).focus();
		} else {
			jQuery( '#cp-title-check' ).html(
				'<span style="color: red;">' +
				mw.msg( 'createpage-give-title' ) +
				'</span>'
			);
		}
	},

	uploadCallback: function( oResponse ) {
		var aResponse = []; // initialize it as an empty array so that JSHint can STFU
		if( /^("(\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/.test( oResponse.responseText ) ) {
			aResponse = eval( '(' + oResponse.responseText + ')' );
		}
		var ProgressBar = document.getElementById( 'createpage_upload_progress_section' + aResponse['num'] );

		if ( aResponse['error'] !== 1 ) {
			ProgressBar.innerHTML = mw.msg( 'createpage-img-uploaded' );
			var target_info = document.getElementById( 'wpAllUploadTarget' + aResponse['num'] ).value;
			var target_tag = jQuery( target_info );
			target_tag.value = '[[' + aResponse['msg'] + '|thumb]]';

			var ImageThumbnail = document.getElementById( 'createpage_image_thumb_section' + aResponse['num'] );
			var thumb_container = document.getElementById( 'createpage_main_thumb_section' + aResponse['num'] );
			var tempstamp = new Date();
			ImageThumbnail.src = aResponse['url'] + '?' + tempstamp.getTime();
			if ( document.getElementById( 'wpAllLastTimestamp' + aResponse['num'] ).value === 'None' ) {
				var break_tag = document.createElement( 'br' );
				thumb_container.style.display = '';
				var label_node = document.getElementById( 'createpage_image_label_section' + aResponse['num'] );
				var par_node = label_node.parentNode;
				par_node.insertBefore( break_tag, label_node );
			}
			document.getElementById( 'wpAllLastTimestamp' + oResponse.argument ).value = aResponse['timestamp'];
		} else if ( ( aResponse['error'] === 1 ) && ( aResponse['msg'] === 'cp_no_login' ) ) {
			// @todo FIXME: oh my fucking god this is UGLY
			ProgressBar.innerHTML = '<span style="color: red">' +
				mw.msg( 'createpage-login-required' ) +
				'<a href="' + wgServer + wgScript +'?title=Special:Userlogin&returnto=Special:Createpage" id="createpage_login' +
				oResponse.argument + '">' +
					mw.msg( 'createpage-login-href' ) + '</a>' +
					mw.msg( 'createpage-login-required2' ) +
				'</span>';
			jQuery( '#createpage_login' + oResponse.argument ).click( function( e ) {
				CreateAPage.showWarningLoginPanel( e );
			});
		} else {
			ProgressBar.innerHTML = '<span style="color: red">' + aResponse['msg'] + '</span>';
		}

		document.getElementById( 'createpage_image_text_section' + oResponse.argument ).innerHTML = mw.msg( 'createpage-insert-image' );
		document.getElementById( 'createpage_upload_file_section' + oResponse.argument ).style.display = '';
		document.getElementById( 'createpage_image_text_section' + oResponse.argument ).style.display = '';
		document.getElementById( 'createpage_image_cancel_section' + oResponse.argument ).style.display = 'none';
	},

	failureCallback: function( response ) {
		document.getElementById( 'createpage_image_text_section' + response.argument ).innerHTML = mw.msg( 'createpage-insert-image' );
		document.getElementById( 'createpage_upload_progress_section' + response.argument ).innerHTML = mw.msg( 'createpage-upload-aborted' );
		document.getElementById( 'createpage_upload_file_section' + response.argument ).style.display = '';
		document.getElementById( 'createpage_image_text_section' + response.argument ).style.display = '';
		document.getElementById( 'createpage_image_cancel_section' + response.argument ).style.display = 'none';
	},

	restoreSection: function( section, text ) {
		var sectionContent = CreateAPage.getElementsBy(
			CreateAPage.optionalContentTest, '', section
		);
		for( var i = 0; i < sectionContent.length; i++ ) {
			text = text.replace( sectionContent[i].id, '' );
		}
		section.style.display = 'block';
		return text;
	},

	unuseSection: function( section, text ) {
		var sectionContent = CreateAPage.getElementsBy(
			CreateAPage.optionalContentTest, '', section
		);
		var first = true;
		var ivalue = '';

		for( var i = 0; i < sectionContent.length; i++ ) {
			if ( first ) {
				if ( text !== '' ) {
					ivalue += ',';
				}
				first = false;
			} else {
				ivalue += ',';
			}
			ivalue += sectionContent[i].id;
		}

		section.style.display = 'none';

		return text + ivalue;
	},

	toggleSection: function( e, o ) {
		var section = document.getElementById( 'createpage_section_' + o.num );
		var input = document.getElementById( 'wpOptionalInput' + o.num );
		var optionals = document.getElementById( 'wpOptionals' );
		var ivalue = '';
		if ( input.checked ) {
			optionals.value = CreateAPage.restoreSection( section, optionals.value );
		} else {
			optionals.value = CreateAPage.unuseSection( section, optionals.value );
		}
	},

	upload: function( e, o ) {
		var oForm = document.getElementById( 'createpageform' );
		e.preventDefault();

		var ProgressBar = document.getElementById( 'createpage_upload_progress_section' + o.num );
		ProgressBar.style.display = 'block';
		ProgressBar.innerHTML = '<img src="' + stylepath +
			'/common/images/spinner.gif" width="16" height="16" alt="' +
			mw.msg( 'createpage-please-wait' ) + '" border="0" />&nbsp;';

		var sent_request = jQuery.ajax({ // using .ajax instead of .post for better flexibility
			type: 'POST',
			url: wgScript,
			data: {
				action: 'ajax',
				rs: 'axMultiEditImageUpload',
				infix: 'All',
				num: o.num
			},
			success: function( data, textStatus, jqXHR ) {
				// @todo FIXME/CHECKME: make sure that the num (o.num) is passed as response.argument to uploadCallback
				CreateAPageInfobox.uploadCallback( jqXHR );
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				CreateAPageInfobox.failureCallback( jqXHR );
			},
			timeout: 240000
		});
		document.getElementById( 'createpage_image_cancel_section' + o.num ).style.display = '';
		document.getElementById( 'createpage_image_text_section' + o.num ).style.display = 'none';

		jQuery( '#createpage_image_cancel_section' + o.num ).click( function( e ) {
			sent_request.abort();
		});

		var neoInput = document.createElement( 'input' );
		var thisInput = document.getElementById( 'createpage_upload_file_section' + o.num );
		var thisContainer = document.getElementById( 'createpage_image_label_section' + o.num );
		thisContainer.removeChild( thisInput );

		neoInput.setAttribute( 'type', 'file' );
		neoInput.setAttribute( 'id', 'createpage_upload_file_section' + o.num );
		neoInput.setAttribute( 'name', 'wpAllUploadFile' + o.num );
		neoInput.setAttribute( 'tabindex', '-1' );

		thisContainer.appendChild( neoInput );
		jQuery( '#createpage_upload_file_section' + o.num ).change( function( e ) {
			CreateAPage.upload( e, { 'num': o.num } );
		});

		document.getElementById( 'createpage_upload_file_section' + o.num ).style.display = 'none';
	},

	buildWarningPanel: function( e ) {
		var editwarn = document.getElementById( 'createpage_advanced_warning' );
		var editwarn_copy = document.createElement( 'div' );
		editwarn_copy.id = 'createpage_warning_copy';
		editwarn_copy.innerHTML = editwarn.innerHTML;
		document.body.appendChild( editwarn_copy );

		CreateAPage.warningPanel = jQuery( '#createpage_warning_copy' ).dialog({
			draggable: false,
			modal: true,
			resizable: false,
			width: 250
		});
		/*
		CreateAPage.warningPanel = new YAHOO.widget.Panel( 'createpage_warning_copy', {
			width: '250px',
			modal: true,
			constraintoviewport: true,
			draggable: false,
			fixedcenter: true,
			underlay: 'none'
		} );
		CreateAPage.warningPanel.cfg.setProperty( 'zIndex', 1000 );
		CreateAPage.warningPanel.render( document.body );
		*/

		jQuery( '#wpCreatepageWarningYes' ).click( function( e ) {
			CreateAPage.goToEdit( e );
		});
		jQuery( '#wpCreatepageWarningNo' ).click( function( e ) {
			CreateAPage.hideWarningPanel( e );
		});
	},

	buildWarningLoginPanel: function( e ) {
		var editwarn = document.getElementById( 'createpage_advanced_warning' );
		var editwarn_copy = document.createElement( 'div' );
		editwarn_copy.id = 'createpage_warning_copy2';
		editwarn_copy.innerHTML = editwarn.innerHTML;
		editwarn_copy.childNodes[1].innerHTML = mw.msg( 'login' );
		editwarn_copy.childNodes[3].innerHTML = mw.msg( 'createpage-login-warning' );
		document.body.appendChild( editwarn_copy );

		CreateAPage.warningLoginPanel = jQuery( '#createpage_warning_copy2' ).dialog({
			draggable: false,
			modal: true,
			resizable: false,
			width: 250
		});
		/*
		CreateAPage.warningLoginPanel = new YAHOO.widget.Panel( 'createpage_warning_copy2', {
			width: '250px',
			modal: true,
			constraintoviewport: true,
			draggable: false,
			fixedcenter: true,
			underlay: 'none'
		} );
		CreateAPage.warningLoginPanel.cfg.setProperty( 'zIndex', 1000 );
		CreateAPage.warningLoginPanel.render( document.body );
		*/

		jQuery( '#wpCreatepageWarningYes' ).click( function( e ) {
			CreateAPage.goToLogin( e );
		});
		jQuery( '#wpCreatepageWarningNo' ).click( function( e ) {
			CreateAPage.hideWarningLoginPanel( e );
		});
	},

	onclickCategoryFn: function( cat, id ) {
		return function() {
			CreateAPageCategoryTagCloud.remove( encodeURIComponent( cat ), id );
			return false;
		};
	},

	/**
	 * Remove any and all "This article already exists" messages.
	 *
	 * @param e Event
	 */
	clearTitleMessage: function( e ) {
		e.preventDefault();
		document.getElementById( 'cp-title-check' ).innerHTML = '';
	},

	/**
	 * Test whether the given element's ID matches createpage_upload_file_section
	 * or not.
	 *
	 * @param el Element HTML element to test
	 * @return Boolean: true if the element's ID matches, else false
	 */
	uploadTest: function( el ) {
		if ( el.id.match( 'createpage_upload_file_section' ) ) {
			return true;
		} else {
			return false;
		}
	},

	/**
	 * Test whether the given element's ID matches wpTextboxes and that it's
	 * visible (i.e. display != none).
	 *
	 * @param el Element HTML element to test
	 * @return Boolean: true if the element's ID matches, else false
	 */
	editTextareaTest: function( el ) {
		if ( el.id.match( 'wpTextboxes' ) && ( el.style.display !== 'none' ) ) {
			return true;
		} else {
			return false;
		}
	},

	/**
	 * Test whether the given element's ID matches wpOptionalInput and that
	 * it's visible (i.e. display != none).
	 *
	 * @param el Element HTML element to test
	 * @return Boolean: true if the element's ID matches, else false
	 */
	optionalSectionTest: function( el ) {
		if ( el.id.match( 'wpOptionalInput' ) && ( el.style.display !== 'none' ) ) {
			return true;
		} else {
			return false;
		}
	},

	/**
	 * Test whether the given element's ID matches wpTextboxes.
	 *
	 * @param el Element HTML element to test
	 * @return Boolean: true if the element's ID matches, else false
	 */
	optionalContentTest: function( el ) {
		if ( el.id.match( 'wpTextboxes' ) ) {
			return true;
		} else {
			return false;
		}
	},

	uploadEvent: function( el ) {
		var j = parseInt( el.id.replace( 'createpage_upload_file_section', '' ) );
		jQuery( '#createpage_upload_file_section' + j ).change( function( e ) {
			CreateAPage.upload( e, { num : j } );
		});
	},

	textareaAddToolbar: function( el ) {
		var el_id = parseInt( el.id.replace( 'wpTextboxes', '' ) );
		CreateAPage.multiEditTextboxes[CreateAPage.multiEditTextboxes.length] = el_id;
		CreateAPage.multiEditButtons[el_id] = [];
		CreateAPage.multiEditCustomButtons[el_id] = [];

		jQuery( '#' + el.id ).focus( function( e ) {
			CreateAPage.showThisBox( e, { 'toolbarId': el_id } );
		});

		jQuery( '#wpTextIncrease' + el_id ).click( function( e ) {
			CreateAPage.resizeThisTextarea( e, { 'textareaId': el_id, 'numRows': 1 } );
		});
		jQuery( '#wpTextDecrease' + el_id ).click( function( e ) {
			CreateAPage.resizeThisTextarea( e, { 'textareaId': el_id, 'numRows': -1 } );
		});

		for ( var i = 0; i < CreateAPage.toolbarButtons.length; i++ ) {
			CreateAPage.addMultiEditButton(
				CreateAPage.toolbarButtons[i]['image'],
				CreateAPage.toolbarButtons[i]['tip'],
				CreateAPage.toolbarButtons[i]['open'],
				CreateAPage.toolbarButtons[i]['close'],
				CreateAPage.toolbarButtons[i]['sample'],
				CreateAPage.toolbarButtons[i]['id'] + el_id,
				el_id
			);
		}
	},

	checkCategoryCloud: function() {
		var cat_textarea = document.getElementById( 'wpCategoryTextarea' );
		if ( !cat_textarea ) {
			return;
		}

		var cat_full_section = document.getElementById( 'createpage_cloud_section' );

		var cloud_num = ( cat_full_section.childNodes.length - 1 ) / 2;
		var n_cat_count = cloud_num;
		var text_categories = [];
		for ( var i = 0; i < cloud_num; i++ ) {
			var cloud_id = 'cloud' + i;
			var found_category = document.getElementById( cloud_id ).innerHTML;
			if ( found_category ) {
				CreateAPage.foundCategories[i] = found_category;
			}
		}

		var categories = cat_textarea.value;
		if ( categories === '' ) {
			return;
		}

		categories = categories.split( '|' );
		for ( i = 0; i < categories.length; i++ ) {
			text_categories[i] = categories[i];
		}

		for ( i = 0; i < text_categories.length; i++ ) {
			var c_found = false;
			var core_cat;
			for ( var j in CreateAPage.foundCategories ) {
				core_cat = text_categories[i].replace( /\|.*/, '' );
				if ( CreateAPage.foundCategories[j] === core_cat ) {
					var this_button = document.getElementById( 'cloud' + j );
					var actual_cloud = CreateAPage.foundCategories[j];
					var cl_num = j;

					this_button.onclick = CreateAPage.onclickCategoryFn( text_categories[i], j );
					this_button.style.color = '#419636';
					c_found = true;
					break;
				}
			}

			if ( !c_found ) {
				var n_cat = document.createElement( 'a' );
				var s_cat = document.createElement( 'span' );
				n_cat_count++;
				var cat_num = n_cat_count - 1;
				n_cat.setAttribute( 'id', 'cloud' + cat_num );
				n_cat.setAttribute( 'href', '#' );
				n_cat.onclick = CreateAPage.onclickCategoryFn( text_categories[i], cat_num );
				n_cat.style.color = '#419636';
				n_cat.style.fontSize = '10pt';
				s_cat.setAttribute( 'id', 'tag' + n_cat_count );
				var t_cat = document.createTextNode( core_cat );
				var space = document.createTextNode( ' ' );
				n_cat.appendChild( t_cat );
				s_cat.appendChild( n_cat );
				s_cat.appendChild( space );
				cat_full_section.appendChild( s_cat );
			}
		}
	},

	addMultiEditButton: function( imageFile, speedTip, tagOpen, tagClose, sampleText, imageId, toolbarId ) {
		CreateAPage.multiEditButtons[toolbarId][CreateAPage.multiEditButtons[toolbarId].length] = {
			'imageId': imageId,
			'toolbarId': toolbarId,
			'imageFile': imageFile,
			'speedTip': speedTip,
			'tagOpen': tagOpen,
			'tagClose': tagClose,
			'sampleText': sampleText
		};
	},

	showThisBox: function( e, o ) {
		e.preventDefault();
		document.getElementById( 'toolbar' + o.toolbarId ).style.display = '';
		CreateAPage.hideOtherBoxes( o.toolbarId );
	},

	resizeThisTextarea: function( e, o ) {
		e.preventDefault();
		var r_textarea = jQuery( '#wpTextboxes' + o.textareaId );

		if (
			!( ( r_textarea.rows < 4 ) && ( o.numRows < 0 ) ) &&
			!( ( r_textarea.rows > 10 ) && ( o.numRows > 0 ) )
		)
		{
			r_textarea.rows = r_textarea.rows + o.numRows;
		}
	},

	hideOtherBoxes: function( boxId ) {
		for ( var i = 0; i < CreateAPage.multiEditTextboxes.length; i++ ) {
			if ( CreateAPage.multiEditTextboxes[i] !== boxId ) {
				document.getElementById( 'toolbar' + CreateAPage.multiEditTextboxes[i] ).style.display = 'none';
			}
		}
	},

	multiEditSetupToolbar: function() {
		for ( var j = 0; j < CreateAPage.multiEditButtons.length; j++ ) {
			var toolbar = document.getElementById( 'toolbar' + j );
			if ( toolbar ) {
				var textbox = document.getElementById( 'wpTextboxes' + j );
				if ( !textbox ) {
					return false;
				}
				if (
					!( document.selection && document.selection.createRange ) &&
					textbox.selectionStart === null
				)
				{
					return false;
				}

				for ( var i = 0; i < CreateAPage.multiEditButtons[j].length; i++ ) {
					CreateAPage.insertMultiEditButton( toolbar, CreateAPage.multiEditButtons[j][i] );
				}
			}
		}
		return true;
	},

	multiEditSetupOptionalSections: function() {
		var snum = 0;
		if ( document.getElementById( 'createpage_optionals_content' ) ) {
			var optionals = CreateAPage.getElementsBy(
				CreateAPage.optionalSectionTest,
				'input',
				document.getElementById( 'createpage_optionals_content' )
			);
			var optionalsElements = document.getElementById( 'wpOptionals' );
			for ( var i = 0; i < optionals.length; i++ ) {
				snum = optionals[i].id.replace( 'wpOptionalInput', '' );
				if ( !document.getElementById( 'wpOptionalInput' + snum ).checked ) {
					optionalsElements.value = CreateAPage.unuseSection(
						document.getElementById( 'createpage_section_' + snum ),
						optionalsElements.value
					);
				}
				jQuery( '#' + optionals[i] ).change( function( e ) {
					CreateAPage.toggleSection( e, { num: snum } );
				});
			}
		}
	},

	insertMultiEditButton: function( parent, item ) {
		var image = document.createElement( 'img' );
		image.width = 23;
		image.height = 22;
		image.className = 'mw-toolbar-editbutton';
		if ( item.imageId ) {
			image.id = item.imageId;
		}
		image.src = item.imageFile;
		image.border = 0;
		image.alt = item.speedTip;
		image.title = item.speedTip;
		image.style.cursor = 'pointer';

		parent.appendChild( image );

		jQuery( '#' + item.imageId ).click( function( e ) {
			CreateAPage.insertTags( e, {
				'tagOpen': item.tagOpen,
				'tagClose': item.tagClose,
				'sampleText': item.sampleText,
				'textareaId': 'wpTextboxes' + item.toolbarId
			});
		});

		return true;
	},

	insertTags: function( e, o ) {
		e.preventDefault();
		var textarea = document.getElementById( o.textareaId );
		if ( !textarea ) {
			return;
		}
		var selText, isSample = false;

		if ( document.selection && document.selection.createRange ) {
			var winScroll;
			if ( document.documentElement && document.documentElement.scrollTop ) {
				winScroll = document.documentElement.scrollTop;
			} else if ( document.body ) {
				winScroll = document.body.scrollTop;
			}
			textarea.focus();
			var range = document.selection.createRange();
			selText = range.text;

			if ( !selText ) {
				selText = o.sampleText;
				isSample = true;
			} else if ( selText.charAt( selText.length - 1 ) === ' ' ) {
				selText = selText.substring( 0, selText.length - 1 );
				o.tagClose += ' ';
			}

			range.text = o.tagOpen + selText + o.tagClose;
			if ( isSample && range.moveStart ) {
				if ( window.opera ) {
					o.tagClose = o.tagClose.replace( /\n/g, '' );
				}
				range.moveStart( 'character', - o.tagClose.length - selText.length );
				range.moveEnd( 'character', - o.tagClose.length );
			}
			range.select();
			if ( document.documentElement && document.documentElement.scrollTop ) {
				document.documentElement.scrollTop = winScroll;
			} else if ( document.body ) {
				document.body.scrollTop = winScroll;
			}
		} else if ( textarea.selectionStart || textarea.selectionStart === '0' ) {
			var textScroll = textarea.scrollTop;
			textarea.focus();
			var startPos = textarea.selectionStart;
			var endPos = textarea.selectionEnd;
			selText = textarea.value.substring( startPos, endPos );

			if ( !selText ) {
				selText = o.sampleText;
				isSample = true;
			} else if ( selText.charAt( selText.length - 1 ) === ' ' ) {
				selText = selText.substring( 0, selText.length - 1 );
				o.tagClose += ' ';
			}

			textarea.value = textarea.value.substring( 0, startPos ) +
				o.tagOpen + selText + o.tagClose +
				textarea.value.substring( endPos, textarea.value.length );
			if ( isSample ) {
				textarea.selectionStart = startPos + o.tagOpen.length;
				textarea.selectionEnd = startPos + o.tagOpen.length + selText.length;
			} else {
				textarea.selectionStart = startPos + o.tagOpen.length +
					selText.length + o.tagClose.length;
				textarea.selectionEnd = textarea.selectionStart;
			}
			textarea.scrollTop = textScroll;
		}
	},

	initialRound: function() {
		document.getElementById( 'Createtitle' ).setAttribute( 'autocomplete', 'off' );
		if ( ( CreateAPage.previewMode === 'No' ) && ( CreateAPage.redLinkMode === 'No' ) ) {
			CreateAPage.contentOverlay();
		} else {
			var catlink = document.getElementById( 'catlinks' ); // @todo FIXME/CHECKME: isn't it a class in modern MWs?
			if ( catlink ) {
				var newCatlink = document.createElement( 'div' );
				newCatlink.setAttribute( 'id', 'catlinks' );
				newCatlink.innerHTML = catlink.innerHTML;
				catlink.parentNode.removeChild( catlink );
				var previewArea = document.getElementById( 'createpagepreview' );
				previewArea.insertBefore( newCatlink, document.getElementById( 'createpage_preview_delimiter' ) );
			}
		}

		var edit_textareas = CreateAPage.getElementsBy(
			CreateAPage.editTextareaTest,
			'textarea',
			document.getElementById( 'wpTableMultiEdit' ),
			CreateAPage.textareaAddToolbar
		);
		if ( ( CreateAPage.redLinkMode === 'Yes' ) && ( edit_textareas[0].id === 'wpTextboxes0' ) ) {
			edit_textareas[0].focus();
		} else {
			var el_id = parseInt( edit_textareas[0].id.replace( 'wpTextboxes', '' ) );
			document.getElementById( 'toolbar' + el_id ).style.display = '';
			CreateAPage.hideOtherBoxes( el_id );
		}

		CreateAPage.multiEditSetupToolbar();
		CreateAPage.multiEditSetupOptionalSections();
		CreateAPage.checkCategoryCloud();
	},

	/**
	 * Render the overlay that hides the editing buttons, the textarea and the
	 * save/preview/view changes buttons until the user supplies a title that
	 * does not exist yet on the wiki.
	 */
	contentOverlay: function() {
		/*
		CreateAPage.Overlay = new YAHOO.widget.Overlay( 'createpageoverlay' );
		CreateAPage.resizeOverlay( 20 );
		CreateAPage.Overlay.render();
		*/

		// Based on the MIT-licensed jquery.overlay plugin by Tom McFarlin
		CreateAPage.Overlay = jQuery( '#createpageoverlay' ).css({
			background: '#000',
			display: 'none',
			// throw in an extra 25px to make sure that we *really* cover all
			// the editing buttons, the whole textarea *and* the buttons
			height: jQuery( '#cp-restricted' ).height() + 25,
			//left: jQuery( '#cp-restricted' ).offset().left, // more harmful than useful
			opacity: 0.5,
			overflow: 'hidden',
			position: 'absolute',
			//top: jQuery( '#cp-restricted' ).offset().top, // more harmful than useful
			width: jQuery( '#cp-restricted' ).width(),
			zIndex: 1000
		}).show();

		var helperButton = document.getElementById( 'wpRunInitialCheck' );
		jQuery( '#wpRunInitialCheck' ).click( function() {
			CreateAPage.watchTitle();
		});
		helperButton.style.display = '';
	},

	appendHeight: function( elem_height, number ) {
		var x_fixed_height = elem_height.replace( 'px', '' );
		x_fixed_height = parseFloat( x_fixed_height ) + number;
		x_fixed_height = x_fixed_height.toString() + 'px';
		return x_fixed_height;
	},

	resizeOverlay: function( number ) {
		var cont_elem = jQuery( '#cp-restricted' );
		var fixed_height;
		var fixed_width;
		if ( cont_elem.css( 'height' ) === 'auto' ) {
			fixed_height = document.getElementById( 'cp-restricted' ).offsetHeight + number;
			fixed_width = document.getElementById( 'cp-restricted' ).offsetWidth;
		} else {
			fixed_height = cont_elem.css( 'height' );
			fixed_height = CreateAPage.appendHeight( fixed_height, number );
			fixed_width = cont_elem.css( 'width' );
		}

		// @todo FIXME: commented out for now to prevent JS errors
		//CreateAPage.Overlay.cfg.setProperty( 'height', fixed_height );
		//CreateAPage.Overlay.cfg.setProperty( 'width', fixed_width );
	},

	testInfoboxToggle: function() {
		var listeners = jQuery( '#cp-infobox-toggle' ).data( 'events' );
		if ( listeners ) {
			for ( var i = 0; i < listeners.length; ++i ) {
				var listener = listeners[i];
				if ( listener.type !== 'click' ) {
					jQuery( '#cp-infobox-toggle' ).click( function( e ) {
						CreateAPageListeners.toggle( e, ['cp-infobox', 'cp-infobox-toggle'] );
					});
				}
			}
		} else {
			jQuery( '#cp-infobox-toggle' ).click( function( e ) {
				CreateAPageListeners.toggle( e, ['cp-infobox', 'cp-infobox-toggle'] );
			});
		}
	},

	initializeMultiEdit: function() {
		// Original PHP implementation was: join( ', ', $elements_for_yui )
		var elements = wgCreateAPageElementsForJavaScript; //[ Array.prototype.join.call( wgCreateAPageElementsForJavaScript, ', ' ) ];

		for ( var i = 0; i < wgCreateAPageElementsForJavaScript.length; i++ ) {
			jQuery( '#' + wgCreateAPageElementsForJavaScript[i] ).click( function( e ) {
				CreateAPage.switchTemplate( e, wgCreateAPageElementsForJavaScript[i], this );
			});
		}

		var src, tt;
		// Hide the radio buttons on the left side of each createplate's name,
		// they look ugly in here
		for ( i in elements ) {
			jQuery( '#' + elements[i] + '-radio' ).hide();
		}
	},

	/**
	 * Whenever a user clicks on one of the various createplate names, this
	 * function is called.
	 *
	 * @param e Event
	 * @param elementId String: name of the createplate template (i.e.
	 * cp-template-Name) -- actually doesn't seem to work, which is why we pass
	 * fullElement into this function and use it to get the ID instead
	 * @param fullElement
	 */
	switchTemplate: function( e, elementId, fullElement ) {
		CreateAPage.myId = fullElement.id;
		e.preventDefault();

		document.getElementById( 'cp-multiedit' ).innerHTML =
			'<img src="' + wgScriptPath + '/extensions/CreateAPage/images/progress_bar.gif" width="70" height="11" alt="' +
			mw.msg( 'createpage-please-wait' ) + '" border="0" />';
		if ( CreateAPage.Overlay ) {
			CreateAPage.resizeOverlay( 20 );
		}

		jQuery.ajax({ // using .ajax instead of .get for better flexibility
			url: wgScript,
			data: {
				action: 'ajax',
				rs: 'axMultiEditParse',
				template: fullElement.id.replace( 'cp-template-', '' )
			},
			success: function( data, textStatus, jqXHR ) {
				document.getElementById( 'cp-multiedit' ).innerHTML = '';

				var res = '';
				if( /^("(\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/.test( jqXHR.responseText ) ) {
					res = eval( '(' + jqXHR.responseText + ')' );
				}
				if ( res !== '' ) {
					document.getElementById( 'cp-multiedit' ).innerHTML = res;
				}

				var elements = wgCreateAPageElementsForJavaScript;
				for ( var i in elements ) {
					jQuery( '#' + elements[i] ).addClass( 'templateFrame' );
					if ( jQuery( '#' + elements[i] ).hasClass( 'templateFrameSelected' ) ) {
						jQuery( '#' + elements[i] ).removeClass( 'templateFrameSelected' );
					}
				}

				// Make the recently selected createplate active!
				jQuery( '#' + CreateAPage.myId ).addClass( 'templateFrameSelected' );

				var infoboxToggle = jQuery( '#cp-infobox-toggle' );
				if ( infoboxToggle.length > 0 ) {
					CreateAPage.testInfoboxToggle();
					//YAHOO.util.Event.onAvailable( 'cp-infobox-toggle', CreateAPage.testInfoboxToggle );
				}

				var infobox_root = document.getElementById( 'cp-infobox' );
				var infobox_inputs = CreateAPage.getElementsBy(
					CreateAPageInfobox.inputTest,
					'input',
					infobox_root,
					CreateAPageInfobox.inputEvent
				);
				var infobox_uploads = CreateAPage.getElementsBy(
					CreateAPageInfobox.uploadTest,
					'input',
					infobox_root,
					CreateAPageInfobox.uploadEvent
				);
				var content_root = document.getElementById( 'wpTableMultiEdit' );
				var section_uploads = CreateAPage.getElementsBy(
					CreateAPage.uploadTest,
					'input',
					content_root,
					CreateAPage.uploadEvent
				);

				var cloud_div = document.getElementById( 'createpage_cloud_div' );
				if ( cloud_div !== null ) {
					cloud_div.style.display = 'block';
				}
				CreateAPage.checkCategoryCloud();

				if (
					CreateAPage.Overlay &&
					( document.getElementById( 'createpageoverlay' ).style.visibility !== 'hidden' )
				)
				{
					CreateAPage.resizeOverlay( 20 );
				}

				CreateAPage.multiEditTextboxes = [];
				CreateAPage.multiEditButtons = [];
				CreateAPage.multiEditCustomButtons = [];

				var edit_textareas = CreateAPage.getElementsBy(
					CreateAPage.editTextareaTest,
					'textarea',
					content_root,
					CreateAPage.textareaAddToolbar
				);

				if ( ( CreateAPage.redLinkMode === 'Yes' ) && ( 'wpTextboxes0' === edit_textareas[0].id ) ) {
					edit_textareas[0].focus();
				} else {
					var el_id = parseInt( edit_textareas[0].id.replace( 'wpTextboxes', '' ) );
					document.getElementById( 'toolbar' + el_id ).style.display = '';
					CreateAPage.hideOtherBoxes( el_id );
				}

				var edittools_div = document.getElementById( 'createpage_editTools' );
				if ( edittools_div ) {
					if ( CreateAPage.myId != 'cp-template-Blank' ) {
						edittools_div.style.display = 'none';
					} else {
						edittools_div.style.display = '';
					}
				}

				CreateAPage.multiEditSetupToolbar();
				CreateAPage.multiEditSetupOptionalSections();
			},
			error: function( jqXHR, textStatus, errorThrown ) {
				document.getElementById( 'cp-multiedit' ).innerHTML = '';
			},
			timeout: 50000
		});
	},

	checkExistingTitle: function( e ) {
		if ( document.getElementById( 'Createtitle' ).value === '' ) {
			e.preventDefault();
			document.getElementById( 'cp-title-check' ).innerHTML = '<span style="color: red;">' +
				mw.msg( 'createpage-give-title' ) + '</span>';
			window.location.hash = 'title_loc';
			CreateAPage.SubmitEnabled = false;
		} else if ( CreateAPage.noCanDo === true ) {
			CreateAPage.warningPanel = jQuery( '#dlg' ).dialog({
				//autoOpen: false,
				draggable: false,
				hide: 'slide',
				modal: true,
				resizable: false,
				title: mw.msg( 'createpage-title-check-header' ),
				// original YUI code used 20em, but I don't think jQuery supports that.
				// So I went to PXtoEM.com to convert 20em to pixels; I used
				// 20.5 as the base font size in pixels, because we set the
				// font size to 127% in Monobook's main.css and according to
				// their conversion tables, 20px is 125%
				width: 410
			});
			/*
			TitleDialog = new YAHOO.widget.SimpleDialog( 'dlg', {
				width: '20em',
				effect: {
					effect: YAHOO.widget.ContainerEffect.FADE,
					duration: 0.4
				},
				fixedcenter: true,
				modal: true,
				visible: false,
				draggable: false
			});
			TitleDialog.setHeader( mw.msg( 'createpage-title-check-header' ) );
			TitleDialog.setBody( mw.msg( 'createpage-title-check-text' ) );
			TitleDialog.cfg.setProperty( 'icon', YAHOO.widget.SimpleDialog.ICON_WARN );
			TitleDialog.cfg.setProperty( 'zIndex', 1000 );
			TitleDialog.render( document.body );
			TitleDialog.show();
			*/
			e.preventDefault();
			CreateAPage.submitEnabled = false;
		}
		if (
			( CreateAPage.submitEnabled !== true ) ||
			( CreateAPage.Overlay && ( document.getElementById( 'createpageoverlay' ).style.visibility != 'hidden' ) )
		)
		{
			e.preventDefault();
		}
	},

	enableSubmit: function( e ) {
		CreateAPage.submitEnabled = true;
	},

	/**
	 * Copied from the YUI library, version 2.5.2
	 *
	 * Copyright (c) 2008, Yahoo! Inc. All rights reserved.
	 * Code licensed under the BSD License:
	 * http://developer.yahoo.net/yui/license.txt
	 */
	getElementsBy: function( method, tag, root, apply ) {
		tag = tag || '*';

		root = ( root ) ? /*jQuery( */root /*)*/ : null || document;

		if ( !root ) {
			return [];
		}

		var nodes = [],
			elements = root.getElementsByTagName( tag );

		for ( var i = 0, len = elements.length; i < len; ++i ) {
			if ( method( elements[i] ) ) {
				nodes[nodes.length] = elements[i];

				if ( apply ) {
					apply( elements[i] );
				}
			}
		}

		return nodes;
	}
}; // end of the CreateAPage class

window.onresize = function() {
	if ( CreateAPage.Overlay && ( document.getElementById( 'createpageoverlay' ).style.visibility !== 'hidden' ) ) {
		//CreateAPage.resizeOverlay( 0 );
	}
};

/**
 * Class for uploading images from an infobox on the Special:CreatePage page.
 */
var CreateAPageInfobox = {
	failureCallback: function( response ) {
		document.getElementById( 'createpage_image_text' + response.argument ).innerHTML = mw.msg( 'createpage-insert-image' );
		document.getElementById( 'createpage_upload_progress' + response.argument ).innerHTML = mw.msg( 'createpage-upload-aborted' );
		document.getElementById( 'createpage_upload_file' + response.argument ).style.display = '';
		document.getElementById( 'createpage_image_text' + response.argument ).style.display = '';
		document.getElementById( 'createpage_image_cancel' + response.argument ).style.display = 'none';
	},

	upload: function( e, o ) {
		var n = o.num;
		var oForm = document.getElementById( 'createpageform' );
		if ( oForm ) {
			e.preventDefault();
			var ProgressBar = document.getElementById( 'createpage_upload_progress' + o.num );
			ProgressBar.style.display = 'block';
			ProgressBar.innerHTML = '<img src="' + stylepath + '/common/images/spinner.gif" width="16" height="16" alt="' +
				mw.msg( 'createpage-please-wait' ) + '" border="0" />&nbsp;';

			var sent_request = jQuery.ajax({ // using .ajax instead of .post for better flexibility
				type: 'POST',
				url: wgScript,
				data: {
					action: 'ajax',
					rs: 'axMultiEditImageUpload',
					num: n
				},
				success: function( data, textStatus, jqXHR ) {
					// @todo FIXME/CHECKME: make sure that the num (n) is passed as response.argument to uploadCallback
					CreateAPageInfobox.uploadCallback( jqXHR );
				},
				error: function( jqXHR, textStatus, errorThrown ) {
					CreateAPageInfobox.failureCallback( jqXHR );
				},
				timeout: 60000
			});
			document.getElementById( 'createpage_image_cancel' + o.num ).style.display = '';
			document.getElementById( 'createpage_image_text' + o.num ).style.display = 'none';

			jQuery( '#createpage_image_cancel' + o.num ).click( function( e ) {
				sent_request.abort();
			});

			var neoInput = document.createElement( 'input' );
			var thisInput = document.getElementById( 'createpage_upload_file' + o.num );
			var thisContainer = document.getElementById( 'createpage_image_label' + o.num );
			thisContainer.removeChild( thisInput );

			neoInput.setAttribute( 'type', 'file' );
			neoInput.setAttribute( 'id', 'createpage_upload_file' + o.num );
			neoInput.setAttribute( 'name', 'wpUploadFile' + o.num );
			neoInput.setAttribute( 'tabindex', '-1' );

			thisContainer.appendChild( neoInput );
			jQuery( '#createpage_upload_file' + o.num ).change( function( e ) {
				CreateAPageInfobox.upload( e, { 'num': o.num } );
			});

			document.getElementById( 'createpage_upload_file' + o.num ).style.display = 'none';
		}
	},

	uploadCallback: function( response ) {
		var aResponse = []; // initialize it as an empty array so that JSHint can STFU
		if( /^("(\\.|[^"\\\n\r])*?"|[,:{}\[\]0-9.\-+Eaeflnr-u \n\r\t])+?$/.test( response.responseText ) ) {
			aResponse = eval( '(' + response.responseText + ')' );
		}
		var ProgressBar = document.getElementById( 'createpage_upload_progress' + response.argument );
		if ( aResponse['error'] != 1 ) {
			var xInfoboxText = document.getElementById( 'wpInfoboxValue' ).value;
			var xImageHelper = document.getElementById( 'wpInfImg' + response.argument ).value;
			document.getElementById( 'wpInfImg' + response.argument ).value = aResponse['msg'];
			document.getElementById( 'wpNoUse' + response.argument ).value = 'Yes';
			ProgressBar.innerHTML = mw.msg( 'createpage-img-uploaded' );
			var ImageThumbnail = document.getElementById( 'createpage_image_thumb' + response.argument );
			var thumb_container = document.getElementById( 'createpage_main_thumb' + response.argument );
			var tempstamp = new Date();
			ImageThumbnail.src = aResponse['url'] + '?' + tempstamp.getTime();
			if ( document.getElementById( 'wpLastTimestamp' + response.argument ).value == 'None' ) {
				var break_tag = document.createElement( 'br' );
				thumb_container.style.display = '';
				var label_node = document.getElementById( 'createpage_image_label' + response.argument );
				var par_node = label_node.parentNode;
				par_node.insertBefore( break_tag, label_node );
			}
			document.getElementById( 'wpLastTimestamp' + response.argument ).value = aResponse['timestamp'];
		} else if ( ( aResponse['error'] == 1 ) && ( aResponse['msg'] == 'cp_no_login' ) ) {
			ProgressBar.innerHTML = '<span style="color: red">' +
				mw.msg( 'createpage-login-required' ) + '<a href="' + wgServer +
					wgScript + '?title=Special:UserLogin&returnto=Special:CreatePage" id="createpage_login_infobox' +
					response.argument + '">' + mw.msg( 'createpage-login-href' ) +
					'</a>' + mw.msg( 'createpage-login-required2' ) +
				'</span>';
			jQuery( '#createpage_login_infobox' + response.argument ).click(
				function( e ) {
					CreateAPage.showWarningLoginPanel( e );
				}
			);
		} else {
			ProgressBar.innerHTML = '<span style="color: red">' + aResponse['msg'] + '</span>';
		}
		document.getElementById( 'createpage_image_text' + response.argument ).innerHTML = mw.msg( 'createpage-insert-image' );
		document.getElementById( 'createpage_upload_file' + response.argument ).style.display = '';
		document.getElementById( 'createpage_image_text' + response.argument ).style.display = '';
		document.getElementById( 'createpage_image_cancel' + response.argument ).style.display = 'none';
	},

	inputTest: function( el ) {
		if ( el.id.match( 'wpInfoboxPar' ) ) {
			return true;
		} else {
			return false;
		}
	},

	inputEvent: function( el ) {
		var j = parseInt( el.id.replace( 'wpInfoboxPar', '' ) );
		if ( jQuery( '#wpInfoboxPar' + j ).length > 0 ) {
			CreateAPage.clearInput( { num: j } );
		}
		//YAHOO.util.Event.onContentReady( 'wpInfoboxPar' + j, CreateAPage.clearInput, { num: j } );
	},

	uploadTest: function( el ) {
		if ( el.id.match( 'createpage_upload_file' ) ) {
			return true;
		} else {
			return false;
		}
	},

	uploadEvent: function( el ) {
		var j = parseInt( el.id.replace( 'createpage_upload_file', '' ) );
		jQuery( '#createpage_upload_file' + j ).change( function( e ) {
			CreateAPageInfobox.upload( e, { 'num' : j } );
		} );
	}
};

// Initialize stuff when the DOM is ready
jQuery( document ).ready( function() {
	// This creates the overlay over the editor and effectively blocks the user
	// from typing text on the textarea and thus forces them to supply the page
	// title first.
	// Should be executed when #cp-multiedit exists
	CreateAPage.initialRound();

	CreateAPage.initializeMultiEdit();

	jQuery( '#createpageform' ).submit( function( e ) {
		CreateAPage.checkExistingTitle( e );
	});

	jQuery( '#wpSave' ).click( function( e ) {
		CreateAPage.enableSubmit( e );
	});

	jQuery( '#wpPreview' ).click( function( e ) {
		CreateAPage.enableSubmit( e );
	});

	jQuery( '#wpCancel' ).click( function( e ) {
		CreateAPage.enableSubmit( e );
	});

	jQuery( '#cp-chooser-toggle' ).click( function( e ) {
		CreateAPageListeners.toggle( e, ['cp-chooser', 'cp-chooser-toggle'] );
	});

	// FIXME onAvailable?
	var listeners = jQuery( '#cp-infobox-toggle' ).data( 'events' );
	if ( listeners ) {
		for ( var i = 0; i < listeners.length; ++i ) {
			var listener = listeners[i];
			if ( listener.type !== 'click' ) {
				jQuery( '#cp-infobox-toggle' ).click( function( e ) {
					CreateAPageListeners.toggle( e, ['cp-infobox', 'cp-infobox-toggle'] );
				});
			}
		}
	} else {
		jQuery( '#cp-chooser-toggle' ).click( function( e ) {
			CreateAPageListeners.toggle( e, ['cp-infobox', 'cp-infobox-toggle'] );
		});
	}

	// "Add a category" input (see categorypage.tmpl.php)
	var categoryButton = jQuery( '#wpCategoryButton' );
	if ( categoryButton.length > 0 ) {
		categoryButton.click( function( e ) {
			CreateAPageCategoryTagCloud.inputAdd();
			return false;
		});
	}

	jQuery( '#Createtitle' ).change( CreateAPage.watchTitle );

	// Clicking on the "Advanced Edit" button shows a modal dialog asking the
	// user, "Switching editing modes may break page formatting, do you want to continue?"
	jQuery( '#wpAdvancedEdit' ).bind( 'click', function( e ) {
		CreateAPage.showWarningPanel( e );
	});

	// Clicking on the "Article Title" input clears any "This article already
	// exists" messages
	jQuery( '#Createtitle' ).bind( 'focus', function( e ) {
		CreateAPage.clearTitleMessage( e );
	});
});