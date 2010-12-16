/* JavaScript for OptIn extension */

function optInGetPOSTData() {
	// Detect browser
	var browserIndex = 'other';
	switch ( $j.browser.name ) {
		case 'msie':
			if ( parseInt( $j.browser.versionNumber ) == 7 ) {
				// IE7 or IE8 compat mode
				if( document.documentMode ) {
					// IE8 supports Document mode
					browserIndex = 'ie8';
				} else {
					// while IE7 does not support it
					browserIndex = 'ie7';
				}
			} else {
				// other versions
				browserIndex = 'ie'+ parseInt( $j.browser.versionNumber );
			}
		break;
		case 'firefox':
			browserIndex = 'ff' + parseInt( $j.browser.versionNumber );
		break;
		case 'chrome':
			// FIXME: Chrome Alpha/Beta?
			browserIndex = 'c' + parseInt( $j.browser.versionNumber );
		break;
		case 'safari':
			browserIndex = 's' + parseInt( $j.browser.versionNumber );
		break;
		case 'opera':
			if ( parseInt( $j.browser.versionNumber ) == 9 ) {
				if ( $j.browser.version.substr( 0, 3 ) == '9.5' )
					browserIndex = 'o9.5';
				else
					browserIndex = 'o9';
			} else if ( parseInt( $j.browser.versionNumber ) == 10 )
				browserIndex = 'o10';
		break;
	}
	// Detect operating system
	var osIndex = 'other';
	switch ( $j.os.name ) {
		case 'win':
			osIndex = 'windows';
		break;
		case 'mac':
			osIndex = 'macos';
		break;
		case 'linux':
			osIndex = 'linux';
		break;
	}
	switch ( $j.browser.name ) {
		case 'iemobile':
			osIndex = 'windowsmobile';
		break;
		case 'iphone':
			osIndex = 'iphoneos';
		break;
		case 'ipod':
			osIndex = 'iphoneos';
		break;
	}
	return { 'survey-browser': browserIndex, 'survey-os': osIndex,
		'survey-res-x': screen.width, 'survey-res-y': screen.height,
		'opt': 'browser' };
}

$j(document).ready( function() {
	$j( '.optin-other-select' ).parent().hide();
	$j( 'select.optin-need-other' ).change( function() {
		if( $j(this).val() == 'other' )
			$j( '#' + $j(this).attr( 'id' ) + '-other' ).parent().slideDown( 'fast' );
		else
			$j( '#' + $j(this).attr( 'id' ) + '-other' ).parent().slideUp( 'fast' );
	});
	$j( '.optin-other-radios, .optin-other-checks' ).click( function() {
		$j(this).prev().prev().attr( 'checked', true );
	});
	$j( '.survey-ifyes, .survey-ifno' ).hide();
	$j( '.survey-yes, .survey-no' ).change( function() {
		yesrow = $j( '#' + $j(this).attr( 'name' ) + '-ifyes-row' );
		norow = $j( '#' + $j(this).attr( 'name' ) + '-ifno-row' );
		if( $j(this).is( '.survey-yes:checked' ) ) {
			yesrow.slideDown( 'fast' );
			norow.slideUp( 'fast' );
		} else if( $j(this).is( '.survey-no:checked' ) ) {
			yesrow.slideUp( 'fast' );
			norow.slideDown( 'fast' );
		}
	});
	// Load initial state
	$j( '.survey-yes, .survey-no' ).change();
	
	var detected = optInGetPOSTData();
	$j( '#survey-browser' ).val( detected['survey-browser'] );
	$j( '#survey-os' ).val( detected['survey-os'] );
	// Detect screen dimensions
	if ( detected['survey-res-x'] && detected['survey-res-y'] ) {
		$j( '.optin-resolution-x' ).val( detected['survey-res-x'] );
		$j( '.optin-resolution-y' ).val( detected['survey-res-y'] );
	}
});
