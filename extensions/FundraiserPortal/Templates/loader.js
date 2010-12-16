function toggleFundraiserPortal() {
	fundraiserPortalToggleState = !fundraiserPortalToggleState;
	setFundraiserPortalCookie( fundraiserPortalToggleState );
	updateFundraiserPortal();
}
function updateFundraiserPortal() {
	var portal = document.getElementById( 'p-DONATE' );
	if ( !fundraiserPortalToggleState ) {
		portal.className = portal.className.replace( 'collapsed', '' );
	} else {
		portal.className += ' collapsed';
	}
}
function setFundraiserPortalCookie( state ) {
	// Store cookie so portal is hidden for three weeks
	var e = new Date();
	e.setTime( e.getTime() + ( 21 * 24 * 60 * 60 * 1000 ) );
	var work = 'hidefrportal=' + ( state ? 1 : 0 ) + '; expires=' + e.toGMTString() + '; path=/';
	document.cookie = work;
}
function getFundraiserPortalCookie() {
	return ( document.cookie.indexOf( 'hidefrportal=1' ) !== -1 );
}
var fundraiserPortalToggleState = getFundraiserPortalCookie();
addOnloadHook(function() {
	if (wgFundraiserPortalCSS != '') {
		appendCSS(wgFundraiserPortalCSS);
	}
	if (wgFundraiserPortal != '') {
		var logo = document.getElementById('p-logo');
		if (logo) {
			var div = document.createElement('div');
			div.id = "p-DONATE";
			div.className = "portlet";
			if (fundraiserPortalToggleState)
				div.className += ' collapsed';
			div.innerHTML = '<div class="body pBody">' + wgFundraiserPortal + '</div>';
			logo.parentNode.insertBefore(div, logo.nextSibling);
		}
	}
});
