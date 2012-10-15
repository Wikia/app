function securepoll_strike_popup(e, action, id) {
	var pop = document.getElementById('securepoll-popup');

	var e = window.event || e;
	if(!e) return;
	var target = e.target || e.srcElement;
	if(!target) return;

	if ( pop.parentNode.tagName.toLowerCase() != 'body' ) {
		pop = pop.parentNode.removeChild( pop );
		pop = document.body.appendChild( pop );
	}

	var left = 0;
	var top = 0;
	var containing = target;
	while ( containing ) {
		left += containing.offsetLeft;
		top += containing.offsetTop;
		containing = containing.offsetParent;
	}
	left += target.offsetWidth - 10;
	top += target.offsetHeight - 10;

	// Show the appropriate button
	var strikeButton = document.getElementById( 'securepoll-strike-button' );
	var unstrikeButton = document.getElementById( 'securepoll-unstrike-button' );
	if ( action == 'strike' ) {
		strikeButton.style.display = 'inline';
		strikeButton.disabled = false;
		unstrikeButton.style.display = 'none';
		unstrikeButton.disabled = true;
	} else {
		unstrikeButton.style.display = 'inline';
		unstrikeButton.disabled = false;
		strikeButton.style.display = 'none';
		strikeButton.disabled = true;
	}
	document.getElementById( 'securepoll-strike-result' ).innerHTML = '';

	// Set the hidden fields for submission
	document.getElementById( 'securepoll-action').value = action;
	document.getElementById( 'securepoll-vote-id' ).value = id;

	// Show the popup
	pop.style.left = left + 'px';
	pop.style.top = top + 'px';
	pop.style.display = 'block';

	// Focus on the reason box
	var reason = document.getElementById( 'securepoll-strike-reason' );
	reason.focus();
	reason.select();
}

function securepoll_strike(action) {
	var popup = document.getElementById('securepoll-popup');
	if(action == 'cancel') {
		popup.style.display = '';  
		return;
	}
	if ( action == 'submit' ) {
		action = document.getElementById( 'securepoll-action' ).value;
	}
	var id = document.getElementById( 'securepoll-vote-id' ).value;
	var strikeButton = document.getElementById( 'securepoll-strike-button' );
	var unstrikeButton = document.getElementById( 'securepoll-unstrike-button' );
	var spinner = document.getElementById( 'securepoll-strike-spinner' );
	strikeButton.disabled = true;
	unstrikeButton.disabled = true;
	spinner.style.display = 'block';
	var reason = document.getElementById( 'securepoll-strike-reason' ).value;

	var processResult = function (xhr) {
		spinner.style.display = 'none';
		strikeButton.disabled = false;
		unstrikeButton.disabled = false;
		
		if ( xhr.status >= 300 || xhr.status < 200 ) {
			document.getElementById( 'securepoll-strike-result' ).innerHTML = xhr.responseText;
			return;
		}

		// Evaluate JSON result, with brackets to avoid interpretation as a code block
		result = eval( '(' + xhr.responseText + ')' );
		if ( result.status == 'good' ) {
			popup.style.display = 'none';
		} else {
			document.getElementById( 'securepoll-strike-result' ).innerHTML = result.message;
		}

		securepoll_modify_document( action, id );
	};

	sajax_do_call( 'wfSecurePollStrike', [ action, id, reason ], processResult );
}

function securepoll_modify_document( action, voteId ) {
	var popupButton = document.getElementById( 'securepoll-popup-' + voteId );
	var row = popupButton.parentNode.parentNode;
	if ( action == 'strike' ) {
		row.className += ' securepoll-struck-vote';
		popupButton.value = securepoll_unstrike_button;
	} else {
		row.className = row.className.replace( 'securepoll-struck-vote', '' );
		popupButton.value = securepoll_strike_button;
	}
	popupButton.onclick = function (event) {
		securepoll_strike_popup( event, action == 'strike' ? 'unstrike' : 'strike', voteId );
	}
}

function securepoll_ballot_setup() {
	if ( !document.getElementsByTagName ) {
		return;
	}
	var anchors = document.getElementsByTagName( 'a' );
	for ( var i = 0; i < anchors.length; i++ ) {
		var elt = anchors.item( i );
		if ( elt.className != 'securepoll-error-jump' ) {
			continue;
		}
		if ( elt.addEventListener ) {
			elt.addEventListener( 'click', 
					function() {
						securepoll_error_jump( this, anchors );
					}, 
					false );
		} else {
			elt.attachEvent( 'onclick', securepoll_error_jump );
		}
	}
}

/**
 * TODO: make prettier
 */
function securepoll_error_jump( source, anchors ) {
	for ( var i = 0; i < anchors.length; i++ ) {
		var anchor = anchors.item( i );
		if ( anchor.className != 'securepoll-error-jump' ) {
			continue;
		}
		var id = anchor.getAttribute( 'href' ).substr( 1 );
		var elt = document.getElementById( id );
		if ( !elt ) {
			continue;
		}

		try {
			if ( anchor == source ) {
				elt.style.borderColor = '#ff0000';
				elt.style.backgroundColor = '#ffcc99';
			} else {
				elt.style.backgroundColor = 'transparent';
				elt.style.borderColor = 'transparent';
			}
		} catch ( e ) {}
	}
}

