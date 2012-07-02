/**
 * JavaScript for UserRelationship
 * Used on Special:ViewRelationshipRequests
 */
function requestResponse( response, id ) {
	document.getElementById( 'request_action_' + id ).style.display = 'none';
	document.getElementById( 'request_action_' + id ).style.visibility = 'hidden';
	sajax_request_type = 'POST';
	sajax_do_call( 'wfRelationshipRequestResponse', [ response, id ], function( request ) {
		document.getElementById( 'request_action_' + id ).innerHTML = request.responseText;
		jQuery( '#request_action_' + id ).fadeIn( 2000 );
		document.getElementById( 'request_action_' + id ).style.display = 'block';
		document.getElementById( 'request_action_' + id ).style.visibility = 'visible';
	} );
}