var apiUrl = '/api.php';

if ( scriptPath ) {
	apiUrl = scriptPath + apiUrl;	
}

var timer = -1;
var typingDelay = 500;
var numResults = 5;
var pixels = 'px';

var results = document.getElementById( 'results' );
var search = document.getElementById( 'search' );
var sq = document.getElementById( 'sq' );
var sb = document.getElementById( 'searchbox' );

function hideResults() {
	results.style.display = 'none';
}

document.body.onmousedown = function( event ) {
	whichElement(event);
}
results.onmousedown = function( event ) {
	whichElement(event);
}

document.body.ontouchstart = function( event ) {
	whichElement(event);
}
results.ontouchstart = function( event ) {
	whichElement(event);
}

function whichElement( e ) { 
	var targ;
	if ( !e ) {
		var e = window.event;
	}
	if ( e.target ) {
		targ = e.target;
	} else if ( e.srcElement ) {
		targ = e.srcElement;
	}
	
	if ( targ.nodeType == 3 ) {
		targ = targ.parentNode;
	}
	
	e.cancelBubble = true;
	e.stopPropagation();
	
	if ( targ.className == "suggestion-result" || 
		 targ.className == "search-result-item" || 
		 targ.className == "suggestions-result" ||
		 targ.className == "sq-val-update" ) {
	} else {
		hideResults();
	}
}

function updateSearchWidth() {
	if ( sq && search && sb ) {
		var iw = ( document.documentElement.clientWidth ) ? document.documentElement.clientWidth : document.body.clientWidth;
		sb.style.width = ( iw - 30 ) + pixels;
		sq.style.width = ( iw - 110 ) + pixels;
		search.style.width = ( iw - 130 ) + pixels;
		if ( results ) {
			results.style.width = ( sq.offsetWidth - 2 ) + pixels;
			results.style.left = sq.offsetLeft + pixels;
			results.style.top = ( sq.offsetTop + sq.offsetHeight )	+ pixels;
		}
	}
}

updateSearchWidth();

function updateOrientationSearchWidth() {
	switch( window.orientation ) {
		case 0:
		case -90:
		case 90:
		case 180:
			setTimeout( updateSearchWidth, 200 );
			break;
  }
}

// Point to the updateOrientation function when iPhone switches between portrait and landscape modes.
window.onorientationchange = updateOrientationSearchWidth;

window.onload = function () {
	search.addEventListener( 'keyup',
		function() {
			clearTimeout( timer );
			var term = this.value;
			if ( term.length < 1 ) {
				results.innerHTML = '';
			} else {
				timer = setTimeout( function () { searchApi( term ); }, typingDelay );
			}
		}, false );
}

function searchApi( term ) {
	var xmlHttp;
	if ( window.XMLHttpRequest ) {
		xmlHttp = new XMLHttpRequest();
	} else {
		xmlHttp = new ActiveXObject( 'Microsoft.XMLHTTP' );
	}
	xmlHttp.overrideMimeType( 'text/xml' );
	xmlHttp.onreadystatechange = function() {
		if ( xmlHttp.readyState == 4 && xmlHttp.status == 200 ) {
			var sections = createObjectArray( xmlHttp.responseXML );
			writeResults( sections );
		}
	}
	term = encodeURIComponent( term );
	var url = apiUrl + '?action=opensearch&limit=' + numResults + '&namespace=0&format=xml&search=' + term;
	xmlHttp.open( 'GET', url, true );
	xmlHttp.send();
}

function createObjectArray( responseXml ) {
	var sections = new Array();
	var items = responseXml.getElementsByTagName( 'Item' );
	for ( i = 0; i < items.length; i++ ) {
		var item = items[i];
		var section = {
			label: item.getElementsByTagName( 'Text' )[0].textContent,
			value: item.getElementsByTagName( 'Url' )[0].textContent,
		}
		sections.push( section );
	}
	return sections;
}

function sqValUpdate( sqValue ) {
	if ( search ) {
		search.value = sqValue + ' ';
		search.focus();
		searchApi( search.value );
	}
}

function htmlEntities( str ) {
    return String( str ).replace( /&/g, '&amp;' ).replace( /</g, '&lt;' ).replace( />/g, '&gt;' ).replace( /"/g, '&quot;' ).replace( /'/g, '&#39;' );
}

function escapeJsString( str ) {
	return String( str ).replace( /\\/g, '\\\\' ).replace( /'/g, "\\'" ).replace( /\n/g, '\\n' );
}

function writeResults( sections ) {
		results.style.display = 'block';
	if ( !sections || sections.length < 1 ) {
		results.innerHTML = "No results";
	} else {		
		var html = '<div class="suggestions-results">';
		for ( i = 0; i < sections.length; i++ ) {
			var section = sections[i];
			var rel = i + 1;
			section.value = section.value.replace( /^(?:\/\/|[^\/]+)*\//, '/' );
			html = html + "<div class=\"suggestions-result\" rel=\"" + htmlEntities( rel ) + "\" title=\"" + htmlEntities( section.label ) + "\"><a class=\"sq-val-update\" href=\"javascript:sqValUpdate('" + htmlEntities( escapeJsString( section.label ) ) + "');\">+</a><a class=\"search-result-item\" href='" + htmlEntities( section.value ) + "'>" + htmlEntities( section.label ) + "</a></div>";
		}
		html = html + '</div>';
		results.innerHTML = html;
	}
}