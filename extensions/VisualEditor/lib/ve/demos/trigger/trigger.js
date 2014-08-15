/*!
 * VisualEditor trigger demo
 *
 * @copyright 2011-2014 VisualEditor Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */

function setTrigger( trigger ) {
	var i, len, key,
		parts = trigger.split( '+' );
	trigger = trigger.toString();
	$( '#trigger' ).text( trigger );
	for ( i = 0, len = parts.length; i < len; i++ ) {
		key = parts[i].replace( '\\', '\\\\' ).replace( '"', '\\"' );
		$( '.key[rel="' + key + '"]' ).addClass( 'active' );
	}
}

// Initialiation

var i, len, key,
	$primary = $( '#primary' ),
	$modifiers = $( '#modifiers' ),
	$aliases = $( '#aliases' ),
	primaryKeys = ve.ui.Trigger.static.primaryKeys,
	modifierKeys = ve.ui.Trigger.static.modifierKeys,
	keyAliases = ve.ui.Trigger.static.keyAliases;

for ( i = 0, len = modifierKeys.length; i < len; i++ ) {
	$modifiers.append(
		$( '<li>' ).append(
			$( '<span class="key"></span>' )
				.text( modifierKeys[i] )
				.attr( 'rel', modifierKeys[i] )
		)
	);
}
for ( i = 0, len = primaryKeys.length; i < len; i++ ) {
	$primary.append(
		$( '<li>' ).append(
			$( '<span class="key"></span>' )
				.text( primaryKeys[i] )
				.attr( 'rel', primaryKeys[i] )
		)
	);
}
for ( key in keyAliases ) {
	$aliases.append(
		$( '<li>' )
			.append( $( '<span class="key alias"></span>' ).text( key ) )
			.append( '⇢' )
			.append( $( '<span class="key"></span>' ).text( keyAliases[key] ) )
	);
}

// Events

$( 'body' ).on( {
	'keydown': function ( e ) {
		$( '.active' ).removeClass( 'active' );
		setTrigger( new ve.ui.Trigger( e ) );
		e.preventDefault();
	}
} );
$( '#primary .key, #modifiers .key' ).on( {
	'mousedown': function ( e ) {
		var $target = $( e.target );
		if ( e.which === 1 ) {
			if ( $target.closest( '#primary' ).length ) {
				$primary.find( '.active' ).removeClass( 'active' );
			}
			if ( !$target.hasClass( 'active' ) ) {
				$target.addClass( 'active activating' );
			}
		}
	},
	'mouseup': function ( e ) {
		var parts = [],
			$target = $( e.target );
		if ( e.which === 1 ) {
			if ( $target.hasClass( 'active' ) && !$target.hasClass( 'activating' ) ) {
				$target.removeClass( 'active' );
			}
			$target.removeClass( 'activating' );
			$( '.active' ).each( function () {
				parts.push( $(this).attr( 'rel' ) );
			} );
			setTrigger( new ve.ui.Trigger( parts.join( '+' ) ) );
		}
	}
} );
