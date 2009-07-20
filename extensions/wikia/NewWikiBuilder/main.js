$(function() {
	var url = document.location.toString();
	var firstStep = $(".step:first").attr("id");
	var urlAnchor = firstStep;
	if (url.match("#")) {
		urlAnchor = url.split('#')[1];
	}
	showStep(urlAnchor);

	$(".step a").click(function() {
		if (this.href.match("#")) {
			showStep(this.href.split('#')[1]);
		}
	});
	checkStep(firstStep);
});
 
var currentStep;

function showStep(stepName) {
	$(".step").hide();
	$("[id="+stepName+"]").show();
	$("#progress li").removeClass("selected");
	$("[id=progress_"+stepName+"]").addClass("selected");
	currentStep = stepName;
}

//There is no back button click event. This checks the URL and sets the correct step.
function checkStep(firstStep) {
	setInterval(function() {
		var url = document.location.toString();
		var urlAnchor = firstStep;
		if (url.match("#")) {
			urlAnchor = url.split('#')[1];
		}
		if (currentStep != urlAnchor) {
			showStep(urlAnchor);
		}
	}, 200);
}

function gotostep(step) {
	var current = document.location.toString();
	var url = current.split('#')[0];
	document.location = url + "#step" + step;
}

var NWB = {
	"language": "en", // TODO: Pull this from the browser or users settings
	"descriptionSection" : 1
};	      

var wgDefaultTheme = 'slate'; // TODO don't use hardcoded value, use it from Mediawiki

NWB.messages = {
	"en": {
		"choose-a-file": "Please choose a file",
		"error-saving-description": "Error Saving Description",
		"theme-saved": "Theme Choice Saved",
		"saving-description": "Saving Description...",
		"description-saved": "Description Saved",
		"uploading-logo": "Uploading Logo...",
		"logo-uploaded": "Logo Uploaded",
		"login-successful": "Login Successful",
		"logout-successful": "Logout Successful",
		"login-error": "Error logging in",
		"logging-in": "Logging in...",
		"api-error": "There was a problem:"
	}
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
        var link = document.createElement("link");
        link.rel = "stylesheet";
        link.type = "text/css";
        link.href = "http://images.wikia.com/common/skins/monaco/" + theme.toLowerCase() + "/css/main.css";
        
        // Put it in the head so they can see what it will look like
        var h = document.getElementsByTagName("head").item(0);
        h.appendChild(link);

};


Mediawiki.handleDescriptionForm = function (f){
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
                  },
                  NWB.handleError);
        } catch (e) {
                  Mediawiki.updateStatus(NWB.msg("error-saving-description"));
                  Mediawiki.debug(Mediawiki.print_r(e));
        }

        return false; // Return false so that the form doesn't submit
};


NWB.handleError = function(e){
	// TODO: More graceful handling
	alert(Mediawiki.print_r(e));
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

	Mediawiki.updateStatus(NWB.msg("logo-uploaded"));

	// Fill in the preview or the current depending on what was clicked
	var url;
	if ($("#logo_article").val() == "Wiki-Preview.png"){
		url = Mediawiki.getImageUrl("Wiki-Preview.png") + '?' + Math.random();
		$("#logo_preview").css("backgroundImage", "url(" + url + ")");
	} else {
		url = Mediawiki.getImageUrl("Wiki2.png") + '?' + Math.random();
		$("#logo_current").css("backgroundImage", "url(" + url + ")");
	}
};


NWB.iframeFormInit = function (f){
	if (Mediawiki.e(f.logo_file.value)){
		Mediawiki.updateStatus(NWB.msg("choose-a-file"), true);
		return false;
	}

	Mediawiki.updateStatus(NWB.msg("uploading-logo"), false, 30000);
	return true;
};


NWB.apiFailed = function(msg){
	alert(NWB.msg("api-error") + " : " + msg);
};
        
NWB.updateStatus = Mediawiki.updateStatus;
