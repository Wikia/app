$("#answers_ask_field").ready(function() {
	var answers_field_default = wgAskFormTitle;
	$("#answers_ask_field").focus(function() {
		if ($(this).attr('value') == answers_field_default) {
			$(this).removeClass('alt').attr('value', '');
		}
	}).blur(function() {
		if ($(this).attr('value') == '') {
			$(this).addClass('alt').attr('value', answers_field_default);
		}
	});
});

$("#header_menu_user").ready(function() {
	$("#header_button_user").bind("click", function() {
		$("#header_menu_user").slideDown("fast");
		alignCenter('header_menu_user', 'header_button_user');
		return false;
	});
});

function stopProp() {
        $(this).find("*").mouseout(function(e) {
                e.stopPropagation();
        });
}

function closeMenus() {
	$(".header_menu").slideUp("fast");
}

function alignCenter(e, target) {
	var center = $(window).width() - $("#"+target).offset().left - $("#"+target).outerWidth() / 2;
	$("#"+e).css("right", center - $("#"+e).outerWidth() / 2);
}

function askQuestion(){
	q = document.getElementById('answers_ask_field').value.replace(/\s/g,"_");
	if( !q )return;
	if( q == wgAskFormTitle )return;
	
	q = q.replace(/\?/g,"") //removes question mark
	q = q.replace(/_+/g,"_") //we only want one space
	q = encodeURIComponent( q );
	
	var url = wgServer + "/api.php?action=query&titles=" + q + "&format=json";
	var params = '';
	
	jQuery.get( url, "", function (oResponse){
			
			eval("j=" + oResponse)
			
			page = j.query.pages["-1"]
			path = wgServer + wgArticlePath.replace("$1","");
			if( typeof( page ) != "object" ){
				url = path + q
			}else{
				url = path + "Special:CreateQuestionPage?questiontitle=" + q.charAt(0).toUpperCase() + q.substring(1)
			}
			window.location = url
		}
	);
}
	
$(document).ready(function() {
	$("#ask_form").submit(askQuestion);
	$("#ask_button").click(askQuestion);
	$(".header_menu").hover(stopProp, closeMenus);
	$(document).click(closeMenus);
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
	i = i - 1
	if( google_ads[i] ){
		s = "";
		s += '<a href=\"' + google_info.feedback_url + '\" class="google_label">Ads by Google</a><br>'
		s += '<a style="text-decoration:none" href="' +
		google_ads[i].url + '" onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' +
		google_ads[i].visible_url + '\';return true" class="google_link">' +
		google_ads[i].line1 + '<br /></a> <span class="google_description">' +
		google_ads[i].line2 + ' ' +
		google_ads[i].line3 + '<br /></span> <span><a href="' +
		google_ads[i].url + '" onmouseout="window.status=\'\'" onmouseover="window.status=\'go to ' +
		google_ads[i].visible_url + '\';return true" class="google_url">' +
		google_ads[i].visible_url + '</span></a><br />';
		$("#google_ad_" + (i + 1)).html(s);
	}
}

//YUI Helper Functions

//So Ajax werks
var YAHOO={ util: { Connect: {} } }
YAHOO.util.Connect.asyncRequest = function(method,url,callback,pars){
	success = callback.success
	if( method.toUpperCase() == "POST" )jQuery.post( url, pars, success);
	if( method.toUpperCase() == "GET" )jQuery.get( url, pars, success);
}

//Make fade and appear become show/hide
YAHOO.widget = { Effects:{} };
YAHOO.widget.Effects.Appear = function( id ){
	$("#" + id).show();
}
YAHOO.widget.Effects.Hide = function( id ){
	$("#" + id).hide();
}
YAHOO.widget.Effects.Fade = function( id ){
	$("#" + id).hide();
}

//Sidebar Widgets
$("#recent_unanswered_questions").ready(function() {
	
	url = wgServer + "/api.php?action=query&list=wkpagesincat&wkcategory=" + wgUnAnsweredCategory  + "&format=json&wklimit=10"
	jQuery.get( url, "", function( oResponse ){
		eval("j=" + oResponse)
		if( j.query.wkpagesincat ){
			html = ""
			for( item in j.query.wkpagesincat ){
				page = j.query.wkpagesincat[item]
				html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>"
			}
			$("#recent_unanswered_questions").prepend( html )
		}
		
	});
});

$("#related_answered_questions").ready(function() {
	
	url = wgServer + "/api.php?action=query&list=wkpagesincat&wkcategory=" + wgAnsweredCategory + "&format=json&wklimit=5"
	jQuery.get( url, "", function( oResponse ){
		eval("j=" + oResponse)
		if( j.query.wkpagesincat ){
			html = ""
			for( item in j.query.wkpagesincat ){
				page = j.query.wkpagesincat[item]
				html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>"
			}
			$("#related_answered_questions").prepend( html )
		}
		
	});
});

$("#popular_categories").ready(function() {
	
	url = wgServer + "/api.php?action=query&list=wkmostcat&format=json&wklimit=15"
	jQuery.get( url, "", function( oResponse ){
		eval("j=" + oResponse)
		if( j.query.wkmostcat ){
			html = ""
			count = 1
			for( category in j.query.wkmostcat ){
				if( count > 10 )break;
				category_check = category.toLowerCase().replace(/_/g," ");
				if ( category_check != wgAnsweredCategory.toLowerCase() && category_check != wgUnAnsweredCategory.toLowerCase()){
					html += "<li><a href=\"" + j.query.wkmostcat[category].url + "\">" + category.replace(/_/g," ") + "</a></li>"
					count++
				}
			}
			$("#popular_categories").prepend( html )
		}
		
	});
});

//main page
$(document).ready(function() {
if( wgIsMainpage == true ){
	$("#homepage_new_questions").ready(function() {
		
		url = wgServer + "/api.php?action=query&list=wkpagesincat&wkcategory=" + wgUnAnsweredCategory  + "&format=json&wklimit=5"
		jQuery.get( url, "", function( oResponse ){
			eval("j=" + oResponse)
			if( j.query.wkpagesincat ){
				html = ""
				for( item in j.query.wkpagesincat ){
					page = j.query.wkpagesincat[item]
					html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>"
				}
				$("#homepage_new_questions").prepend( html )
			}
			
		});
	});
	
	$("#homepage_recently_answered_questions").ready(function() {
		
		url = wgServer + "/api.php?action=query&list=wkpagesincat&wkcategory=" + wgAnsweredCategory + "&format=json&&wkorder=edit&wklimit=6"
		jQuery.get( url, "", function( oResponse ){
			eval("j=" + oResponse)
			if( j.query.wkpagesincat ){
				html = ""
				for( item in j.query.wkpagesincat ){
					page = j.query.wkpagesincat[item]
					if( page.title != wgPageName ){
						html += "<li><a href=\"" + page.url + "\">" + page.title.replace(/_/g," ") + "?</a></li>"
					}
				}
				$("#homepage_recently_answered_questions").prepend( html )
			}
			
		});
	});
}});
