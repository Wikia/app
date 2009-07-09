var NewWikiBuilder = {

};	      

NewWikiBuilder.handleError = function(e){
	// TODO: More graceful handling
	alert(Mediawiki.print_r(e));
};

NewWikiBuilder.iframeFormUpload = function(iframe){
	var d;
	// Different browsers have different ways of getting the iframe's document
	if (iframe.contentDocument) {
		d = iframe.contentDocument;
	} else if (iframe.contentWindow) {
		d = iframe.contentWindow.document;
	} else {
		d = window.frames[iframe.id].document;
	}

	// Bail if it loaded
	if (d.location.href == "about:blank") {
		return;
	}

	Mediawiki.updateStatus('Image Uploaded');

	// Fill in the preview or the current depending on what was clicked
	var url;
	if ($("#logo_article").val() == "Wiki-Preview.png"){
		url = Mediawiki.getImageUrl("Wiki-Preview.png") + '?' + Math.random();
		$("#logo_preview").css("backgroundImage", "url(" + url + ")");
	} else {
		url = Mediawiki.getImageUrl("Wiki.png") + '?' + Math.random();
		$("#logo_current").css("backgroundImage", "url(" + url + ")");
	}
};

NewWikiBuilder.updateStatus = Mediawiki.updateStatus;
