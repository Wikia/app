jQuery("#answers_ask_field").ready(function() {
	var answers_field_default = wgAskFormTitle;
	jQuery("#answers_ask_field").focus(function() {
		if (jQuery(this).attr('value') == answers_field_default) {
			jQuery(this).removeClass('alt').attr('value', '');
		}
	}).blur(function() {
		if (jQuery(this).attr('value') == '') {
			jQuery(this).addClass('alt').attr('value', answers_field_default);
		}
	});
	
	var oDS = new YAHOO.util.XHRDataSource(  "/extensions/wikia/SuperDeduper/"); 
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

	// Add a question mark to the end of the result
	myAutoComp.formatResult = function(oResultData, sQuery, sResultMatch) {
	        var sMarkup = (sResultMatch) ? sResultMatch + '?' : "";
		return sMarkup;
	};
	// Don't highlight the first result
	myAutoComp.autoHighlight = false; 

});

jQuery("#header_menu_user").ready(function() {
	jQuery("#header_button_user").bind("click", function() {
		jQuery("#header_menu_user").slideDown("fast");
		alignCenter('header_menu_user', 'header_button_user');
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
	if( !q )return;
	if( q == wgAskFormTitle )return;
	
	q = q.replace(/\?/g,""); //removes question mark
	q = q.replace(/_+/g,"_"); //we only want one space
	q = encodeURIComponent( q );
	
	var url = wgServer + "/api.php?action=query&titles=" + q + "&format=json";
	var params = '';
	
	jQuery.get( url, "", function (oResponse){
			
			eval("j=" + oResponse);
			
			page = j.query.pages["-1"];
			path = wgServer + wgArticlePath.replace("$1","");
			if( typeof( page ) != "object" ){
				url = path + q;
			}else{
				url = path + "Special:CreateQuestionPage?questiontitle=" + q.charAt(0).toUpperCase() + q.substring(1);
			}
			window.location = url;
		}
	);
}
	
jQuery(document).ready(function() {
	jQuery("#ask_form").submit(askQuestion);
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
		s += '<a href=\"' + google_info.feedback_url + '\" class="google_label">Ads by Google</a><br>';
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
jQuery("#recent_unanswered_questions").ready(function() {
	
	url = wgServer + "/api.php?smaxage=60&action=query&list=wkpagesincat&wkcategory=" + wgUnAnsweredCategory  + "&format=json&wklimit=10";
	jQuery.get( url, "", function( oResponse ){
		eval("j=" + oResponse);
		if( j.query.wkpagesincat ){
			html = "";
			for( recent_q in j.query.wkpagesincat ){
				page = j.query.wkpagesincat[recent_q];
				html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>";
			}
			jQuery("#recent_unanswered_questions").prepend( html );
		}
		
	});
});

jQuery("#related_answered_questions").ready(function() {
	
	url = wgServer + "/api.php?smaxage=60&action=query&list=wkpagesincat&wkcategory=" + wgAnsweredCategory + "&format=json&wklimit=5";
	jQuery.get( url, "", function( oResponse ){
		eval("j=" + oResponse);
		if( j.query.wkpagesincat ){
			html = "";
			for( related_q in j.query.wkpagesincat ){
				page = j.query.wkpagesincat[related_q];
				html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>";
			}
			jQuery("#related_answered_questions").prepend( html );
		}
		
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


jQuery("#popular_categories").ready(function() {
	
	url = wgServer + "/api.php?smaxage=60&action=query&list=wkmostcat&format=json&wklimit=15";
	jQuery.get( url, "", function( oResponse ){
		eval("j=" + oResponse);
		if( j.query.wkmostcat ){
			html = "";
			count = 1;
			for( category in j.query.wkmostcat ){
				if( count > 10 )break;
				category_check = category.toLowerCase().replace(/_/g," ");
				if ( category_check != wgAnsweredCategory.toLowerCase() && category_check != wgUnAnsweredCategory.toLowerCase()){
					html += "<li><a href=\"" + j.query.wkmostcat[category].url + "\">" + category.replace(/_/g," ") + "</a></li>";
					count++;
				}
			}
			jQuery("#popular_categories").prepend( html );
		}
		
	});
});

//main page
jQuery(document).ready(function() {
if( wgIsMainpage == true ){
	jQuery("#homepage_new_questions").ready(function() {
		
		url = wgServer + "/api.php?smaxage=60&action=query&list=wkpagesincat&wkcategory=" + wgUnAnsweredCategory  + "&format=json&wklimit=5";
		jQuery.get( url, "", function( oResponse ){
			eval("j=" + oResponse);
			if( j.query.wkpagesincat ){
				html = "";
				for( new_q in j.query.wkpagesincat ){
					page = j.query.wkpagesincat[new_q];
					html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>";
				}
				jQuery("#homepage_new_questions").prepend( html );
			}
			
		});
	});
	
	jQuery("#homepage_recently_answered_questions").ready(function() {
		
		url = wgServer + "/api.php?smaxage=60&action=query&list=wkpagesincat&wkcategory=" + wgAnsweredCategory + "&format=json&&wkorder=edit&wklimit=6";
		jQuery.get( url, "", function( oResponse ){
			eval("j=" + oResponse);
			if( j.query.wkpagesincat ){
				html = "";
				for( recent_q in j.query.wkpagesincat ){
					page = j.query.wkpagesincat[recent_q];
					if( page.title != wgPageName ){
						html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>";
					}
				}
				jQuery("#homepage_recently_answered_questions").prepend( html );
			}
			
		});
	});
}});
