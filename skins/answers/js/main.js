var $G = YAHOO.util.Dom.get;

jQuery("#answers_ask_field").ready(function() {
	$.loadYUI(function(){
		var answers_ask_field_default = wgAskFormTitle;
		var answers_category_field_default = wgAskFormCategory;
		jQuery(".header_field").focus(function() {
			if (jQuery(this).attr('value') == eval(this.id + '_default')) {
				jQuery(this).removeClass('alt').attr('value', '');
			}
		}).blur(function() {
			if (jQuery(this).attr('value') == '') {
				jQuery(this).addClass('alt').attr('value', eval(this.id + '_default'));
			}
		});
		
		var oDS = new YAHOO.util.XHRDataSource(wgServer + '/api.php');
		// Set the responseType 
		oDS.responseType = YAHOO.util.XHRDataSource.TYPE_JSON; 
		// Define the schema of the JSON results 
		oDS.responseSchema = { 
			resultsList : "ResultSet.Result", 
			fields : ["title", "rank"] 
		}; 
		var myAutoComp = new YAHOO.widget.AutoComplete("answers_ask_field","answers_suggest", oDS); 
		myAutoComp.maxResultsDisplayed = 10;  
		myAutoComp.minQueryLength = 5; 
		myAutoComp.queryDelay = 1; 

		// Add a question mark to the end of the result
		myAutoComp.formatResult = function(oResultData, sQuery, sResultMatch) {
				var sMarkup = (sResultMatch) ? sResultMatch + '?' : "";
			return sMarkup;
		};
		// Don't highlight the first result
		myAutoComp.autoHighlight = false; 

		myAutoComp.generateRequest = function(sQuery) {
			return "?action=superdeduper&lang=" + wgContentLanguage + "&db=" + wgDB + "&query=" + sQuery;
		}

		var submitAutoComplete_callback = {
			success: function(o) {
				if(o.responseText !== undefined) {
					WET.byStr('ask/goToSuggest');
					window.location.href=o.responseText;
				}
			}
		}

		var submitAutoComplete = function(comp, resultListItem) {
			//YAHOO.Wikia.Tracker.trackByStr(null, 'search/suggestItem/' + escape(YAHOO.util.Dom.get('search_field').value.replace(/ /g, '_')));
			sUrl = wgServer + wgScriptPath + '?action=ajax&rs=getSuggestedArticleURL&rsargs=' + encodeURIComponent(YAHOO.util.Dom.get('answers_ask_field').value);
			console.log(sUrl);
			var request = YAHOO.util.Connect.asyncRequest('GET', sUrl, submitAutoComplete_callback);
		}
		myAutoComp.itemSelectEvent.subscribe(submitAutoComplete);

		YAHOO.util.Event.addListener('answers_ask_field', 'keypress', function(e) {if(e.keyCode==13) {
			WET.byStr('ask/enter');
			askQuestion();
		}});
	});
});

jQuery("#header_menu_user").ready(function() {
	jQuery("#header_button_user").bind("click", function() {		
		jQuery("#header_menu_user").slideDown("fast");
		alignCenter('header_menu_user', 'header_button_user');
		WET.byStr( 'userMenu/more' );
		return false;
	});
});

function stopProp() {
        jQuery(this).find("*").mouseout(function(e) {
                e.stopPropagation();
        });
}

function closeMenus() {
	jQuery(".header_menu").slideUp("fast");
}

function alignCenter(e, target) {
	var center = jQuery(window).width() - jQuery("#"+target).offset().left - jQuery("#"+target).outerWidth() / 2;
	jQuery("#"+e).css("right", center - jQuery("#"+e).outerWidth() / 2);
}

function askQuestion(){
	q = document.getElementById('answers_ask_field').value.replace(/\s/g,"_");
	c = document.getElementById('answers_category_field').value; 
	if (c == wgAskFormCategory) {
		c = '';
	}
	if( !q )return;
	if( q == wgAskFormTitle )return;
	
	q = q.replace(/\?/g,""); //removes question mark
	q = q.replace(/_+/g,"_"); //we only want one space
	q = q.replace(/#/g,""); //we only want one space
	q = encodeURIComponent( q );
	
	path = wgServer + wgArticlePath.replace("$1","");
	url = path + "Special:CreateQuestionPage?questiontitle=" + q.charAt(0).toUpperCase() + q.substring(1) + "&categories=" + c;
	window.location = url;
}
	
function anonWatch(){
	jQuery.get( wgServer + "/index.php?action=ajax&rs=wfHoldWatchForAnon&rsargs[]=" + wgPageName, "", 
	function (oResponse){
		window.location = oResponse;
	});
}

jQuery(document).ready(function() {
	jQuery("#ask_form").submit(askQuestion);
	jQuery("#ask_button").click(function() {WET.byStr("ask/click");});
	jQuery("#ask_button").click(askQuestion);
	jQuery(".header_menu").hover(stopProp, closeMenus);
	jQuery(document).click(closeMenus);
});


//GOOGLE ADS
function google_ad_request_done(google_ads) {
	if( !wgIsQuestion ) return;
	google_ad_render(google_ads, 1);
	google_ad_render(google_ads, 2);
	google_ad_render(google_ads, 3);
	google_ad_render(google_ads, 4);
}

function google_ad_render( google_ads, i ){
	i = i - 1;
	if( google_ads[i] ){
		s = "";
		s += '<a href=\"' + google_info.feedback_url + '\" class="google_label">' + wgAdsByGoogleMsg + '</a><br>';
		s += '<a style="text-decoration:none" href="' +
		google_ads[i].url + '" onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' +
		google_ads[i].visible_url + '\';return true" class="google_link">' +
		google_ads[i].line1 + '<br /></a> <span class="google_description">' +
		google_ads[i].line2 + ' ' +
		google_ads[i].line3 + '<br /></span> <span><a href="' +
		google_ads[i].url + '" onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' +
		google_ads[i].visible_url + '\';return true" class="google_url">' +
		google_ads[i].visible_url + '</span></a><br />';
		jQuery("#google_ad_" + (i + 1)).html(s);
	}
}

//YUI Helper Functions

//Make fade and appear become show/hide
//YAHOO.widget = { Effects:{} };
YAHOO.widget.Effects = {};
YAHOO.widget.Effects.Appear = function( id ){
	jQuery("#" + id).show();
};
YAHOO.widget.Effects.Hide = function( id ){
	jQuery("#" + id).hide();
};
YAHOO.widget.Effects.Fade = function( id ){
	jQuery("#" + id).hide();
};

//Sidebar Widgets
var recent_questions_page = '';
function renderQuestions() {
   $.get(wgScript + "?smaxage=60&action=ajax&rs=HomePageListAjax&method=recent_unanswered_questions" + recent_questions_page, null, function(data) {
		if (data != "") {
			$("#recent_unanswered_questions").html(data);

			var timestamp1 = $("#timestamp1").html();
			var timestamp  = $("#timestamp").html();

			var html = data;

			// round to full minute, make caching easier; if smaxage is higher than 1 min consider changing this as well
			if(timestamp != null) {
				timestamp1 = timestamp1.replace(/:[0-9]{2}Z$/, ":00Z");
				timestamp  =  timestamp.replace(/:[0-9]{2}Z$/, ":00Z");
			}
		
			//nav
			html += "<li class='sidebar_nav'>"
			html += "<div class=\"sidebar_nav_prev\"><a href=javascript:void(0); onclick=\"WET.byStr('unanswered/prev');questionsNavClick('&cmstart=" + timestamp  + "');\">" + wgPrevPageMsg + "</a></div>";
			html += "<div class=\"sidebar_nav_next\"><a href=javascript:void(0); onclick=\"WET.byStr('unanswered/next');questionsNavClick('&cmend="   + timestamp1 + "');\">" + wgNextPageMsg + "</a></div>";
			html += "<a href=\"" + wgUnansweredRecentChangesURL + "\" onclick=\"WET.byStr('unanswered/seeall')\">" + wgUnansweredRecentChangesText + "</a>";
			html += "</li>";
			
			jQuery("#recent_unanswered_questions").html( html );
			jQuery("#recent_unanswered_questions").animate({opacity: 1.0}, "normal");
			
		}
		
	});
}

function questionsNavClick( dir ){
	recent_questions_page = dir;
	
	jQuery("#recent_unanswered_questions").animate({opacity: 0},500);
	renderQuestions()
}

    
jQuery("#recent_unanswered_questions").ready( renderQuestions );


jQuery("#related_answered_questions").ready(function() {
   $.get(wgScript + "?smaxage=60&action=ajax&rs=HomePageListAjax&method=related_answered_questions&title=" + encodeURIComponent(wgPageName), null, function(data) {
		if (data != "") $("#related_answered_questions").html(data);
	});
});

jQuery(document).ready(function() {
	jQuery(".skip_link").each(function() {
		jQuery(this).bind("click", function() {
		/*
			jQuery(this).closest(".inline_form").animate({
				height: "1px",
				opacity: "0"
			}, "slow");
			return false;
		*/
			jQuery(this).closest(".inline_form").animate({ opacity: 0 }).animate({ height: "0px" }, function() { jQuery(this).hide(); });
			return false;
		});
	});
});

jQuery("#homepage_new_questions").ready(function() {
   $.get(wgScript + "?smaxage=60&action=ajax&rs=HomePageListAjax&method=homepage_new_questions", null, function(data) {
		if (data != "") $("#homepage_new_questions").html(data);
	});
});
jQuery("#homepage_recently_answered_questions").ready(function() {
   $.get(wgScript + "?smaxage=60&action=ajax&rs=HomePageListAjax&method=homepage_recently_answered_questions", null, function(data) {
		if (data != "") $("#homepage_recently_answered_questions").html(data);
	});
});

jQuery("#facebook-connect").ready(function() {
	if( !wgEnableFacebookConnect || !wgIsQuestion )return false;
	updateFacebookBox();
});


function updateFacebookBox(){
	if( ! document.getElementById("facebook-user-placeholder") )return false;
		
	fb_uid = YAHOO.util.Cookie.get(wgFacebookAnswersAppID + "_user");
	if( ! fb_uid ){
		jQuery("#facebook-connect-login").show();
		jQuery("#facebook-connect-ask").hide();
	}else{
		jQuery("#facebook-connect-login").hide();
		fb_html = "<div id='fb-pic' uid='" + fb_uid + "' facebook-logo='true' style='float:left'></div>";
		fb_html += "<div style='float:left'><span id='fb-name' useyou='false' uid='" + fb_uid + "'></span><br/>";
		fb_html += wgFacebookSignedInMsg + "<br/>";
		fb_html += "<a href='#' onclick='FB.Connect.logoutAndRedirect(window.location.href)'>" + wgFacebookLogoutMsg + "</a></div>";
		fb_html += "<div style='clear:both'></div>";
		
		document.getElementById("facebook-user-placeholder").innerHTML = fb_html;
		FB.XFBML.Host.autoParseDomTree = false; 
		FB.XFBML.Host.addElement(new FB.XFBML.Name(document.getElementById("fb-name"))); 
		FB.XFBML.Host.addElement(new FB.XFBML.ProfilePic(document.getElementById("fb-pic"))); 
	
		jQuery("#facebook-connect-logout").show();
		
		document.getElementById("facebook-connect-ask").innerHTML = "<a href='javascript:facebook_ask()'><img src=\"http://b.static.ak.fbcdn.net/images/fbconnect/login-buttons/connect_light_small_short.gif?8:121638\"></a> <a href='javascript:facebook_ask()'>" + wgFacebookAskMsg + "</a><span id='facebook_finish'></span>";
		jQuery("#facebook-connect-ask").show();
	}
}

function facebook_login_handler(){
	window.location = document.location.href;
}
	
var facebook_clicked_ask = false;
function facebook_ask(){
	facebook_clicked_ask = true;
	facebook_publish_feed_story();
}

function facebook_publish_finish(){
	if( facebook_clicked_ask ){
		document.getElementById("facebook_finish").innerHTML = "<img src='" + stylepath  + "/wikia/img/ok.png'>" ;
		facebook_clicked_ask = false;
	}
	return false;
}

function facebook_publish_feed_story() {
	// Load the feed form
	FB.ensureInit(function() {  
	  template_data = {"question" : wgTitle + "?", "url" : wgServer + wgArticlePath.replace("$1",wgPageName), "editurl" : wgServer + wgScript + "?title=" + wgPageName + "&action=edit" };
	  FB.Connect.showFeedDialog(wgFacebookAnswersTemplateID, template_data,  null , null, FB.FeedStorySize.oneLine, FB.RequireConnect.require, facebook_publish_finish );
	});
}

/* Function to take an array and turn it into a url encoded string. Handy for ajax requests. ;) */
function http_build_query( formdata, numeric_prefix, arg_separator ) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Legaev Andrey
    // +   improved by: Michael White (http://getsprink.com)
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // *     example 1: http_build_query({foo: 'bar', php: 'hypertext processor', baz: 'boom', cow: 'milk'}, '', '&amp;');
    // *     returns 1: 'foo=bar&amp;php=hypertext+processor&amp;baz=boom&amp;cow=milk'
    // *     example 2: http_build_query({'php': 'hypertext processor', 0: 'foo', 1: 'bar', 2: 'baz', 3: 'boom', 'cow': 'milk'}, 'myvar_');
    // *     returns 2: 'php=hypertext+processor&myvar_0=foo&myvar_1=bar&myvar_2=baz&myvar_3=boom&cow=milk'
 
    var key, use_val, use_key, i = 0, j=0, tmp_arr = [];
 
    if (!arg_separator) {
        arg_separator = '&';
    }
 
    for (key in formdata) {
        use_val = escape(formdata[key].toString());
        use_key = escape(key);
 
        if (numeric_prefix && !isNaN(key)) {
            use_key = numeric_prefix + j;
            j++;
        }
        tmp_arr[i++] = use_key + '=' + use_val;
    }
 
    return tmp_arr.join(arg_separator);
}



// Magic answer
MagicAnswer = {};
MagicAnswer.appid  = 'GD2UGdfIkY1gi6EBoIck4Exv2xLUsVrm'; // From search
MagicAnswer.region = '';
MagicAnswer.apiUrl = 'http://answers.yahooapis.com/AnswersService/V1/';

MagicAnswer.getAnswer = function  (question, callbackFunction) {
        var params = Array();
        params["search_in"] = "question";
        params["type"] = "resolved";
        params["results"] = "1";
        MagicAnswer.questionSearch(question, params, callbackFunction);
};

MagicAnswer.questionSearch = function(question, params, callbackFunction){
        var defaultParams = Array();
        // http://developer.yahoo.com/answers/V1/questionSearch.html
        defaultParams["search_in"] = "all"; // all|question|best_answer
        defaultParams["category_id"] = "";
        defaultParams["category_name"] = "";
        defaultParams["region"] = MagicAnswer.region;
        defaultParams["date_range"] = "all";
        defaultParams["sort"] = "relevance"; // relevance|date_desc|date_asc
        defaultParams["appid"] = MagicAnswer.appid;
        defaultParams["type"] = "all"; // all|resolved|open|undecided
        defaultParams["results"] = "10";
        defaultParams["output"] = "json";
        defaultParams["callback"] = callbackFunction;

        var formData = defaultParams;
        for (var param in params){
                formData[param]=params[param];
        }
        if (!params["query"]) { formData["query"] = question; }

        var s = document.createElement("script");
        s.type = "text/javascript";
        s.src = MagicAnswer.apiUrl + 'questionSearch?' + http_build_query(formData);
        document.getElementsByTagName('head')[0].appendChild(s);
};

jQuery("#random_users_with_avatars").ready(function() {
	if( !document.getElementById("random_users_with_avatars") )return false;
	
	url = wgServer + "/api.php?smaxage=60&action=query&list=wkuserswithavatars&format=json&wklimit=6&wkavatarsize=l";
	jQuery.getJSON( url, "", function( j ){	
		if( j.query.wkuserswithavatars ){
			html = "";
			for( user_name in j.query.wkuserswithavatars ){
				user = j.query.wkuserswithavatars[user_name];
				html += "<div class='random_user_avatar'><a href='" + user.user_page_url + "'><img src='" + user.user_avatar + "' border='0'></a></div>";		
			}
			html += "<div style='clear:both'></div>";
			jQuery("#random_users_with_avatars").html( html );
		}
	});
});

jQuery("#contributors").ready(function() {
	$('#contributors').find('.userPoints').each(function() {
		var id = $(this).attr('id');
		var timestamp = $(this).attr('timestamp');
		if (match = /\d+$/.exec(id)) {
			$.getJSON(wgScript + '?action=ajax&rs=wfAnswersGetEditPointsAjax', {userId: match[0]}, function(json) {
				if (json.timestamp > timestamp) {
					$('#' + id).html(json.points);
				}
			});
		}
	});
});
