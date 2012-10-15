/*
 * JavaScript for PrefSwitch extension
 */

$(document).ready( function() {
	var client = $.client.profile();
	function detect() {
		// Detect browser
		var browser = 'other';
		switch ( client.name ) {
			case 'msie':
				var v = parseInt( client.versionNumber );
				// IE8 supports Document mode while IE7 does not support it - other versions don't lie about their age
				browser = ( v == 7 ? ( document.documentMode ? 'ie8' : 'ie7' ) : 'ie' + v );
				break;
			case 'firefox': browser = 'ff' + parseInt( client.versionNumber ); break;
			case 'chrome': browser = 'c' + parseInt( client.versionNumber ); break;
			case 'safari': browser = 's' + parseInt( client.versionNumber ); break;
			case 'opera':
				if ( parseInt( client.versionNumber ) == 9 ) {
					if ( client.version.substr( 0, 3 ) == '9.5' ) {
						browser = 'o9.5';
					} else {
						browser = 'o9';
					}
				} else if ( parseInt( client.versionNumber ) == 10 ) {
					browser = 'o10';
				}
				break;
		}
		// Detect operating system
		var platform = 'other';
		switch ( client.platform ) {
			case 'win': platform = 'windows'; break;
			case 'mac': platform = 'macos'; break;
			case 'linux': platform = 'linux'; break;
		}
		switch ( client.name ) {
			case 'iemobile': platform = 'windowsmobile'; break;
			case 'iphone': platform = 'iphoneos'; break;
			case 'ipod': platform = 'iphoneos'; break;
			case 'ipad': platform = 'iphoneos'; break;
		}
		return {
			'survey-browser': browser, 'survey-os': platform, 'survey-res-x': screen.width, 'survey-res-y': screen.height
		};
	}
	// Auto-hide/show "other" explanation fields for selects
	$( '.prefswitch-survey-other-select' ).parent().hide();
	$( 'select.prefswitch-survey-need-other' ).change( function() {
		if ( $(this).val() == 'other' ) {
			$( '#' + $(this).attr( 'id' ) + '-other' ).parent().slideDown( 'fast' );
		} else {
			$( '#' + $(this).attr( 'id' ) + '-other' ).parent().slideUp( 'fast' );
		}
	});
	// Auto-select the check or radio next to an "other" explaination on click
	$( '.prefswitch-survey-other-radios, .prefswitch-survey-other-checks' ).click( function() {
		$(this).prev().prev().attr( 'checked', true );
	});
	// Auto-hide/show explanation fields for boolean
	$( '.prefswitch-survey-iftrue, .prefswitch-survey-iffalse' ).hide();
	$( '.prefswitch-survey-true, .prefswitch-survey-false' ).change( function() {
		$ifTrueRow = $( '#' + $(this).attr( 'name' ) + '-iftrue-row' );
		$ifFalseRow = $( '#' + $(this).attr( 'name' ) + '-iffalse-row' );
		if ( $(this).is( '.prefswitch-survey-true:checked' ) ) {
			$ifTrueRow.slideDown( 'fast' );
			$ifFalseRow.slideUp( 'fast' );
		} else if ( $(this).is( '.prefswitch-survey-false:checked' ) ) {
			$ifTrueRow.slideUp( 'fast' );
			$ifFalseRow.slideDown( 'fast' );
		}
	} );
	$( '.prefswitch-survey-true, .prefswitch-survey-false' ).change();
	// Auto-detect browser, os and screen size
	var detected = detect();
	$( '#prefswitch-survey-browser' ).val( detected['survey-browser'] );
	$( '#prefswitch-survey-os' ).val( detected['survey-os'] );
	if ( detected['survey-res-x'] && detected['survey-res-y'] ) {
		$( '#prefswitch-survey-res-x' ).val( detected['survey-res-x'] );
		$( '#prefswitch-survey-res-y' ).val( detected['survey-res-y'] );
	}
});
