$(function() {
	wikiaSearch_setup();
	homepageFeature_setup(blockArticle);
	$('.staff-hide-link').click(blockArticle);
	makeWikiaButtons();
});


function makeWikiaButtons() {
	//There is no way to provide CSS class for links created in MediaWiki. This function adds appropriate classes and markup to buttons.
	$(".MainArticle-sidebar .create-wiki-container a").wrapInner("<span>").addClass("wikia_button").addClass("primary");
}

//Ajax block article
function blockArticle(e){
	e.preventDefault();
	if (confirm(home2_hide_confirm)) {
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
					me.closest(".page-activity-sources").html(home2_hide_success).closest("li").animate({opacity: 1}, 1500).slideUp();
				} else {
		 			alert(home2_hide_error);
				}
			}
		);
	}
}

function homepageFeature_setup() {
	//timer for automatic homepage spotlight slideshow
	var homepageFeature_timer;

	//random integer, 0-3
	var random = Math.floor(Math.random() * 4);

	//move spotlights
	$(".homepage-spotlight").each(function() {
		$(this).css("left", parseInt($(this).css("left")) - (700 * random));
	});

	//select nav
	$("#homepage-feature-spotlight-" + random).find(".nav").addClass("selected");

	//show description
	$("#homepage-feature-spotlight-" + random).find(".description").show();

	//bind events
	$("#homepage-feature-spotlight .nav").click(function() {
		if($("#homepage-feature-spotlight .homepage-spotlight").queue().length == 0) {
			clearInterval(homepageFeature_timer);
			homepageFeature_scroll($(this));
		}
	});
	homepageFeature_timer = setInterval(homepageFeature_slideshow, 7000);
}

function homepageFeature_slideshow() {
	var current = $("#homepage-feature-spotlight .selected").parent().prevAll().length;
	var next = (current == $("#homepage-feature-spotlight .nav").length - 1) ? 0 : current + 1;
	homepageFeature_scroll($("#homepage-feature-spotlight-" + next).find(".nav"));
}

function homepageFeature_scroll(nav) {
	//setup variables
	var thumb_index = nav.parent().prevAll().length;
	var scroll_by = parseInt(nav.parent().find(".homepage-spotlight").css("left"));
	//set "selected" class
	$("#homepage-feature-spotlight .nav").removeClass("selected");
	nav.addClass("selected");
	//hide description
	$("#homepage-feature-spotlight .description").clearQueue().hide();
	//scroll
	$("#homepage-feature-spotlight .homepage-spotlight").animate({
		left: "-=" + scroll_by
	}, function() {
		$("#homepage-feature-spotlight-" + thumb_index).find(".description").fadeIn();
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
