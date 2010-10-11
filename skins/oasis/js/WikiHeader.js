$(function() {
	WikiHeader.init()
});

var WikiHeader = {

	settings: {
		mouseoverDelay: 300,
		mouseoutDelay: 350
	},

	init: function() {

		//Variables
		WikiHeader.nav = $("#WikiHeader").children("nav");
		WikiHeader.subnav = WikiHeader.nav.find(".subnav");
		WikiHeader.mouseoverTimerRunning = false;
		WikiHeader.ads = $("#WikiaRail").find(".wikia-ad").first();
		
		WikiHeader.positionNav();

		//Events
		WikiHeader.nav.children("ul").children("li")
			.hover(WikiHeader.mouseover, WikiHeader.mouseout)
			.children("a").focus(function(){
				WikiHeader.hideNav();
				WikiHeader.showSubNav($(this).parent("li"));
			});
			
		//Accessibility Events
		//Show when any inner anchors are in focus
		WikiHeader.subnav.find("a").focus(function(event) {
			WikiHeader.hideNav();
			WikiHeader.showSubNav($(event.currentTarget).closest(".subnav").parent("li"));
		});
		//Hide when focus out of first and last anchor
		WikiHeader.nav.children("ul").find("li:first-child a").focusout(WikiHeader.hideNav);
		WikiHeader.subnav.last().find("li:last-child a").focusout(WikiHeader.hideNav);
	},

	mouseover: function(event) {

		//Hide all subnavs except for this one
		var otherSubnavs = WikiHeader.subnav.not($(this).find(".subnav"));
		if($('body').data('accessible')) {
			otherSubnavs.css("top", "-9999px");
		} else {
			otherSubnavs.hide();
		}

		//Cancel mouseoutTimer
		clearTimeout(WikiHeader.mouseoutTimer);

		if ($(event.relatedTarget).closest("#WikiHeader nav li").length == 0) {
			//Mouse is not coming from within the nav.

			//Delay before showing subnav.
			WikiHeader.mouseoverTimer = setTimeout(function() {
				WikiHeader.showSubNav(event.currentTarget);
				WikiHeader.mouseoverTimerRunning = false;
			}, WikiHeader.settings.mouseoverDelay);
			WikiHeader.mouseoverTimerRunning = true;

		} else {
			//Mouse IS coming from within the nav

			//Don't show subnavs when quickly moving mouse horizontally through wiki nav
			if (WikiHeader.mouseoverTimerRunning) {
				//Stop current timer
				clearTimeout(WikiHeader.mouseoverTimer);
				WikiHeader.mouseoverTimerRunning = false;

				//Start new timer
				WikiHeader.mouseoverTimer = setTimeout(function() {
					WikiHeader.showSubNav(event.currentTarget);
				}, WikiHeader.settings.mouseoverDelay);
				WikiHeader.mouseoverTimerRunning = true;

			} else {
				//Mouseover timer isn't running, so show subnavs immediately
				WikiHeader.showSubNav(this);
			}
		}

	},

	mouseout: function(event) {

		if ($(event.relatedTarget).closest("#WikiHeader nav li").length == 0) {
			//Mouse has exited the nav.

			//Stop mouseoverTimer
			clearTimeout(WikiHeader.mouseoverTimer);
			WikiHeader.mouseoverTimerRunning = false;

			//Start mouseoutTimer
			WikiHeader.mouseoutTimer = setTimeout(WikiHeader.hideNav, WikiHeader.settings.mouseoutDelay);

		} else {
			//Mouse is still within the nav

			//Hide nav immediately
			WikiHeader.hideNav();
		}

	},

	showSubNav: function(parent) {
		var subnav = $(parent).children('ul');

		if (subnav.exists()) {
			subnav.css("top", WikiHeader.navtop).show();
			//WikiHeader.ads.css("visibility", "hidden");

			$.tracker.byStr('wikiheader/wikinav/open');
		}
	},

	hideNav: function() {
		//Hide subnav
		if($('body').data('accessible')) {
			WikiHeader.subnav.css("top", "-9999px");
		} else {
			WikiHeader.subnav.hide();
		}
		//WikiHeader.ads.css("visibility", "visible");
	},

	positionNav: function() {
		//This runs once. Sets the proper top position of the subnav. Can't be calculated earlier because custom font loading can adjust wiki nav height.
		WikiHeader.navtop = WikiHeader.nav.height();
	}

};