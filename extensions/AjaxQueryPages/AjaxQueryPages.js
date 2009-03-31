var wgAjaxQueryPages = {};

wgAjaxQueryPages.inprogress = false;

wgAjaxQueryPages.onLoad = function() {
	wgAjaxQueryPages.replacelinks( document );
}

wgAjaxQueryPages.replacelinks = function( target ) {
	var elsPrev = getElementsByClassName(target, "a", "mw-prevlink");
	var elsNext = getElementsByClassName(target, "a", "mw-nextlink");
	var elsNums = getElementsByClassName(target, "a", "mw-numlink");
	var els = elsPrev.concat( elsNext, elsNums );

	var reoff = /offset=([^&]+)/ ;
	var relim = /limit=(\d+)/ ;
	var redir = /dir=(prev|next)/ ;

	var nEls = els.length ;
	for (var i=0; i<nEls;i++) {
		var href = els[i].getAttribute("href") ;

		var offset = ''; var limit='';
		if( reoff.test(href) ) { offset = reoff.exec( href )[1];}
		if( relim.test(href) ) { limit  = relim.exec( href )[1]; }

		var jsparams = "'" + offset + "'," + limit

		if( redir.test(href) ) {
			var prevdir = redir.exec( href )[1];
			jsparams += ",'" + prevdir + "'"
		}

		els[i].setAttribute("href", "javascript:wgAjaxQueryPages.call(" + jsparams + ")");
	}
}

wgAjaxQueryPages.call = function( offset, limit, dir ) {
	if( wgAjaxQueryPages.inprogress )
		return;
	wgAjaxQueryPages.inprogress = true;

	sajax_do_call(
		"wfAjaxQueryPages",
		[wgCanonicalSpecialPageName, offset, limit, dir],
		wgAjaxQueryPages.processResult
		);
	// Reallow request if it is not done in 2 seconds
	wgAjaxQueryPages.timeoutID = window.setTimeout( function() { wgAjaxQueryPages.inprogress = false; }, 2000);

}

html2dom = function( html ) {
	var ret = document.createDocumentFragment();
	var tmp = document.createElement("div");
	tmp.innerHTML = html

	while( tmp.firstChild ) {
		ret.appendChild( tmp.firstChild );
	}
	return ret;
}

wgAjaxQueryPages.processResult = function(request) {
	// convert html to dom, need to merge branches/hashar@21917 to use the responseXML
	var response = html2dom( request.responseText );
	var spcontent = getElementsByClassName(document, "div", "mw-spcontent");
	wgAjaxQueryPages.replacelinks( response.firstChild );

	spcontent[0].innerHTML = response.firstChild.innerHTML ;

	wgAjaxQueryPages.inprogress = false;
}

hookEvent( "load", wgAjaxQueryPages.onLoad );
