YAHOO.namespace("ACWikiRequest");
var YC = YAHOO.util.Connect;
var YD = YAHOO.util.Dom;
var YE = YAHOO.util.Event;
var WR = YAHOO.WRequest;
var wgAjaxPath = wgScriptPath + wgScript;

YE.preventDefault('highlightform');

function canAcceptForm() {
	var cnt = 0;
	for (i in divErrors) { cnt++; }	
	if (cnt == 0) {
		YD.get( "wiki-submit" ).disabled = false;
	}
}

function allowAction(e) {
	return ( 
		(e.keyCode||e.which) == 16 || //shift
		(e.keyCode||e.which) == 9  || //tab
		(e.keyCode||e.which) == 13 || // enter 
		(e.keyCode||e.which) == 18 || // alt
		(e.keyCode||e.which) == 17 || // ctrl  
		(e.keyCode||e.which) == 20 // caps  
	);
}

function isTextCorrect(field) {
	var invalidChars = "!@#$%^&*()+=-[]\';,./{}|\":<>?";
	//---
	YD.get(field + '-error-status').innerHTML = '<img src="' + stylepath + '/common/progress-wheel.gif" width="16" height="16" alt="Wait..." border="0" />';
	//---
	for (var i = 0; i < YD.get(field).value.length; i++) {
		if ( invalidChars.indexOf( YD.get(field).value.charAt(i) ) != -1 ) {
			YD.setStyle(field + '-error', 'display', 'block'); 
			YD.get(field + '-error').innerHTML = msgError;
			return false;  
		}
	}
	//---
	YD.get(field + "-error-status").innerHTML = "<img src='" + stylepath + "/wikia/img/ok.png' />";	
	YD.setStyle(field + '-error', 'display', 'none'); 
	YD.get(field + '-error').innerHTML = "";
	return true;
}

YAHOO.util.Event.onAvailable("moving", function() {
	var aBodyXY = YAHOO.util.Dom.getXY('highlightform');
	var aDivSel = YAHOO.util.Dom.getElementsByClassName('formblock', 'div');
	var height, width;
	var curDiv = null;
	if (aDivSel) {
		height = YAHOO.util.Dom.getStyle(aDivSel[0], 'height').replace("px", "");
		width = YAHOO.util.Dom.getStyle(aDivSel[0], 'width').replace("px", "");

		function findDiv(target) {
			var cDiv = null;			
			while (cDiv == null) { 
				if (target.nodeName.toUpperCase() == 'DIV') {
					cDiv = target;
				} else {
					target = target.parentNode; 
				}
			}
			return cDiv;
		}
		
		function onblurFormElem(event) {
			curDiv = null;
		}
		
		function onfocusFormElem(event) {
			if (!curDiv) {
				var target = YAHOO.util.Event.getTarget(event, true);
				curDiv = findDiv(target);
			}
			
			var selectedDivs = YAHOO.util.Dom.getElementsByClassName('selected', 'div');
			if (selectedDivs.length == 0) {
				YAHOO.util.Dom.setStyle("moving", 'display', 'none');
				if (curDiv) {
					YAHOO.util.Dom.addClass(curDiv, 'selected'); 
				}
			} else {
				if (selectedDivs.length > 0) {
					var prevDiv = selectedDivs[0];
					if (prevDiv != curDiv) {
						height = curDiv.offsetHeight;
						var prevHeight = prevDiv.offsetHeight;
						width = YAHOO.util.Dom.getStyle(curDiv, 'width').replace("px", "");
						if (prevDiv) YAHOO.util.Dom.removeClass(prevDiv, 'selected'); 
						var move = new YAHOO.util.Anim("moving", {
							top: {
								from: (prevDiv) ? (YAHOO.util.Dom.getXY(prevDiv)[1] - aBodyXY[1]) : 0, 
								to: (prevDiv) ? (YAHOO.util.Dom.getXY(curDiv)[1] - aBodyXY[1]) : 0
							},
							height: { from: prevHeight, to: height },
							width: { from: width, to: width }
						}, 1);
						move.duration = 0.5;
						move.onComplete.subscribe(function() {
							YAHOO.util.Dom.addClass(curDiv, 'selected'); 
							YAHOO.util.Dom.setStyle("moving", 'display', 'none');
						}); 
						YAHOO.util.Dom.setStyle("moving", 'display', 'block');
						move.animate();
					}
				}
			}
		}
			
		var oF = document.forms['highlightform'];
		var oElm = oF.getElementsByTagName('INPUT');
		var els = oElm.length;
		for(i = 0; i < els; i++) {
			if (oElm[i].type != 'hidden' && oElm[i].type != 'submit' && oElm[i].type != 'reset') {
				YAHOO.util.Event.addListener(oElm[i], "focus", onfocusFormElem);
				YAHOO.util.Event.addListener(oElm[i], "blur", onblurFormElem);
			}
		}
		var oEls = oF.getElementsByTagName('SELECT');
		var elss = oEls.length;
		for(i = 0; i < elss; i++) {
			YAHOO.util.Event.addListener(oEls[i], "focus", onfocusFormElem);
			YAHOO.util.Event.addListener(oEls[i], "blur", onblurFormElem);
		}

		YAHOO.util.Dom.setStyle("moving", 'display', 'none');
		YAHOO.util.Dom.addClass(aDivSel[0], 'selected'); 
	}
});

YAHOO.util.Event.onDOMReady(function () {
	canAcceptForm()
});

YAHOO.ACWikiRequest.NameCallback = {
    success: function( oResponse ) {
    	var res = oResponse.responseText;
    	if (res) {
			var divData = YAHOO.Tools.JSONParse(res);
			var div = YD.get( divData["div-name"] );
			var error = divData["div-error"];
			var status = YD.get(divData["div-name"] + "-status");
			var msg = divData["div-body"];
			if (error) {
				YD.get( "wiki-submit" ).disabled = true;
				status.innerHTML = "";
				divErrors["'" + divData["div-name"] + "'"] = divData["div-name"];
			}
			else {
				status.innerHTML = "<img src='" + stylepath + "/wikia/img/ok.png' />";
				delete divErrors["'" + divData["div-name"] + "'"];
				canAcceptForm();
			}
			if ( msg ) {
				div.innerHTML = msg;
				YAHOO.util.Dom.setStyle(div, 'display', 'block'); 
			} else {
				YAHOO.util.Dom.setStyle(div, 'display', 'none'); 
			}
		} else {
			YAHOO.util.Dom.setStyle(div, 'display', 'none'); 
		}
    },
    failure: function( oResponse ) {
        YAHOO.log( "simple replace failure " + oResponse.responseText );
		YAHOO.util.Dom.setStyle(err, 'display', 'block');
    },
    timeout: 50000
};

YAHOO.ACWikiRequest.checkDomain = function(e) {
	var err = YD.get("wiki-domain-error-status");
	var name = YD.get("wiki-domain").value;
    var lang = YD.get("wiki-language").value;
	
	err.innerHTML = '<img src="' + stylepath + '/common/progress-wheel.gif" width="16" height="16" alt="Wait..." border="0" />';
	
    // to lowercase
    name = name.toLowerCase();
    YD.get("wiki-domain").value = name;

    YC.asyncRequest( "GET", wgAjaxPath + "?action=ajax&rs=axACWRequestCheckName&name=" + escape(name) + "&lang=" + escape(lang), YAHOO.ACWikiRequest.NameCallback);
}

YAHOO.ACWikiRequest.wikiLanguageChange = function(e) {
	var prefixDiv = YD.get("prefixedAddress");
	var value = prefixDiv.innerHTML;
	if (this.value != 'en' && prefixDiv) {
		value.replace("http://", "");
		value = "http://" + this.value + ".";
	} else {
		value = "http://";
	}
	prefixDiv.innerHTML = value;
	YAHOO.ACWikiRequest.checkDomain(e);	
}

YAHOO.ACWikiRequest.wikiBirthdayCheck = function(e) {
	var year = YD.get("wiki-user-year");
	var month = YD.get("wiki-user-month");
    var day = YD.get("wiki-user-day");
	var err = YD.get("wiki-birthday-error-status");

	if ( (year.value > 0) && (month.value > 0) && (day.value > 0) ) {
		YAHOO.util.Dom.setStyle(err, 'display', 'block');
		err.innerHTML = '<img src="http://images.wikia.com/common/progress-wheel.gif" width="16" height="16" alt="Wait..." border="0" />';
		params = "&year=" + escape(year.value) + "&month=" + escape(month.value) + "&day=" + escape(day.value);
		YC.asyncRequest( "GET", wgAjaxPath + "?action=ajax&rs=axACWRequestCheckBirthday" + params, YAHOO.ACWikiRequest.NameCallback);
	}
}

YAHOO.ACWikiRequest.wikiDomainKeyUp = function(e) {
	var id = this.id;
	var func = function() { 
		if (id) { 
			if (e) {
				YE.preventDefault(e);
			}
			if ( !allowAction(e) ) {
				if (id == 'wiki-name') {
					isTextCorrect(id);
				} else {
					YAHOO.ACWikiRequest.checkDomain(e);
				}
			}
		};
	};

	if ( this.zid ) {
		clearTimeout(this.zid);
	}
	this.zid = setTimeout(func,1000);
}

YAHOO.ACWikiRequest.checkAccount = function(e, fid) {
	if ( fid ) {
		var err = YD.get(fid + "-error");
		var name = YD.get(fid);
		var lang = YD.get("wiki-language").value;
		//---
		YAHOO.util.Dom.setStyle(err, 'display', 'block');
		err.innerHTML = '<img src="http://images.wikia.com/common/progress_bar.gif" width="70" height="11" alt="Wait..." border="0" />';
		//---
		fid = fid.replace("wiki-", "");
		var params = "";
		if ( fid == "username" ) {
			YD.get("wiki-retype-password").value = "";
			delete divErrors["'wiki-retype-password-error'"];
			YAHOO.util.Dom.setStyle("wiki-retype-password-error", 'display', 'none');
			YD.get("wiki-retype-password-error-status").innerHTML = "";
			//---
			YD.get("wiki-password").value = "";
			delete divErrors["'wiki-retype-password'"];
			YAHOO.util.Dom.setStyle("wiki-password-error", 'display', 'none');
			YD.get("wiki-password-error-status").innerHTML = "";
			canAcceptForm();
		} else if (fid == "retype-password") {
			params = "&pass=" + escape(YD.get("wiki-password").value);
		} else if ( fid == "password" ) {
			params = "&username=" + escape(YD.get("wiki-username").value);
			YD.get("wiki-retype-password").value = "";
			delete divErrors["'wiki-retype-password-error'"];
			YAHOO.util.Dom.setStyle("wiki-retype-password-error", 'display', 'none');
			YD.get("wiki-retype-password-error-status").innerHTML = "";
		}
		var req = wgAjaxPath + "?action=ajax&rs=axACWRequestCheckAccount&name=" + escape(fid) + "&lang=" + escape(lang) + "&value=" + escape(name.value);
		YC.asyncRequest( "GET", req + params, YAHOO.ACWikiRequest.NameCallback);
	}
}

YAHOO.ACWikiRequest.wikiAccountKeyUp = function(e) {
	var id = this.id;
	var func = function() { 
		var field = document.getElementById(id);
		if (id) { 
			if ( !allowAction(e) ) {
				if (e) {
					YE.preventDefault(e);
				}
				YAHOO.ACWikiRequest.checkAccount(e, id);
			}
		};
	};
	if ( this.zid ) {
		clearTimeout(this.zid);
	}
	this.zid = setTimeout(func,1000);
}

YE.addListener("wiki-name", "keyup", YAHOO.ACWikiRequest.wikiDomainKeyUp );
YE.addListener("wiki-domain", "keyup", YAHOO.ACWikiRequest.wikiDomainKeyUp );
YE.addListener("wiki-username", "keyup", YAHOO.ACWikiRequest.wikiAccountKeyUp );
YE.addListener("wiki-email", "keyup", YAHOO.ACWikiRequest.wikiAccountKeyUp );
YE.addListener("wiki-password", "keyup", YAHOO.ACWikiRequest.wikiAccountKeyUp );
YE.addListener("wiki-retype-password", "keyup", YAHOO.ACWikiRequest.wikiAccountKeyUp );

YE.addListener("wiki-language", "change", YAHOO.ACWikiRequest.wikiLanguageChange );
YE.addListener("wiki-user-year", "change", YAHOO.ACWikiRequest.wikiBirthdayCheck );
YE.addListener("wiki-user-month", "change", YAHOO.ACWikiRequest.wikiBirthdayCheck );
YE.addListener("wiki-user-day", "change", YAHOO.ACWikiRequest.wikiBirthdayCheck );
