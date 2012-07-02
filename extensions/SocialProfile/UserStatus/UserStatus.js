var UserStatus = {
	maxStatusLength : 70,

	/**
	 * Go back to viewing the status update from the editing mode.
	 */
	toShowMode: function() {
		jQuery( '#status-edit-controls' ).hide();
		jQuery( '#user-status-block' ).show();
	},

	/**
	 * Show the "X letters left" message when the user is typing a status
	 * update.
	 */
	usLettersLeft: function() {
		var len = this.maxStatusLength - document.getElementById( 'user-status-input' ).value.length;
		if ( len < 0 ) {
			var usBlock = document.getElementById( 'user-status-input' );
			document.getElementById( 'user-status-input' ).value = usBlock.value.slice( 0, this.maxStatusLength );
			len++;
		}
		document.getElementById( 'status-letter-count' ).innerHTML = len + ' ' + _US_LETTERS;
	},

	/**
	 * Enter the edit mode by hiding the current status message and displaying
	 * the hidden input field which allows the user to enter a new status
	 * update + some other editing tools.
	 */
	toEditMode: function() {
		jQuery( '#user-status-block' ).hide();
		jQuery( '#status-edit-controls' ).show();
		// If the history div is (still) present, hide it
		if ( jQuery( '#status-history-block' ) ) {
			jQuery( '#status-history-block' ).hide();
		}
	},

	/**
	 * Save a status message into the database.
	 *
	 * @param id Integer: user ID number
	 */
	saveStatus: function( id ) {
		var div = document.getElementById( 'user-status-block' );
		var ustext = encodeURIComponent( document.getElementById( 'user-status-input' ).value );
		sajax_do_call( 'wfSaveStatus', [id, ustext], function( r ) {
			div.innerHTML = r.responseText;
			jQuery( '#status-edit-controls' ).hide();
			jQuery( '#user-status-block' ).show();
		});
	},

	/**
	 * Show the user's past status messages when they click on the "history"
	 * link on their profile.
	 *
	 * @param id Integer: user ID number
	 */
	useHistory: function( id ) {
		var historyBlock = document.getElementById( 'status-history-block' );
		if( historyBlock === null ) {
			var statusBlock;
			if ( document.getElementById( 'status-edit-controls' ) ) {
				// This div is present only when you're viewing your own
				// profile, it doesn't exist when you're viewing other people's
				// profiles
				statusBlock = document.getElementById( 'status-edit-controls' );
			} else {
				statusBlock = document.getElementById( 'user-status-block' );
			}
			historyBlock = document.createElement( 'div' );
			historyBlock.id = 'status-history-block';
			statusBlock.appendChild( historyBlock );
		}

		if ( historyBlock.style.display == 'block' ) {
			historyBlock.style.display = 'none';
		} else {
			// This call should be here, as it fixes bug,
			// when history does not change after first status save
			sajax_do_call( 'wfGetHistory', [id], historyBlock );
			historyBlock.style.display = 'block';
		}
	},

	/**
	 * Insert a previously used status message from the history list into the
	 * editing <input> whenever the user clicks on an archived status message.
	 *
	 * @param statusId Integer: status message ID, used in the HTML element as
	 *                          an ID
	 */
	insertStatusFromHistory: function( statusId ) {
		document.getElementById( 'user-status-input' ).value =
			jQuery( '#status-history-entry-' + statusId ).text();
	},

	like: function( userID, messageID ) {
		var div = document.getElementById( 'like-status-' + messageID );
		sajax_do_call( 'wfStatusLike', [userID, messageID], div );
	},

	specialGetHistory: function() {
		var us_name = document.getElementById( 'us-name-input' ).value;
		var block = document.getElementById( 'us-special' );
		sajax_do_call( 'SpecialGetStatusByName', [us_name], block );
	},

	specialHistoryDelete: function( id ) {
		var block = document.getElementById( 'us-special' );
		sajax_do_call( 'SpecialHistoryDelete', [id], block );
		this.specialGetHistory();
	},

	specialStatusDelete: function( id ) {
		var block = document.getElementById( 'us-special' );
		sajax_do_call( 'SpecialStatusDelete', [id], block );
		this.specialGetHistory();
	}
};