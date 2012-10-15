/**
 * JavaScript for LinkFilter extension
 *
 * @file
 * @author Jack Phoenix <jack@countervandalism.net>
 * @date 20 June 2011
 */
var LinkFilter = {
	linkAction: function( action, link_id ) {
		jQuery( 'div.action-buttons-1' ).hide();
		sajax_request_type = 'POST';
		sajax_do_call(
			'wfLinkFilterStatus',
			[ link_id, action ], 
			function( response ) {
				var msg;
				switch( action ) {
					case 1:
						msg = mediaWiki.msg( 'linkfilter-admin-accept-success' );
						break;
					case 2:
						msg = mediaWiki.msg( 'linkfilter-admin-reject-success' );
						break;
				}
				var elementToDisplay = document.getElementById( 'action-buttons-' + link_id );
				elementToDisplay.display = 'block';
				elementToDisplay.innerHTML = msg;
			}
		);
	},

	submitLink: function() {
		if (
			typeof( wgCanonicalSpecialPageName ) !== 'undefined' &&
			wgCanonicalSpecialPageName !== 'LinkEdit'
		)
		{
			if( document.getElementById( 'lf_title' ).value === '' ) {
				alert( mediaWiki.msg( 'linkfilter-submit-no-title' ) );
				return '';
			}
		}
		if( document.getElementById( 'lf_type' ).value === '' ) {
			alert( mediaWiki.msg( 'linkfilter-submit-no-type' ) );
			return '';
		}
		document.link.submit();
	},

	limitText: function( field, limit ) {
		if( field.value.length > limit ) {
			field.value = field.value.substring( 0, limit );
		}
		document.getElementById( 'desc-remaining' ).innerHTML = limit - field.value.length;
	}
};

jQuery( document ).ready( function() {
	// "Accept" links on Special:LinkApprove
	jQuery( 'a.action-accept' ).click( function() {
		var that = jQuery( this );
		LinkFilter.linkAction( 1, that.data( 'link-id' ) );
	} );

	// "Reject" links on Special:LinkApprove
	jQuery( 'a.action-reject' ).click( function() {
		var that = jQuery( this );
		LinkFilter.linkAction( 2, that.data( 'link-id' ) );
	} );

	// Textarea on Special:LinkEdit/Special:LinkSubmit
	jQuery( 'textarea.lr-input' ).bind( 'keyup', function() {
		LinkFilter.limitText( document.link.lf_desc, 300 );
	} ).bind( 'keydown', function() {
		LinkFilter.limitText( document.link.lf_desc, 300 );
	} );

	// Submit button on Special:LinkEdit/Special:LinkSubmit
	jQuery( '#link-submit-button' ).click( function() {
		LinkFilter.submitLink();
	} );
} );