var wgAjaxPath = wgScriptPath + wgScript;
var ACWikiRequest = {};

$('#highlightform').submit(function(e){e.preventDefault()});

$(function () {
	canAcceptForm()
});

ACWikiRequest.NameCallback = function( res ) {
	if (res) {
		var divData = jQuery.parseJSON(res);
		var div = $("#" + divData["div-name"] );
		var error = divData["div-error"];
		var status = $("#" + divData["div-name"] + "-status");
		var msg = divData["div-body"];
		if (error) {
			status.html("");
			divErrors["'" + divData["div-name"] + "'"] = divData["div-name"];
		}
		else {
			status.html("<img src='" + stylepath + "/wikia/img/ok.png' />");
			delete divErrors["'" + divData["div-name"] + "'"];
		}
		canAcceptForm();
		if ( msg ) {
			div.html(msg);
			$(div).css('display', 'block');
		} else {
			$(div).css('display', 'none');
		}
	}
};
/* ajax fail
    failure: function( oResponse ) {
        YAHOO.log( "simple replace failure " + oResponse.responseText );
		YAHOO.util.Dom.setStyle(err, 'display', 'block');
    },
    timeout: 50000
};
*/

ACWikiRequest.checkDomain = function(e) {
	var err = $("#wiki-domain-error-status");
	var name = $("#wiki-domain").val();
    var lang = $("#wiki-language").val();
	setProgressImg(err);
    // to lowercase
    name = name.toLowerCase();
    $("#wiki-domain").val(name);

    $.get(wgAjaxPath, {action: "ajax", rs: "axACWRequestCheckName", name: encodeURIComponent(name), lang: encodeURIComponent(lang), type: encodeURIComponent(createType)}, ACWikiRequest.NameCallback);
};

ACWikiRequest.checkWikiName = function(e) {
	var err = $("#wiki-name-error-status");
	var name = $("#wiki-name").val();
    var lang = $("#wiki-language").val();
	setProgressImg(err);
    // to lowercase

    $.get(wgAjaxPath, {action: "ajax", rs: "axACWRequestCheckWikiName", name: encodeURIComponent(name), lang: encodeURIComponent(lang)}, ACWikiRequest.NameCallback);
};

ACWikiRequest.wikiLanguageChange = function(e) {
	var prefixDiv = $("#prefixedAddress");
	var domainDiv = $("#domainAddress");
	var subTitle = $("#wiki-subTitle");

	var subdomain = '';
	var prefixLang = true;
	if (definedDomains[this.value]) {
		subdomain = definedDomains[this.value];
		prefixLang = false;
	} else if (definedDomains['default']) {
		subdomain = definedDomains['default'];
	}
	
	var domain = ( subdomain ) ? subdomain + "." + defaultDomain : defaultDomain ;
	
	if (domainDiv) {
		domainDiv.html(domain);
	}

	if ( subdomain && subTitle ) {
		if ( definedSitename[this.value] ) {
			_title = definedSitename[this.value];
		} else {
			_title = subdomain.charAt(0).toUpperCase() + subdomain.substr(1);
		} 
		subTitle.html(_title);
	}

	var value = prefixDiv.html();
	if (this.value != 'en' && prefixDiv && prefixLang) {
		value.replace("http://", "");
		value = "http://" + this.value + ".";
	} else {
		value = "http://";
	}
	
	prefixDiv.html(value);
	ACWikiRequest.checkDomain(e);
};

ACWikiRequest.wikiBirthdayCheck = function(e) {
	var year = $("#wiki-user-year");
	var month = $("#wiki-user-month");
    var day = $("#wiki-user-day");
	var err = $("#wiki-birthday-error-status");

	if ( (year.val() > 0) && (month.val() > 0) && (day.val() > 0) ) {
		$(err).css('display', 'inline');
		setProgressImg(err);
		$.get(wgAjaxPath, {action: "ajax", rs: "axACWRequestCheckBirthday", year: year.val(), month: month.val(), day: day.val()}, ACWikiRequest.NameCallback);
	}
};

ACWikiRequest.wikiDomainKeyUp = function(e) {
	var id = this.id;
	var func = function() {
		if (id) {
			if ( !allowAction(e) ) {
				e.preventDefault();
				if (id == 'wiki-name') {
					//isTextCorrect(id);
					ACWikiRequest.checkWikiName(e);
				} else {
					ACWikiRequest.checkDomain(e);
				}
			}
		};
	};

	if ( this.zid ) {
		clearTimeout(this.zid);
	}
	this.zid = setTimeout(func,666*2);
};

ACWikiRequest.checkAccount = function(e, fid) {
	if ( fid ) {
		var err = $("#" + fid + "-error");
		var status = $("#" + fid + '-error-status');
		var name = $("#" + fid);
		var lang = $("#wiki-language").val();
		//---
		setProgressImg(status);
		//---
		fid = fid.replace("wiki-", "");
		var params = {action: "ajax", rs: "axACWRequestCheckAccount", name: encodeURIComponent(fid), lang: encodeURIComponent(lang), value: encodeURIComponent(name.val())};
		if ( fid == "username" ) {
			$("#wiki-retype-password").val("");
			delete divErrors["'wiki-retype-password-error'"];
			$("#wiki-retype-password-error").css('display', 'none');
			$("#wiki-retype-password-error-status").html("");
			//---
			$("#wiki-password").val("");
			delete divErrors["'wiki-retype-password'"];
			$("#wiki-password-error").css('display', 'none');
			$("#wiki-password-error-status").html("");
			canAcceptForm();
		} else if (fid == "retype-password") {
			params['pass'] = encodeURIComponent($("#wiki-password").val());
		} else if ( fid == "password" ) {
			params['username'] = encodeURIComponent($("#wiki-username").val());
			$("#wiki-retype-password").val("");
			delete divErrors["'wiki-retype-password-error'"];
			$("#wiki-retype-password-error").css('display', 'none');
			$("#wiki-retype-password-error-status").html("");
		}
		$.get(wgAjaxPath, params, ACWikiRequest.NameCallback);
	}
};


ACWikiRequest.wikiAccountKeyUp = function(e) {
	var id = this.id;
	var func = function() {
		var field = document.getElementById(id);
		if (id) {
			if ( !allowAction(e) ) {
				$(e).preventDefault();
				ACWikiRequest.checkAccount(e, id);
			}
		};
	};
	if ( this.zid ) {
		clearTimeout(this.zid);
	}
	this.zid = setTimeout(func,666*2);
};

ACWikiRequest.resetForm = function(e) {
	var cnt = 0;
	for (i in divErrors) {
		var div = i.replace(/\'/g, "");
		$("#" + div).css('display', 'none');
		$("#" + div + "-status").html("");
	}
	divErrors = new Array();

	var oF = document.forms['highlightform'];
	var oElm = oF.getElementsByTagName('SPAN');
	var els = oElm.length;
	for(i = 0; i < els; i++) {
		if (oElm[i].id) {
			var pos = oElm[i].id.indexOf( 'error-status', 0 );
			if (pos !== -1) {
				$("#" + oElm[i].id).html("");
			}
		}
	}

	$( "#wiki-submit" ).disabled = false;
	return true;
};

ACWikiRequest.submitForm = function(e) {
	$( "#wiki-submit" ).disabled = true;
	document.forms['highlightform'].submit();
	return true;
};

$("#wiki-name, #wiki-domain").keyup(ACWikiRequest.wikiDomainKeyUp);
$("#wiki-username, #wiki-email, #wiki-retype-password").keyup(ACWikiRequest.wikiAccountKeyUp);
$("#wiki-language").change(ACWikiRequest.wikiLanguageChange);
$("#wiki-user-year, #wiki-user-month, #wiki-user-day").change(ACWikiRequest.wikiBirthdayCheck);
$("#wiki-cancel").click(ACWikiRequest.resetForm);
$("#wiki-submit").click(ACWikiRequest.submitForm);
$("#wiki-username").change(ACWikiRequest.checkWikiName);

//

function canAcceptForm() {
	var cnt = 0;
	for (i in divErrors) { cnt++; }
	if (cnt == 0) {
		$( "#wiki-submit" ).disabled = false;
	} else {
		$( "#wiki-submit" ).disabled = true;
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
	field.html('<img src="http://images.wikia.com/common/skins/common/images/ajax.gif?' + wgStyleVersion + '" width="16" height="16" alt="Wait..." border="0" />');
}

function isTextCorrect(field) {
	var invalidChars = "!@#$%^&*()+=-[]\';,./{}|\":<>?";
	var status = $("#" + field + '-error-status');
	//---
	setProgressImg(status);
	//---
	var errors = 0;
	if ($("#" + field).val().length == 0) {
		errors++;
	} else {
		for (var i = 0; i < $("#" + field).val().length; i++) {
			if ( invalidChars.indexOf( $("#" + field).val().charAt(i) ) != -1 ) {
				errors++;
			}
		}
	}
	if (errors > 0) {
		$("#" + field + '-error').css('display', 'block');
		$("#" + field + '-error').html(msgError);
		$("#" + field + "-error-status").html("");
		divErrors["'" + field + "-error'"] = field;
	} else {
		//---
		$("#" + field + "-error-status").html("<img src='" + stylepath + "/wikia/img/ok.png' />");
		$("#" + field + '-error').css('display', 'none');
		$("#" + field + '-error').html("");
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
