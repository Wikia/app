var selected_gift = 0;

function selectGift( id ) {
	// Un-select previously selected gift
	if( selected_gift ) {
		jQuery( '#give_gift_' + selected_gift ).removeClass( 'g-give-all-selected' );
	}

	// Select new gift
	jQuery( '#give_gift_' + id ).addClass( 'g-give-all-selected' );

	selected_gift = id;
}

function highlightGift( id ) {
	jQuery( '#give_gift_' + id ).addClass( 'g-give-all-highlight' );
}

function unHighlightGift( id ) {
	jQuery( '#give_gift_' + id ).removeClass( 'g-give-all-highlight' );
}

function sendGift() {
	if( !selected_gift ) {
		alert( 'Please select a gift' );
		return false;
	}
	document.gift.gift_id.value = selected_gift;
	document.gift.submit();
}

function chooseFriend( friend ) {
	// Now, this is a rather nasty hack since the original (commented out below) wouldn't work when $wgScriptPath was set
	//window.location = window.location + "&user=" + friend;
	window.location = wgServer + wgScript + '?title=Special:GiveGift' + '&user=' + friend;
}