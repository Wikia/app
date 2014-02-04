(function(context){
	var topbar = context.document.getElementById( 'wkTopNav' );

	if (
		//Check if we have topbar to hide
		topbar &&
		//Check if we're in webview
		(/(Android.*Version.*Chrome)|((iPhone|iPod|iPad).*AppleWebKit(?!.*Safari))/i ).test( context.navigator.userAgent ) &&
		//Check if user has not scrolled page already
		context.scrollY === 0
	) {
		//Scroll it by height of topbar
		context.scrollBy( 0, topbar.scrollHeight );
	}
})( window );
