var NWB = {
	"language": "en" // TODO: Pull this from the browser or users settings
};	      

var wgDefaultTheme = 'slate'; // TODO don't use hardcoded value, use it from Mediawiki

NWB.messages = {
	"en": {
		"error-saving-description": "Error Saving Description",
		"theme-saved": "Theme Choice Saved",
		"saving-article": "Saving Article...",
		"description-saved": "Description Saved"
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
             Mediawiki.updateStatus(NWB.msg("saving-article"));
	     var mainPageEnd = Mediawiki.followRedirect("Main Page"); // Should be cached.
             Mediawiki.editArticle({
                  "title": mainPageEnd,
                  "summary": "",
                  "section": 0,
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
        	Mediawiki.apiUser = f.lgname.value;
		Mediawiki.apiPass = f.lgpassword.value;
		Mediawiki.updateStatus("Logging In...");
		Mediawiki.login(function() {
				$("#loginForm").fadeOut();
				$("#logoutForm").fadeIn();
				Mediawiki.updateStatus("Login Successful");
			}, NWB.apiFailed);
	} catch (e) {
		Mediawiki.updateStatus( "Error logging in:" + Mediawiki.print_r(e));    
	}
	
	return false; // Return false so that the form doesn't submit
};

NWB.handleLogoutForm = function(f){ // Is f required?
	$("#logoutForm").fadeOut();
        $("#loginForm").fadeIn();
        Mediawiki.updateStatus("Logout Successful");
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

	Mediawiki.updateStatus('Image Uploaded');

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


NWB.apiFailed = function(msg){
	alert("Api call returned an error: " + msg);
};
        
NWB.updateStatus = Mediawiki.updateStatus;
