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

/**
 * Main page slider
 */
var spotlightSlider_timer,
	SLIDER_INTERVAL = 7000;

function spotlightSlider_setup() {
	var firstFrame = $("#spotlight-slider-0");

	//select nav
	firstFrame.find(".nav").addClass("selected");

	//show description
	firstFrame.find(".description").show();

	//bind events
	$("#spotlight-slider .nav").click(function() {
		if($("#spotlight-slider .spotlight-slider-image").queue().length == 0) {
			clearTimeout(window.spotlightSlider_timer);
			spotlightSlider_scroll($(this));
		}
	});

	window.spotlightSlider_timer = setTimeout(spotlightSlider_slideshow, SLIDER_INTERVAL);
}

function spotlightSlider_slideshow() {
	var current = $("#spotlight-slider .selected").parent().prevAll().length,
		length = $("#spotlight-slider .nav").length,
		next = (current+1) % length;

	spotlightSlider_scroll($("#spotlight-slider-" + next).find(".nav"), function() {
		// queue the next animation frame when the current one is finished
		window.spotlightSlider_timer = setTimeout(spotlightSlider_slideshow, SLIDER_INTERVAL);
	});
}

function spotlightSlider_scroll(nav, callback /* function to fire when animation is done */) {
	//setup variables
	var thumb_index = nav.parent().prevAll().length;
	var scroll_by = parseInt(nav.parent().find(".spotlight-slider-image").css("left"));
	//set "selected" class
	$("#spotlight-slider .nav").removeClass("selected");
	nav.addClass("selected");
	//hide description
	$("#spotlight-slider .description").clearQueue().hide();

	//scroll
	var images = $("#spotlight-slider .spotlight-slider-image"),
		completeCount = images.length;

	images.animate({
		left: "-=" + scroll_by
	},
	function() {
		$("#spotlight-slider-" + thumb_index).find(".description").fadeIn();

		// call the callback only once (when all animation is done, not per node)
		if(--completeCount == 0) {
			if (typeof callback == 'function') {
				callback();
			}
		}
	});
}

$(spotlightSlider_setup);

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

	makeWikiaButtons();
	initHideLinks();
});