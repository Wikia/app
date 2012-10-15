/**
 * JavasSript for Special:WatchlistConditions in the Semantic Watchlist extension.
 * @see http://www.mediawiki.org/wiki/Extension:Semantic_Watchlist
 * 
 * @licence GNU GPL v3 or later
 * @author Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function( $ ){ $.fn.watchlistcondition = function( group, options ) {

	var self = this;
	this.group = group;
	
	this.buildHtml = function() {
		this.html( $( '<legend />' ).text( group.name ) );
		
		var table = $( '<table />' ).attr( { 'class': 'swltable' } );
		
		propTd = $( '<td />' ).attr( {
			'rowspan': 2
		} );
		
		this.propsDiv = $( '<div />' );
		
		var addPropInput = $( '<input />' ).attr( {
			'type': 'text',
			'value': '',
			'size': 30,
			'class': 'swl-group-add-prop'
		} );
		
		var addButton = $( '<input />' ).attr( {
			'type': 'button',
			'value': mediaWiki.msg( 'swl-group-add-property' )
		} ).click( function() {
			var propName = addPropInput.val();
			
			if ( propName.trim() != '' ) {
				self.addPropertyDiv( propName );
				addPropInput.val( '' );
				addPropInput.focus();
			}
		} );
		
		addPropInput.keypress( function( event ) {
			if ( event.which == '13' ) {
				addButton.click();
			}
		} );
		
		propTd.html( mediaWiki.msg( 'swl-group-properties' ) )
			.append( this.propsDiv )
			.append( $( '<div />' ).html( addPropInput ).append( '&nbsp;' ).append( addButton ) );
		
		for ( i in group.properties ) {
			this.addPropertyDiv( group.properties[i] );
		}
		
		this.nameInput = $( '<input />' ).attr( {
			'type': 'text',
			'value': group.name,
			'size': 30
		} );
		
		this.nameInput.keyup( function() {
			self.find( 'legend' ).text( $( this ).val() );
		} );
		
		var nameTd = $( '<td />' ).html( $( '<p />' ).text( mediaWiki.msg( 'swl-group-name' ) + ' ' ).append( this.nameInput ) );
		table.append( $( '<tr />' ).html( nameTd ).append( propTd ) );
		
		var conditionValue, conditionType;
		
		switch ( true ) {
			case group.categories.length > 0:
				conditionValue = group.categories[0];
				conditionType = 'category';
				break;
			case group.namespaces.length > 0:
				conditionValue = group.namespaces[0];
				conditionType = 'namespace';
				break;
			case group.concepts.length > 0:
				conditionValue = group.concepts[0];
				conditionType = 'concept';
				break;
		}
		
		this.conditionTypeInput = $( '<select />' );
		var conditionTypes = [ 'category', 'namespace', 'concept' ];
		var conditionTypeGroups = [ 'categories', 'namespaces', 'concepts' ];
		
		for ( i in conditionTypes ) {
			var optionElement = $( '<option />' )
				.text( mediaWiki.msg( 'swl-group-' + conditionTypes[i] ) )
				.attr( { 'value': conditionTypes[i], 'type': conditionTypeGroups[i] } );
			
			if ( conditionType == conditionTypes[i] ) {
				optionElement.attr( 'selected', 'selected' );
			}
			
			this.conditionTypeInput.append( optionElement );
		}
		
		this.conditionNameInput = $( '<input />' ).attr( {
			'type': 'text',
			'value': conditionValue,
			'size': 30
		} );
		var conditionTd = $( '<td />' ).html( 
			$( '<p />' ).text( mediaWiki.msg( 'swl-group-page-selection' ) + ' ' )
			.append( this.conditionTypeInput )
			.append( '&nbsp;' )
			.append( this.conditionNameInput )
		);
		
		table.append( $( '<tr />' ).html( conditionTd ) );
		
		this.append( table );
		
		this.append(
			$( '<input />' ).attr( {
				'type': 'button',
				'value': mediaWiki.msg( 'swl-group-save' ),
				'class': 'swl-save'
			} ).click( function() {
				this.disabled = true;
				var button = this;
				
				self.doSave( function( success ) {
					if ( success ) {
						// TODO: indicate success?
					}
					else {
						alert( 'Could not update the watchlist group.' );
					}
					
					button.disabled = false;
				} );
			} )
		);
		
		this.append( '&nbsp;' );
		
		this.append(
			$( '<input />' ).attr( {
				'type': 'button',
				'value': mediaWiki.msg( 'swl-group-delete' )
			} ).click( function() {
				if ( confirm( mediaWiki.msg( 'swl-group-confirmdelete', self.nameInput.val() ) ) ) {
					this.disabled = true;
					var button = this;
					
					self.doDelete( function( success ) {
						if ( success ) {
							self.slideUp( 'fast', function() { self.remove(); } );
						}
						else {
							alert( 'Could not delete the watchlist group.' );
							button.disabled = false;
						}
					} );					
				}
			} )
		);
	};
	
	this.addPropertyDiv = function( property ) {
		var propDiv = $( '<div />' ).attr( 'class', 'propid' );

		var propInput = $( '<input />' ).attr( {
			'type': 'text',
			'value': property,
			'size': 30,
			'class': 'swl-group-prop'
		} );

		var removeButton = $( '<input />' ).attr( {
			'type': 'button',
			'value': mediaWiki.msg( 'swl-group-remove-property' )
		} );

		removeButton.click( function() {
			propDiv.remove();
		} );

		this.propsDiv.append( propDiv.html( propInput ).append( '&nbsp;' ).append( removeButton ) );
	};
	
	this.getProperties = function() {
		var props = [];
		
		this.find( '.swl-group-prop' ).each( function( index, domElement ) {
			props.push( $( domElement ).val() );
		} );
		
		return props;
	};
	
	this.doSave = function( callback ) {
		var args = {
			'action': 'editswlgroup',
			'format': 'json',
			'id': this.group.id,
			'name': this.nameInput.val(),
			'properties': this.getProperties().join( '|' )
		};
		
		args[this.conditionTypeInput.find( 'option:selected' ).attr( 'type' )] = this.conditionNameInput.val();
		
		$.getJSON(
			wgScriptPath + '/api.php',
			args,
			function( data ) {
				callback( data.success );
			}
		);
	};
	
	this.doDelete = function( callback ) {
		$.getJSON(
			wgScriptPath + '/api.php',
			{
				'action': 'deleteswlgroup',
				'format': 'json',
				'ids': this.group.id
			},
			function( data ) {
				callback( data.success );
			}
		);		
	};
	
	this.buildHtml();
	
	return this;
	
}; })( jQuery );