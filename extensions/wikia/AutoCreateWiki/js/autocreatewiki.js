var wgAjaxPath = wgScriptPath + wgScript;

$(function () { 
	$.loadYUI( function() {
		YAHOO.namespace("ACWikiRequest");
		YE.preventDefault('highlightform');
		
		YC = YAHOO.util.Connect;
		YD = YAHOO.util.Dom;
		YE = YAHOO.util.Event;
		
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
						status.innerHTML = "";
						divErrors["'" + divData["div-name"] + "'"] = divData["div-name"];
					}
					else {
						status.innerHTML = "<img src='" + stylepath + "/wikia/img/ok.png' />";
						delete divErrors["'" + divData["div-name"] + "'"];
					}
					canAcceptForm();
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
			setProgressImg(err);
		    // to lowercase
		    name = name.toLowerCase();
		    YD.get("wiki-domain").value = name;
		
		    YC.asyncRequest( "GET", wgAjaxPath + "?action=ajax&rs=axACWRequestCheckName&name=" + encodeURIComponent(name) + "&lang=" + encodeURIComponent(lang) + "&type=" + encodeURIComponent(createType), YAHOO.ACWikiRequest.NameCallback);
		}
		
		YAHOO.ACWikiRequest.checkWikiName = function(e) {
			var err = YD.get("wiki-name-error-status");
			var name = YD.get("wiki-name").value;
		    var lang = YD.get("wiki-language").value;
			setProgressImg(err);
		    // to lowercase
		
		    YC.asyncRequest( "GET", wgAjaxPath + "?action=ajax&rs=axACWRequestCheckWikiName&name=" + encodeURIComponent(name) + "&lang=" + encodeURIComponent(lang), YAHOO.ACWikiRequest.NameCallback);
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
				YAHOO.util.Dom.setStyle(err, 'display', 'inline');
				setProgressImg(err);
				params = "&year=" + year.value + "&month=" + month.value + "&day=" + day.value;
				YC.asyncRequest( "GET", wgAjaxPath + "?action=ajax&rs=axACWRequestCheckBirthday" + params, YAHOO.ACWikiRequest.NameCallback);
			}
		}
		
		YAHOO.ACWikiRequest.wikiDomainKeyUp = function(e) {
			var id = this.id;
			var func = function() {
				if (id) {
					if ( !allowAction(e) ) {
						YE.preventDefault(id);
						if (id == 'wiki-name') {
							//isTextCorrect(id);
							YAHOO.ACWikiRequest.checkWikiName(e);
						} else {
							YAHOO.ACWikiRequest.checkDomain(e);
						}
					}
				};
			};
		
			if ( this.zid ) {
				clearTimeout(this.zid);
			}
			this.zid = setTimeout(func,666*2);
		}
		
		YAHOO.ACWikiRequest.checkAccount = function(e, fid) {
			if ( fid ) {
				var err = YD.get(fid + "-error");
				var status = YD.get(fid + '-error-status');
				var name = YD.get(fid);
				var lang = YD.get("wiki-language").value;
				//---
				setProgressImg(status);
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
					params = "&pass=" + encodeURIComponent(YD.get("wiki-password").value);
				} else if ( fid == "password" ) {
					params = "&username=" + encodeURIComponent(YD.get("wiki-username").value);
					YD.get("wiki-retype-password").value = "";
					delete divErrors["'wiki-retype-password-error'"];
					YAHOO.util.Dom.setStyle("wiki-retype-password-error", 'display', 'none');
					YD.get("wiki-retype-password-error-status").innerHTML = "";
				}

				var req = wgAjaxPath + "?action=ajax&rs=axACWRequestCheckAccount&name=" + encodeURIComponent(fid) + "&lang=" + encodeURIComponent(lang) + "&value=" + encodeURIComponent(name.value);
				YC.asyncRequest( "GET", req + params, YAHOO.ACWikiRequest.NameCallback);
			}
		}
		
		
		YAHOO.ACWikiRequest.wikiAccountKeyUp = function(e) {
			var id = this.id;
			var func = function() {
				var field = document.getElementById(id);
				if (id) {
					if ( !allowAction(e) ) {
						YE.preventDefault(id);
						YAHOO.ACWikiRequest.checkAccount(e, id);
					}
				};
			};
			if ( this.zid ) {
				clearTimeout(this.zid);
			}
			this.zid = setTimeout(func,666*2);
		}
		
		YAHOO.ACWikiRequest.resetForm = function(e) {
			var cnt = 0;
			for (i in divErrors) {
				var div = i.replace(/\'/g, "");
				YD.setStyle(div, 'display', 'none');
				YD.get(div + "-status").innerHTML = "";
			}
			divErrors = new Array();
		
			var oF = document.forms['highlightform'];
			var oElm = oF.getElementsByTagName('SPAN');
			var els = oElm.length;
			for(i = 0; i < els; i++) {
				if (oElm[i].id) {
					var pos = oElm[i].id.indexOf( 'error-status', 0 );
					if (pos !== -1) {
						YD.get(oElm[i].id).innerHTML = "";
					}
				}
			}
		
			YD.get( "wiki-submit" ).disabled = false;
			return true;
		}
		
		YAHOO.ACWikiRequest.submitForm = function(e) {
			YD.get( "wiki-submit" ).disabled = true;
			document.forms['highlightform'].submit();
			return true;
		}
		
		YE.addListener(["wiki-name", "wiki-domain"], "keyup", YAHOO.ACWikiRequest.wikiDomainKeyUp );
		YE.addListener(["wiki-username", "wiki-email", "wiki-retype-password"], "keyup", YAHOO.ACWikiRequest.wikiAccountKeyUp );
		YE.addListener("wiki-language", "change", YAHOO.ACWikiRequest.wikiLanguageChange );
		YE.addListener(["wiki-user-year","wiki-user-month","wiki-user-day"] , "change", YAHOO.ACWikiRequest.wikiBirthdayCheck );
		YE.addListener("wiki-cancel", "click", YAHOO.ACWikiRequest.resetForm );
		YE.addListener("wiki-submit", "click", YAHOO.ACWikiRequest.submitForm );
		
		YE.addListener(["wiki-username"], "change", YAHOO.ACWikiRequest.checkWikiName ); 
	});
});

function canAcceptForm() {
	var cnt = 0;
	for (i in divErrors) { cnt++; }
	if (cnt == 0) {
		YD.get( "wiki-submit" ).disabled = false;
	} else {
		YD.get( "wiki-submit" ).disabled = true;
	}
}

function allowAction(e) {
	var keycode = e.keycode||e.which||0;
	return (
		(keycode) == 16 || //shift
		(keycode) == 9  || //tab
		(keycode) == 13 || // enter
		(keycode) == 18 || // alt
		(keycode) == 17 || // ctrl
		(keycode) == 20 // caps
	);
}

function setProgressImg(field) {
	field.innerHTML = '<img src="http://images.wikia.com/common/skins/common/images/ajax.gif?' + wgStyleVersion + '" width="16" height="16" alt="Wait..." border="0" />';
}

function isTextCorrect(field) {
	var invalidChars = "!@#$%^&*()+=-[]\';,./{}|\":<>?";
	var status = YD.get(field + '-error-status');
	//---
	setProgressImg(status);
	//---
	var errors = 0;
	if (YD.get(field).value.length == 0) {
		errors++;
	} else {
		for (var i = 0; i < YD.get(field).value.length; i++) {
			if ( invalidChars.indexOf( YD.get(field).value.charAt(i) ) != -1 ) {
				errors++;
			}
		}
	}
	if (errors > 0) {
		YD.setStyle(field + '-error', 'display', 'block');
		YD.get(field + '-error').innerHTML = msgError;
		YD.get(field + "-error-status").innerHTML = "";
		divErrors["'" + field + "-error'"] = field;
	} else {
		//---
		YD.get(field + "-error-status").innerHTML = "<img src='" + stylepath + "/wikia/img/ok.png' />";
		YD.setStyle(field + '-error', 'display', 'none');
		YD.get(field + '-error').innerHTML = "";
		if ( divErrors["'" + field + "-error'"] ) {
			delete divErrors["'" + field + "-error'"];
		};
	}
	canAcceptForm();
	return (errors > 0) ? false : true;
}


function realoadAutoCreateForm(){
	$("#wiki-submit").attr("disabled",true);
	$("#wiki-cancel").attr("disabled",true);
	$("#highlightform").attr("action",formViewAction);
	$("#highlightform").submit();
}