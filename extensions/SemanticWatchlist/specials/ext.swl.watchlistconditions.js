/**
 * JavasSript for Special:WatchlistConditions in the Semantic Watchlist extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Watchlist
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function($) { $( document ).ready( function() {
	
	function getSplitAttrValue( element, attribute, separator ) {
		if ( typeof element.attr( attribute ) == 'undefined'
			|| element.attr( attribute ) == '' ) {
			return [];
		}
		
		return element.attr( attribute ).split( separator );
	}
	
	function initGroupElement( element ) {
		element.watchlistcondition(
			{
				name: element.attr( 'groupname' ),
				id: element.attr( 'groupid' ),
				categories: getSplitAttrValue( element, 'categories', '|' ),
				namespaces: getSplitAttrValue( element, 'namespaces', '|' ),
				properties: getSplitAttrValue( element, 'properties', '|' ),
				concepts: getSplitAttrValue( element, 'concepts', '|' )
			},
			{}
		);		
	}
	
	$( '.swl_group' ).each(function( index, domElement ) {
		initGroupElement( $( domElement ) );
	});
	
	$( '#swl-save-all' ).click( function() {
		$( '.swl-save' ).click();
	} );
	
	function addGroupToDB( groupName, callback ) {
		$.getJSON(
			wgScriptPath + '/api.php',
			{
				'action': 'addswlgroup',
				'format': 'json',
				'name': groupName,
				'properties': ''
			},
			function( data ) {
				callback( data.success, data.group );
			}
		);
	}
	
	function addGroupToGUI( groupName, groupId ) {
		var newGroup = $( '<fieldset />' ).attr( {
			'id': 'swl_group_' + groupId,
			'groupid': groupId,
			'class': 'swl_group',
			'groupname': groupName,
			'categories': '',
			'namespaces': '',
			'properties': '',
			'concepts': ''
		} )
		.html( $( '<legend />' ).text( groupName ) );
		
		$( '#swl-groups' ).append( newGroup );
		
		initGroupElement( newGroup );
	}
	
	$( '#swl-add-group-button' ).click( function() {
		var input = $( '#swl-add-group-name' );
		var button = this;
		
		button.disabled = true;
		input.disabled = true;
		
		addGroupToDB( input.val(), function( success, group ) {
			if ( success ) {
				addGroupToGUI( group.name, group.id );
				input.val( '' );
			}
			else {
				alert( 'Could not add the group.' );
			}
			
			button.disabled = false;
			input.disabled = false;
		} );
	} );
	
	$( '#swl-add-group-name' ).keypress( function( event ) {
		if ( event.which == '13' ) {
			$( '#swl-add-group-button' ).click();
		}
	} );
	
} ); })(jQuery);