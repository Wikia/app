$(function() {
	var url = document.location.toString();
	var firstStep = $(".step:first").attr("id");
	var urlAnchor = firstStep;
	if (url.match("#")) {
		urlAnchor = url.split('#')[1];
	}
	NWB.showStep(urlAnchor);

	$(".step a").click(function() {
		if (this.href.match("#")) {
			NWB.showStep(this.href.split('#')[1]);
		}
	});
	NWB.checkStep(firstStep);

	$("#step1_form").submit(NWB.handleDescriptionForm);
	$("#step4_form").submit(NWB.handleFirstPages);
});

var wgDefaultTheme = 'slate'; // TODO don't use hardcoded value, use it from Mediawiki

var NWB = {
	"language": "en", // TODO: Pull this from the browser or users settings
	"descriptionSection" : 1,
	"firstPagesBlocks" : 1,
	"currentStep": null
};


NWB.apiFailed = function(msg){
	alert(NWB.msg("api-error") + msg);
};

NWB.showStep = function(stepName) {
	$(".step").hide();
	$("[id="+stepName+"]").show();
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

NWB.gotostep = function(step) {
	var current = document.location.toString();
	var url = current.split('#')[0];
	document.location = url + "#step" + step;
};


/* 1. Change the stylesheet on the current page 
 * 2. Save the value using the API
 */
NWB.changeTheme = function (theme){
        // Save the changes using the API
        if (theme != wgDefaultTheme ) {
                Mediawiki.apiCall({
                        "action" : "foundersettings",
                        "changesetting" : "wgDefaultTheme", 
                        "value" : theme},
			function() { Mediawiki.updateStatus(NWB.msg("theme-saved")); });
                wgDefaultTheme = theme;
        } 

        // Create a link object for the stylesheet
	var href = "/extensions/wikia/NewWikiBuilder/themes/" + theme.toLowerCase() + ".css";
	$("head:first").append('<link rel="stylesheet" type="text/css" href="' + href + '" />');
};


/* Make sure there are the right amount of available boxes */
NWB.firstPagesInputs = function (){
	var empties = 0, fulls = 0;

	$("#all_fp input[type='text']").each(function(i, o) {
		if (Mediawiki.e(o.value)){
			empties++;
		} else {
			fulls++;
		}
	});

	if (fulls > 100){
		Mediawiki.updateStatus(NWB.msg("no-more-pages"), true);
	}

	if (empties <= 2){
		NWB.firstPagesBlocks++;
		// Add a block of 5 more titles
		$('<ul id="fp_block_' + NWB.firstPagesBlocks + '" style="display: none;">' + $("#fp_block_1").html() + '</ul>').appendTo("#all_fp").fadeIn();
	}
};

NWB.handleDescriptionForm = function (event){
	try {
             // Save the article
             Mediawiki.updateStatus(NWB.msg("saving-description"));
	     var mainPageEnd = Mediawiki.followRedirect("Main Page"); // Should be cached.
             Mediawiki.editArticle({
                  "title": mainPageEnd,
                  "summary": "",
                  "section": NWB.descriptionSection,
                  "text": $("#desc_textarea").val()}, 
                  function(){
                          NWB.updateStatus(NWB.msg("description-saved"));
			  NWB.gotostep(2);
                  },
                  NWB.apiFailed);
        } catch (e) {
                  Mediawiki.updateStatus(NWB.msg("error-saving-description"));
                  Mediawiki.debug(Mediawiki.print_r(e));
        }
	event.preventDefault();
};


NWB.handleFirstPages = function (event){
	try {
		Mediawiki.updateStatus(NWB.msg("saving-articles"));

		// Go through the form fields and get the titles
		var pages = [];
		$("#all_fp input[type='text']").each(
			function(i, o){
				if (!Mediawiki.e(o.value)){
					pages.push(o.value);
				}
			}
		);

                Mediawiki.apiCall({
                        "action" : "createmultiplepages",
			"pagelist" : pages.join("|"),
                        "category" : this.category.value
                        }, NWB.handleFirstPagesCallback, NWB.apiError, "POST");
        } catch (e) {
                  Mediawiki.updateStatus(NWB.msg("error-saving-articles"));
                  Mediawiki.debug(Mediawiki.print_r(e));
        }
	event.preventDefault();
};


NWB.handleFirstPagesCallback = function (result){
	if (result.error) {
		NWB.apiFailed(result.error.info);
	} else {
		var count = 0;
		for (var page in result.createmultiplepages.success){
			count++;
		}
		Mediawiki.updateStatus(count + " " + NWB.msg("articles-saved"));
		NWB.gotostep(5);
	}
};


NWB.handleLoginForm = function (f){
	try { 
		Mediawiki.updateStatus(NWB.msg("logging-in"));
		Mediawiki.login(f.lgname.value, f.lgpassword.value, function() {
				$("#loginForm").fadeOut();
				$("#logoutForm").fadeIn();
				Mediawiki.updateStatus(NWB.msg("login-successful"));
			}, function(msg) { Mediawiki.updateStatus(NWB.msg("login-error") + " : " + msg, true); }
		);
	} catch (e) {
		Mediawiki.updateStatus(NWB.msg("error-loging-in") + Mediawiki.print_r(e));    
	}
	
	return false; // Return false so that the form doesn't submit
};


NWB.handleLogoutForm = function(f){ // Is f required?
	$("#logoutForm").fadeOut();
        $("#loginForm").fadeIn();
        Mediawiki.updateStatus(NWB.msg("logout-successful"));
};

NWB.msg = function (msg){
	var ret;
	try {
		ret = NWB.messages[NWB.language][msg];
	} catch(e) {
		ret =  msg;
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
		Mediawiki.updateStatus(NWB.msg("error-saving-logo") + " " + error, true);
		Mediawiki.d("Upload error: " + error);
		return;
	} 

	Mediawiki.updateStatus(NWB.msg("logo-uploaded"));

	// Fill in the preview or the current depending on what was clicked
	var url;
	if ($("#logo_article").val() == "Wiki-Preview.png"){
		url = Mediawiki.getImageUrl("Wiki-Preview.png") + '?' + Math.random();
		$("#logo_preview").css("backgroundImage", "url(" + url + ")");
		$("#logo_preview_wrapper").show();
	} else {
		url = Mediawiki.getImageUrl("Wiki2.png") + '?' + Math.random();
		$("#logo_current").css("backgroundImage", "url(" + url + ")");
	}
	return;

     } catch (e) {
         Mediawiki.updateStatus(NWB.msg("error-saving-logo"));
         Mediawiki.debug(Mediawiki.print_r(e)); 
     }
};


NWB.iframeFormInit = function (f){
	if (! Mediawiki.isLoggedIn()) {
		Mediawiki.updateStatus(NWB.msg("must-be-logged-in"), true);
//		return false;
	} else if (Mediawiki.e(f.logo_file.value)){
		Mediawiki.updateStatus(NWB.msg("choose-a-file"), true);
		return false;
	}

	Mediawiki.updateStatus(NWB.msg("uploading-logo"), false, 30000);
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
