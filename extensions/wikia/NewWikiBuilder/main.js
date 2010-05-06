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
	$("#first_pages_form").submit(NWB.handleFirstPages);
});

var NWB = {
	"language":		"en", // default
	"firstPagesBlocks" :	1,
	"currentStep":		null,
	"statusTimeout": 	5000
};


NWB.apiFailed = function(reqObj, msg, error){
	Mediawiki.waitingDone();
	if (typeof msg == "object"){
		msg = Mediawiki.print_r(msg);
	}
	alert(NWB.msg("nwb-api-error") + " " + Mediawiki.print_r(msg));
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
					NWB.apiFailed(NWB.msg("nwb-error-saving-theme") + cresult, true);
				} else if (result.settings == "success") {
					Mediawiki.updateStatus(NWB.msg("nwb-theme-saved"), false, NWB.statusTimeout);
				} else {
					NWB.apiFailed(null, result, null);
				}
			}, NWB.apiFailed, "POST");
                window.wgAdminSkin = theme;
        } 

        // Create a link object for the stylesheet
	var href = "/extensions/wikia/NewWikiBuilder/themes/" + theme.replace(/monaco-/, '').toLowerCase() + ".css";
	// Heh. Head first.
	$("head:first").append('<link rel="stylesheet" type="text/css" href="' + href + '" />');

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
        var mainPageEnd = Mediawiki.followRedirect(window.wgMainpage, false); // Should be cached.
        var result = Mediawiki.apiCall({
		"action" : "purge",
		"titles" : mainPageEnd});

	// Redirect
	window.location = 'http://' + document.domain + '/wiki/' + mainPageEnd;
};

/* Make sure there are the right amount of available boxes */
NWB.firstPagesInputs = function (){
	var empties = 0, fulls = 0;

	$(".fp_page").each(function(i, o) {
		if (Mediawiki.e(o.value)){
			empties++;
		} else {
			fulls++;
		}
	});

	if (fulls > 100){
		Mediawiki.updateStatus(NWB.msg("nwb-no-more-pages"), true);
	}

	if (empties <= 2){
		NWB.firstPagesBlocks++;
		// Add a block of 5 more titles
		$("#fp_block_1").clone().attr("id", "fp_block_" + NWB.firstPagesBlocks).find("input").val("").end().appendTo("#all_fp").fadeIn(NWB.reflow);
	}
};


//Call this function when the page doesn't properly lay out after performing a dynamic action
NWB.reflow = function() {
	$("body").addClass("reflow");
	$("body").removeClass("reflow");
};


NWB.handleDescriptionForm = function (event){
    try {

	     var rawtext = $("#desc_textarea").val();
	     // Strip leading spaces and add original heading
	     var text = NWB.originalHeading + "\n" + rawtext.replace(new RegExp("^[ \t]+", "gm"), "");
             // Save the article
             Mediawiki.updateStatus(NWB.msg("nwb-saving-description"));
	     Mediawiki.waiting();
	     var mainPageEnd = Mediawiki.followRedirect(window.wgMainpage, false); // Should be cached.
	     Mediawiki.waiting();
             Mediawiki.editArticle({
                  "title": mainPageEnd,
                  "summary": "",
                  "section": 1,
                  "text": text}, 
                  function(result){
	     		  Mediawiki.waitingDone();
        		  var cresult = Mediawiki.checkResult(result);
			  if (cresult !== true) {
			        if (result.error.code == "readonly"){
					NWB.updateStatus(NWB.msg("nwb-readonly-try-again"), true);
			        } else {
					NWB.apiFailed(null, result.error.info, null);
				}
			  } else {
				NWB.updateStatus(NWB.msg("nwb-description-saved"), false, NWB.statusTimeout);
			  	NWB.gotostep(2);
			  }
                  },
                  NWB.apiFailed);
     } catch (e) {
	  Mediawiki.waitingDone();
          Mediawiki.updateStatus(NWB.msg("nwb-error-saving-description"), true);
          Mediawiki.debug(Mediawiki.print_r(e));
     }
     event.preventDefault();
};


NWB.handleFirstPages = function (event){
	try {
		Mediawiki.updateStatus(NWB.msg("nwb-saving-articles"));

		// Go through the form fields and get the titles
		var tpages = [];
		$("#all_fp .fp_page").each(
			function(i, o){
				tpages.push(o.value.replace(/\|/, ''));
			}
		);

		// And the categories
		var tcats = [];
		$("#all_fp .fp_cat").each(
			function(i, o){
				tcats.push(o.value.replace(/\|/, ''));
			}
		);

		var ttexts = [];
		$("#all_fp .fp_answer").each(
			function(i, o){
				ttexts.push(o.value.replace(/\|/, ''));
			}
		);


		var pages = [], cats = [], texts = [];
		for (var i = 0; i < tpages.length; i++){
			if (! Mediawiki.e(tpages[i])){
				pages.push(tpages[i]);
				cats.push(tcats[i]);
				texts.push(ttexts[i]);
			}
		}

		// if no titles were specified, just skip to the next step
		if ( pages.length === 0 ) {
			event.preventDefault();
			Mediawiki.statusBar.release();
			if (NWB.type == "answers" ) {
				NWB.gotostep(4);
			} else {
				NWB.gotostep(5);
			}
			return;
		}

		// Reverse the order of the pages, so that the first one is created last,
		// so that when they show up on home page, they are in correct order
		pages.reverse();
		cats.reverse();
		texts.reverse();

		Mediawiki.waiting();
		var pagetext;
		if (NWB.type == "answers") {
			// per RT#48002
			pagetext = texts.join("|");
		} else {
                        pagetext = NWB.msg("nwb-new-pages-text");
		}
                Mediawiki.apiCall({
                        "action" : "createmultiplepages",
			"pagelist" : pages.join("|"),
                        "pagetext" : pagetext,
			"category" : cats.join("|"),
			"type" : NWB.type
                        }, NWB.handleFirstPagesCallback, NWB.apiFailed, "POST");
        } catch (e) {
			console.dir(e);
                  Mediawiki.updateStatus(NWB.msg("nwb-error-saving-articles"));
                  Mediawiki.debug(Mediawiki.print_r(e));
        }
	event.preventDefault();
};


NWB.handleFirstPagesCallback = function (result){
	Mediawiki.waitingDone();
        var cresult = Mediawiki.checkResult(result);
        if (cresult !== true) {
                Mediawiki.error(NWB.msg("nwb-error-saving-articles") + cresult);
	} else {
		var count = 0;
		for (var page in result.createmultiplepages.success){
			count++;
		}
		if (NWB.type == "answers") {
			NWB.gotostep(4);
		} else {
			Mediawiki.updateStatus(count + " " + NWB.msg("nwb-articles-saved"), false, NWB.statusTimeout);
			NWB.gotostep(5);
		}
	}
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
		$("#logo_current").css("backgroundImage", "url(" + url + ")");
		NWB.gotostep(3);
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
        

NWB.pullWikiDescriptionCallback = function (result){
        var rg = new RegExp("={2,3}[^=]+={2,3}");

	var match = result.match(rg);
	if (match === null){
		$("#desc_textarea").attr("disabled", true); 
		NWB.updateStatus(NWB.msg("nwb-unable-to-edit-description"), true);
	} else {
		// Preserve the existing heading (=== blah ===) , we will tack it on when saving
		NWB.originalHeading = match[0];
		var text = result.replace(match, '');
		$("#desc_textarea").val(jQuery.trim(text));
	}
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
