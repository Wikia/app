$(function() {
	wikiaSearch_setup();
	$('.staff-hide-link').click(blockArticle);
	$('#MainContent').find('.toggleFeed').click(autoHubToggle);

	$('.toggleContainer').each(function(i){
		var link = $(this).find('a');
		if( 'Unhide' == link.html() ) {
			$(this).parent().addClass( "hiddenAdminSection" ); 
		}
	});

	// Bartek - pack tracking so it doesn't pollute other pages
	if( $('#hub-name').exists() ) {
		$('#top-wikis-lists-box').click(trackContainer);
		$('#hub-blogs').click(trackContainer);
		$('#wikia-global-hot-spots').click(trackContainer);
		$('#hub-top-contributors').click(trackContainer);

		trackTag( 'pv/' + wgPageName );
	}

	makeWikiaButtons();
	initHideLinks(); 
});

$(window).load(function() {
	setTimeout(sliderImages_load, 300);
	spotlightSlider_setup(blockArticle);
});

function trackTag( str ) {
	WET.byStr( 'hub/' + str );
};

function trackContainer ( ev ) {
	var obj = $(ev.target);

	if( 'IMG' == obj.attr( 'nodeName' ) ) {
		if( obj.hasClass( 'avatar' )  ) {
			trackTag( 'topusers/avatar' );
		}
	} 

	if( 'A' == obj.attr( 'nodeName' ) ) {
		if( obj.parent().parent().hasClass( 'top-wiki-data' )  ) {
			trackTag( 'featuredwikis' );
		} else if( obj.parent().hasClass( 'hub-blog-artlink' )  ) {
			trackTag( 'blog/article' );

		} else if( obj.parent().hasClass( 'user-info' )  ) {
			trackTag( 'blog/username' );
		} else if( obj.parent().hasClass( 'topuser-info' )  ) {
			trackTag( 'topusers/name' );
		}
	}

		if( obj.parent().parent().hasClass( 'blog-jump' )  ) {
			trackTag( 'blog/comments' );
		}
}

function makeWikiaButtons() {
	//There is no way to provide CSS class for links created in MediaWiki. This function adds appropriate classes and markup to buttons.
	$(".MainArticle-sidebar .create-wiki-container a").addClass("wikia-button").addClass("primary");
}

//Ajax block article
function blockArticle(e){
	e.preventDefault();
	if (confirm(corporatepage_hide_confirm)) {
		var me = $(this);
		var args = me.attr("href").split("?")[1];
		var data = args.split("&");

		$.postJSON(window.wgScriptPath + "/index.php", {
				action: "ajax",
				rs: "CorporatePageHelper::blockArticle",
				wiki: data[0].split("=")[1],
				name: data[1].split("=")[1]
			}, function(data) {
		 		if (data.status == "OK"){
					me.closest(".page-activity-sources").html(corporatepage_hide_success).closest("li").animate({opacity: 1}, 1500).slideUp();
				} else {
		 			alert(corporatepage_hide_error);
				}
			}
		);
	}
}

function autoHubToggle(e) {
	e.preventDefault();
	var me = $(this);
	var feed = me.parent().attr("id");
	// todo this is probably only temporary location
	var tag = $('#autohubTagDB').attr('value');

	$.getJSON(wgScript,
		{
			'action':'ajax',
			'rs':'AutoHubsPagesHelper::setHubsFeedsVariable',
			'feed':feed,
			'tag':tag
		},
		function(response) {
			if( response.response == 'ok' ) {
				var inside_a = me.closest('a');
				if( inside_a.html() == 'Hide' ) {
					me.parent().parent().addClass( "hiddenAdminSection" );					
					inside_a.html('Unhide');				
				} else {
					me.parent().parent().removeClass( "hiddenAdminSection" );
					inside_a.html('Hide');						
				}
			}
		}
	);
}

function spotlightSlider_setup() {
	//timer for automatic spotlight slideshow
	var spotlightSlider_timer;

	//random integer, 0-3
	var random = 0; //Math.floor(Math.random() * 4);

	//move spotlights
	$(".spotlight-slider").each(function() {
		$(this).css("left", parseInt($(this).css("left")) - (620 * random));
	});

	//select nav
	$("#spotlight-slider-" + random).find(".nav").addClass("selected");

	//show description
	$("#spotlight-slider-" + random).find(".description").show();

	//bind events
	$("#spotlight-slider .nav").click(function() {
		if($("#spotlight-slider .spotlight-slider").queue().length == 0) {
			clearInterval(spotlightSlider_timer);
			spotlightSlider_scroll($(this));
		}
	});
	spotlightSlider_timer = setInterval(spotlightSlider_slideshow, 7000);
}

function spotlightSlider_slideshow() {
	var current = $("#spotlight-slider .selected").parent().prevAll().length;
	var next = (current == $("#spotlight-slider .nav").length - 1) ? 0 : current + 1;
	spotlightSlider_scroll($("#spotlight-slider-" + next).find(".nav"));
}

function spotlightSlider_scroll(nav) {
	//setup variables
	var thumb_index = nav.parent().prevAll().length;
	var scroll_by = parseInt(nav.parent().find(".spotlight-slider").css("left"));
	//set "selected" class
	$("#spotlight-slider .nav").removeClass("selected");
	nav.addClass("selected");
	//hide description
	$("#spotlight-slider .description").clearQueue().hide();
	//scroll
	$("#spotlight-slider .spotlight-slider").animate({
		left: "-=" + scroll_by
	}, function() {
		$("#spotlight-slider-" + thumb_index).find(".description").fadeIn();
	});
}

function wikiaSearch_setup() {
	var placeholder = $("#wikia-search-form legend").text();
	$("#wikia-search").focus(function() {
		if ( $(this).hasClass("placeholder") ) {
			$(this).attr("value", "").removeClass("placeholder");
		}
	}).blur(function() {
		if ( $(this).attr("value") == "" ) {
			$(this).attr("value", placeholder).addClass("placeholder");
		}
	}).blur();
}

function sliderImages_load() {
return true;
  if (( typeof feature_image_1 == "undefined" ) || ( typeof  feature_image_2 == "undefined" ) || ( typeof  feature_image_3 == "undefined" )) {
	  return true;
  }
  
  var imgTag_pt1 = '<img width="620" height="250" src="';
  var imgTag_pt2 = '" class="spotlight-slider">';
  
  $('li#spotlight-slider-1 > a').html(imgTag_pt1 + feature_image_1 + imgTag_pt2);
  $('li#spotlight-slider-2 > a').html(imgTag_pt1 + feature_image_2 + imgTag_pt2);
  $('li#spotlight-slider-3 > a').html(imgTag_pt1 + feature_image_3 + imgTag_pt2);

}

function initHideLinks() {
	$('.head-hide-link').click(function(e){
		target = $(e.target); 
		var args = target.attr("href").split("?")[1];
		$("body").css("cursor", "progress");
		$.postJSON(window.wgScriptPath + "/index.php", args, function(data) {
			window.location.reload();
		});
		return false; 
	});
}
