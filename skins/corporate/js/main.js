$(function() {
	wikiaSearch_setup();
	$('.staff-hide-link').click(blockArticle);
	$('#MainContent').find('.toggleFeed').click(autoHubToggle);
	makeWikiaButtons();
});

$(window).load(function() {
	setTimeout(sliderImages_load, 300);
	spotlightSlider_setup(blockArticle);
});

function makeWikiaButtons() {
	//There is no way to provide CSS class for links created in MediaWiki. This function adds appropriate classes and markup to buttons.
	$(".MainArticle-sidebar .create-wiki-container a").wrapInner("<span>").addClass("wikia_button").addClass("primary");
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
	var tag = $('#TagDB').attr('value');

	$.getJSON(wgScript,
		{
			'action':'ajax',
			'rs':'AutoHubsPagesHelper::setHubsFeedsVariable',
			'feed':feed,
			'tag':tag,
		},
		function(response) {
			if( response.result == 'ok' ) {
				if( response.disabled ) {
					me.parent().addClass( "disabledFeed" );
				} else {
					me.parent().removeClass( "disabledFeed" );
				}
			}
			else {
				// todo display error message? Christian will decide
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
  var imgTag_pt1 = '<img width="620" height="250" src="';
  var imgTag_pt2 = '" class="spotlight-slider">';
  
  $('li#spotlight-slider-1 > a').html(imgTag_pt1 + feature_image_1 + imgTag_pt2);
  $('li#spotlight-slider-2 > a').html(imgTag_pt1 + feature_image_2 + imgTag_pt2);
  $('li#spotlight-slider-3 > a').html(imgTag_pt1 + feature_image_3 + imgTag_pt2);
}