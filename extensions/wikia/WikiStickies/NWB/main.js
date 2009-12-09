
var NWB = {
	"language":		"en", // default
	"firstPagesBlocks" :	1,
	"currentStep":		null,
	"linkTag":		false,
	"statusTimeout": 	5000
};

NWB.apiFailed = function(reqObj, msg, error){
	Mediawiki.waitingDone();
	if (typeof msg == "object"){
		msg = Mediawiki.print_r(msg);
	}
	alert(NWB.msg("nwb-api-error") + Mediawiki.print_r(msg));
};

NWB.showStep = function(stepName) {
	$("#progress li").removeClass("selected");
	$("[id=progress_"+stepName+"]").addClass("selected");
	NWB.currentStep = stepName;
};

//There is no back button click event. This checks the URL and sets the correct step.
NWB.checkStep = function(firstStep) {
	window.setInterval(function() {
		var url = document.location.toString();
		var urlAnchor = firstStep;
		if (url.match("#")) {
			urlAnchor = url.split('#')[1];
		}
		if (NWB.currentStep != urlAnchor) {
			NWB.showStep(urlAnchor);
		}
	}, 200);
};

/* 1. Change the stylesheet on the current page 
 * 2. Save the value using the API
 */
NWB.changeTheme = function (theme, changeData){
    try {
        // Save the changes using the API
        if (theme != window.wgAdminSkin && changeData ) {
		Mediawiki.waiting();
                Mediawiki.apiCall({
                        "action" : "foundersettings",
                        "changesetting" : "wgAdminSkin", 
                        "value" : theme},
			function(result) { 
				Mediawiki.waitingDone();
				var cresult = Mediawiki.checkResult(result);
				if (cresult !== true) {
					NWB.apiFailedr(NWB.msg("nwb-error-saving-theme") + cresult, true);
				} else if (result.settings == "success") {
					Mediawiki.updateStatus(NWB.msg("nwb-theme-saved"), false, NWB.statusTimeout);
				} else {
					NWB.apiFailed(null, result, null);
				}
			}, NWB.apiFailed, "POST");
                window.wgAdminSkin = theme;
        } 

        // Create a link object for the stylesheet
	var ltheme = theme.replace(/monaco-/, '').toLowerCase();
	var href = "/skins/monaco/" + ltheme + "/css/main.css";
	WIKIA.WikiStickies.track( '/admin/' + ltheme );
	if (typeof NWB.linkTag == "object") {
		NWB.linkTag.remove();
       	}
	NWB.linkTag = $( '<link rel="stylesheet" type="text/css" href="' + href + '" />' );
	$("head:first").append(NWB.linkTag);


   } catch (e) {
	Mediawiki.waitingDone();
        Mediawiki.updateStatus(NWB.msg("nwb-error-saving-theme"), true);
        Mediawiki.debug(Mediawiki.print_r(e));
   }
};

/* Wrap up and redirect them to their wiki */
NWB.finalize = function (redir){
	/* Issue a purge request */
        Mediawiki.updateStatus(NWB.msg("nwb-finalizing"));
	Mediawiki.waiting();
        var mainPageEnd = Mediawiki.followRedirect(wgMainpage, false); // Should be cached.
        var result = Mediawiki.apiCall({
		"action" : "purge",
		"titles" : mainPageEnd});

	// Redirect
	window.location = 'http://' + document.domain + '/wiki/' + mainPageEnd;
};


//Call this function when the page doesn't properly lay out after performing a dynamic action
NWB.reflow = function() {
	$("body").addClass("reflow");
	$("body").removeClass("reflow");
};

NWB.msg = function (msg){
	var ret;
	try {
		ret = NWB.messages[NWB.language][msg];
	} catch(e) {
		ret = msg;
	}
	return ret;
};


NWB.iframeFormUpload = function(iframe){
   try {
	var d, xml, xmlString;
	// Different browsers have different ways of getting the iframe's document
	if (iframe.contentDocument) {
		d = iframe.contentDocument;
	} else if (iframe.contentWindow) {
		d = iframe.contentWindow.document;
	} else {
		d = window.frames[iframe.id].document;
	}

	// Bail if it isn't loaded yet
	if (d.location.href == "about:blank") {
		return;
	}

	// Use jquery to process the xml inside the iframe
	var error = $("#" + iframe.id).contents().find("error").attr("info");
	if (!Mediawiki.e(error)){
		Mediawiki.updateStatus(NWB.msg("nwb-error-saving-logo") + " " + error, true);
		Mediawiki.d("Upload error: " + error);
		return;
	} 

	Mediawiki.updateStatus(NWB.msg("nwb-logo-uploaded"), false, NWB.statusTimeout);

	// Fill in the preview or the current depending on what was clicked
	var url;
	if ($("#logo_article").val() == "Wiki-Preview.png"){
		url = Mediawiki.getImageUrl("Wiki-Preview.png") + '?' + Math.random();
		$("#logo_preview").css("backgroundImage", "url(" + url + ")");
		$("#logo_preview_wrapper").show();
	} else {
		url = Mediawiki.getImageUrl("Wiki.png") + '?' + Math.random();
		$("#wiki_logo").css("backgroundImage", "url(" + url + ")");
	}
   	Mediawiki.waitingDone();

     } catch (e) {
         Mediawiki.updateStatus(NWB.msg("nwb-error-saving-logo"), true);
         Mediawiki.debug(Mediawiki.print_r(e)); 
     }
};


NWB.iframeFormInit = function (f){
	if (Mediawiki.e(f.logo_file.value)){
		Mediawiki.updateStatus(NWB.msg("nwb-choose-a-file"), true);
		return false;
	}

	Mediawiki.updateStatus(NWB.msg("nwb-uploading-logo"), false, 30000);
   	Mediawiki.waiting();
	return true;
};
        
NWB.parseXml = function (xml) {
	if( window.ActiveXObject && window.GetObject ) { 
		// MS
		var dom = new window.ActiveXObject( 'Microsoft.XMLDOM' );
		dom.loadXML( xml );
		return dom;
	} else if ( window.DOMParser ) {
		// W3C
		return new window.DOMParser().parseFromString( xml, 'text/xml' );
	} else {
		throw ( 'No XML parser available' ); 
	}
};


NWB.updateStatus = Mediawiki.updateStatus;

NWB.uploadLogo = function (){
	var f=document.getElementById('logo_form');
	if (NWB.iframeFormInit(f)){
		f.title.value='Wiki.png';
		f.submit();
	}
};
