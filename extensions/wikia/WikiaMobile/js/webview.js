(function(context){
	var page = document.getElementById('wkMainCntHdr' ),
		isInWebview = (
			/(Android.*Version.*Chrome)|((iPhone|iPod|iPad).*AppleWebKit(?!.*Safari))/i
		).test(
			context.navigator.userAgent
		);

	if ( isInWebview && page ) {
		context.scrollTo( 0, page.offsetTop );
	}
})(this);
