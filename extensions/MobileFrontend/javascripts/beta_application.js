var search = document.getElementById( 'search' );
var clearSearch = document.getElementById( 'clearsearch' );
var results = document.getElementById( 'results' );
var languageSelection = document.getElementById( 'languageselection' );

var zeroRatedBanner = document.getElementById( 'zero-rated-banner' );

if ( !zeroRatedBanner ) {
	var zeroRatedBanner = document.getElementById( 'zero-rated-banner-red' );
}

initClearSearchLink();

function initClearSearchLink() {
	clearSearch.setAttribute( 'title','Clear' );
	clearSearch.addEventListener( 'mousedown', clearSearchBox, true );
	search.addEventListener( 'keyup', handleClearSearchLink, false );
	search.addEventListener( 'keydown', handleDefaultText, false );
}

search.onpaste = function() {
	handleDefaultText();
};

function navigateToLanguageSelection() {
	var url;
	if ( languageSelection ) {
		url = languageSelection.options[languageSelection.selectedIndex].value;
		if ( url ) {
			location.href = url;
		}
	}
}

function handleDefaultText() {
	var pE = document.getElementById( 'placeholder' );
	if ( pE ) {
		pE.style.display = 'none';
	}
}

function handleClearSearchLink() {
	if ( clearSearch ) {
		if ( search.value.length > 0 ) {
			clearSearch.style.display = 'block';
		} else {
			clearSearch.style.display = 'none';
		}
	}
}

function clearSearchBox( event ) {
	search.value = '';
	clearSearch.style.display = 'none';
	if ( event ) {
		event.preventDefault();
	}
}

function logoClick() {
	var n = document.getElementById( 'nav' ).style;
	n.display = n.display == 'block' ? 'none' : 'block';
	if (n.display == 'block') {
		if ( languageSelection ) {
			if ( languageSelection.offsetWidth > 175 ) {
				var newWidth = languageSelection.offsetWidth + 30;
				n.width = newWidth + 'px';
			}
		}
	}
};

for ( var a = document.getElementsByTagName( 'a' ), i = 0; i < a.length; i++ ) {
	a[i].onclick = function() {
		if ( this.hash.indexOf( '#' ) == 0 ) {
			wm_reveal_for_hash( this.hash );
		}
	}
}

if ( document.location.hash.indexOf( '#' ) == 0 ) {
	wm_reveal_for_hash( document.location.hash );
}

updateOrientation();

// Try to scroll and hide URL bar
window.scrollTo( 0, 1 );

/**
 * updateOrientation checks the current orientation, sets the body's class
 * attribute to portrait, landscapeLeft, or landscapeRight,
 * and displays a descriptive message on "Handling iPhone or iPod touch Orientation Events".
 */
function updateOrientation() {
	switch( window.orientation ) {
		case 0:
			document.body.setAttribute( 'class', 'portrait' );
			break;
		case 90:
		case -90:
			document.body.setAttribute( 'class', 'landscape' );
  }
}

// Point to the updateOrientation function when iPhone switches between portrait and landscape modes.
window.onorientationchange = updateOrientation;

function wm_reveal_for_hash( hash ) {
	var targetel = document.getElementById( hash.substr(1) );
	if ( targetel ) {
		for (var p = targetel.parentNode; p && p.className != 'content_block' && p.className != 'section_heading'; ) {
			p = p.parentNode;
		}
		if ( p && p.style.display != 'block' ) {
			var section_idx = parseInt( p.id.split( '_' )[1] );
			wm_toggle_section( section_idx );
		}
	}
}

function wm_toggle_section( section_id ) {
	var b = document.getElementById( 'section_' + section_id ),
		bb = b.getElementsByTagName( 'button' );
	for ( var i = 0; i <= 1; i++ ) {
		var s = bb[i].style;
		s.display = s.display == 'none' || ( i && !s.display ) ? 'inline-block' : 'none';
	}
	for ( var i = 0, d = ['content_','anchor_']; i<=1; i++ ) {
		var e = document.getElementById( d[i] + section_id );
		
		if ( e ) {
			e.style.display = e.style.display == 'block' ? 'none' : 'block';
		}
	}
}

function writeCookie( name, value, days ) {
	if ( days ) {
		var date = new Date();
		date.setTime( date.getTime() + ( days * 24 * 60 * 60 *1000 ) );
		var expires = '; expires=' + date.toGMTString();
	} else {
		var expires = '';
	}
	document.cookie = name + '=' + value + expires + '; path=/';
}

function readCookie( name ) {
	var nameVA = name + '=';
	var ca = document.cookie.split( ';' );
	for( var i=0; i < ca.length; i++ ) {
		var c = ca[i];
		while ( c.charAt(0) === ' ' ) {
			c = c.substring( 1, c.length );
		}
		if ( c.indexOf( nameVA ) == 0 ) {
			return c.substring( nameVA.length, c.length );
		}
	}
	return null;
}

function removeCookie( name ) {
	writeCookie( name, '', -1 );
	return null;
}

var dismissNotification = document.getElementById( 'dismiss-notification' );

if ( dismissNotification ) {
	var cookieNameZeroVisibility = 'zeroRatedBannerVisibility';
	var zeroRatedBanner = document.getElementById( 'zero-rated-banner' );
	var zeroRatedBannerVisibility = readCookie( cookieNameZeroVisibility );
	
	if ( zeroRatedBannerVisibility === 'off' ) {
		zeroRatedBanner.style.display = 'none';
	}
	
	dismissNotification.onclick = function() {
		if ( zeroRatedBanner ) {
			zeroRatedBanner.style.display = 'none';
			writeCookie( cookieNameZeroVisibility, 'off', 1 );
		}
	};
}