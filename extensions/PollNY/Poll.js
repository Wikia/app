/**
 * JavaScript for PollNY extension
 * The PollNY object here contains almost all the JS that the extension needs.
 * Previously these JS bits and pieces were scattered over in different places.
 * When we require ResourceLoader (and thus at least MW 1.17), we can drop the
 * _POLL-something variables that we currently use for i18n in favor of mw.msg.
 *
 * @file
 * @ingroup Extensions
 * @author Jack Phoenix
 * @date 19 June 2011
 */
var PollNY = {
	voted: 0,

	/**
	 * @return Boolean: true if the browser is Firefox under Mac
	 */
	detectMacXFF: function() {
		var userAgent = navigator.userAgent.toLowerCase();
		if( userAgent.indexOf( 'mac' ) != -1 && userAgent.indexOf( 'firefox' ) != -1 ) {
			return true;
		}
	},

	show: function() {
		var loadingElement = document.getElementById( 'loading-poll' );
		var displayElement = document.getElementById( 'poll-display' );
		if ( loadingElement ) {
			loadingElement.style.display = 'none';
			loadingElement.style.visibility = 'hidden';
		}
		if ( displayElement ) {
			displayElement.style.display = 'block';
			displayElement.style.visibility = 'visible';
		}
	},

	/**
	 * Show the "loading..." text in the lightbox.
	 */
	loadingLightBox: function() {
		// pop up the lightbox
		var objLink = {};
		//objLink.href = wgServer + wgScriptPath + '/extensions/PollNY/images/ajax-loader.gif';
		objLink.href = '';
		objLink.title = '';

		LightBox.show( objLink );

		if( !PollNY.detectMacXFF() ) {
			LightBox.setText(
				'<embed src="' + wgScriptPath + '/extensions/PollNY/ajax-loading.swf" quality="high" wmode="transparent" bgcolor="#ffffff"' +
				'pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash"' +
				'type="application/x-shockwave-flash" width="100" height="100">' +
				'</embed>'
			);
		} else {
			LightBox.setText( 'Loading...' );
		}
	},

	/**
	 * Skip the current poll and pick a new, random one.
	 */
	skip: function() {
		PollNY.loadingLightBox();
		sajax_request_type = 'POST';
		sajax_do_call(
			'wfPollVote',
			[ document.getElementById( 'poll_id' ).value, -1 ],
			function( response ) {
				PollNY.goToNewPoll();
			}
		);
	},

	/**
	 * Vote for a poll and move to the next poll.
	 */
	vote: function() {
		if( PollNY.voted == 1 ) {
			return 0;
		}

		PollNY.voted = 1;

		PollNY.loadingLightBox();
		var choice_id = 0;
		for( var i = 0; i < document.poll.poll_choice.length; i++ ) {
			if( document.poll.poll_choice[i].checked ) {
				choice_id = document.poll.poll_choice[i].value;
			}
		}

		if( choice_id ) {
			// cast vote
			sajax_request_type = 'POST';
			sajax_do_call(
				'wfPollVote',
				[ document.getElementById( 'poll_id' ).value, choice_id ],
				function( response ) {
					PollNY.goToNewPoll();
				}
			);
		}
	},

	/**
	 * Fetch a randomly chosen poll from the database and go to it by
	 * manipulating window.location.
	 * If there are no more polls, prompt the user to create one, unless
	 * they're on Special:CreatePoll.
	 */
	goToNewPoll: function() {
		// cast vote
		sajax_do_call( 'wfGetRandomPoll', [], function( req ) {
			// redirect to next poll they haven't voted for
			if( req.responseText.indexOf( 'error' ) == -1 ) {
				window.location = wgServer + wgScriptPath +
					'/index.php?title=' + req.responseText +
					'&prev_id=' + wgArticleId;
			} else {
				if (
					typeof( wgCanonicalSpecialPageName ) != 'undefined' &&
					wgCanonicalSpecialPageName == 'CreatePoll'
				)
				{
					alert( _POLL_CREATEPOLL_ERROR );
				} else {
					// have run out of polls
					// lightbox prompting to create
					LightBox.setText( _POLL_FINISHED );
				}
			}
		});
	},

	/**
	 * Change the status of a poll, commit changes to the DB and reload the
	 * current page.
	 *
	 * @param status Integer: 0 = closed, 1 = open, 2 = flagged
	 */
	toggleStatus: function( status ) {
		var msg;
		if( status === 0 ) {
			msg = _POLL_CLOSE_MESSAGE;
		}
		if( status == 1 ) {
			msg = _POLL_OPEN_MESSAGE;
		}
		if( status == 2 ) {
			msg = _POLL_FLAGGED_MESSAGE;
		}
		var ask = confirm( msg );

		if( ask ) {
			sajax_request_type = 'POST';
			sajax_do_call(
				'wfUpdatePollStatus',
				[ document.getElementById( 'poll_id' ).value, status ],
				function( response ) {
					window.location.reload();
				}
			);
		}
	},

	// Embed poll stuff
	showEmbedPoll: function( id ) {
		var loadingElement = document.getElementById( 'loading-poll_' + id );
		var displayElement = document.getElementById( 'poll-display_' + id );
		if ( loadingElement ) {
			loadingElement.style.display = 'none';
			loadingElement.style.visibility = 'hidden';
		}
		displayElement.style.display = 'block';
		displayElement.style.visibility = 'visible';
	},

	/**
	 * Cast a vote for an embedded poll.
	 *
	 * @param id Integer: poll ID number
	 * @param pageId Integer:
	 */
	pollEmbedVote: function( id, pageId ) {
		var choice_id = 0;
		var poll_form = eval( 'document.poll_'	+ id + '.poll_choice' );

		for ( var i = 0; i < poll_form.length; i++ ) {
			if ( poll_form[i].checked ) {
				choice_id = poll_form[i].value;
			}
		}

		if( choice_id ) {
			// Cast vote
			sajax_request_type = 'POST';
			sajax_do_call( 'wfPollVote', [ id, choice_id ], function( response ) {
				PollNY.showResults( id, pageId );
			});
		}
	},

	/**
	 * Show the results of an embedded poll.
	 *
	 * @param id Integer: poll ID number
	 * @param pageId Integer:
	 */
	showResults: function( id, pageId ) {
		sajax_request_type = 'POST';
		sajax_do_call( 'wfGetPollResults', [ pageId ], function( response ) {
			document.getElementById( 'poll-display_' + id ).innerHTML = response.responseText;
		});
	},

	// The next two functions are from SpecialViewPoll.php
	/**
	 * Change the background color of the given element when the user hovers
	 * their mouse over the said element.
	 *
	 * @param divID String: element name
	 */
	doHover: function( divID ) {
		document.getElementById( divID ).style.backgroundColor = '#FFFCA9';
	},

	/**
	 * @param divID String: element name
	 */
	endHover: function( divID ) {
		document.getElementById( divID ).style.backgroundColor = '';
	},

	// The next two functions are from SpecialAdminPoll.php
	/**
	 * @todo FIXME: would be nice if we could somehow merge this function with
	 * toggleStatus()...the major differences here are the id argument (which
	 * is present only here) and what's done after the AJAX function has been
	 * called; this function shows the text "action complete" on a given
	 * element, while toggleStatus() reloads the page
	 */
	poll_admin_status: function( id, status ) {
		var msg;
		if( status == 0 ) {
			msg = _POLL_CLOSE_MESSAGE;
		}
		if( status == 1 ) {
			msg = _POLL_OPEN_MESSAGE;
		}
		if( status == 2 ) {
			msg = _POLL_FLAGGED_MESSAGE;
		}
		var ask = confirm( msg );

		if ( ask ) {
			sajax_request_type = 'POST';
			sajax_do_call(
				'wfUpdatePollStatus',
				[ id, status ],
				function( response ) {
					document.getElementById( 'poll-' + id + '-controls' ).innerHTML = 'action complete';
				}
			);
		}
	},

	/**
	 * Delete a poll with the given ID number.
	 *
	 * @param id Integer: ID number of the poll that we're about to delete
	 */
	poll_delete: function( id ) {
		var msg = _POLL_DELETE_MESSAGE;
		var ask = confirm( msg );

		if ( ask ) {
			sajax_request_type = 'POST';
			sajax_do_call( 'wfDeletePoll', [ id ], function( response ) {
				document.getElementById( 'poll-' + id + '-controls' ).innerHTML = 'action complete';
			});
		}
	},

	// from Special:CreatePoll UI template
	updateAnswerBoxes: function() {
		for( var x = 1; x <= 9; x++ ) {
			if( document.getElementById( 'answer_' + x ).value ) {
				elem = document.getElementById( 'poll_answer_' + ( x + 1 ) );
				elem.style.display = 'block';
				elem.style.visibility = 'visible';
			}
		}
	},

	resetUpload: function() {
		var uploadElement = document.getElementById( 'imageUpload-frame' );
		uploadElement.src = _POLL_IFRAME_URL;
		uploadElement.style.display = 'block';
		uploadElement.style.visibility = 'visible';
	},

	completeImageUpload: function() {
		document.getElementById( 'poll_image' ).innerHTML =
			'<div style="margin:0px 0px 10px 0px;"><img height="75" width="75" src="' +
			wgScriptPath + '/extensions/PollNY/images/ajax-loader-white.gif"></div>';
	},

	uploadError: function( error ) {
		document.getElementById( 'poll_image' ).innerHTML = error + '<p>';
		PollNY.resetUpload();
	},

	uploadComplete: function( img_tag, img_name ) {
		document.getElementById( 'poll_image' ).innerHTML = img_tag +
			'<p><a href="javascript:PollNY.resetUpload();">' +
			_POLL_UPLOAD_NEW + '</a></p>';
		document.form1.poll_image_name.value = img_name;
		document.getElementById( 'imageUpload-frame' ).style.display = 'none';
		document.getElementById( 'imageUpload-frame' ).style.visibility = 'hidden';
	},

	create: function() {
		var answers = 0;
		for( var x = 1; x <= 9; x++ ) {
			if( document.getElementById( 'answer_' + x ).value ) {
				answers++;
			}
		}

		if( answers < 2 ) {
			alert( _POLL_AT_LEAST );
			return '';
		}

		var val = document.getElementById( 'poll_question' ).value;
		if( !val ) {
			alert( _POLL_ENTER_QUESTION );
			return '';
		}

		if( val.indexOf( '#' ) > -1 ) {
			alert( _POLL_HASH );
			return '';
		}

		// Encode ampersands
		val = val.replace( '&', '%26' );

		// Check that the title doesn't exist already; if it does, alert the
		// user about this problem; otherwise submit the form
		sajax_request_type = 'POST';
		sajax_do_call( 'wfPollTitleExists', [ escape( val ) ], function( req ) {
			if( req.responseText.indexOf( 'OK' ) >= 0 ) {
				document.form1.submit();
			} else {
				alert( _POLL_PLEASE_CHOOSE );
			}
		});
	}
};