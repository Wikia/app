var WikiHeader = {
	isDisplayed: false,

	settings: {
		mouseoverDelay: 300,
		mouseoutDelay: 350
	},

	init: function() {

		//Variables
		WikiHeader.nav = $("#WikiHeader").children("nav");
		WikiHeader.subnav = WikiHeader.nav.find(".subnav");
		WikiHeader.mouseoverTimerRunning = false;

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
                
                // IE9 focus handling fix - see BugId:5914.
                // Assume keyboard-based navigation (IE9 focus handling fix).
                var suppressOnFocus = false;
                
		WikiHeader.subnav.find("a")
                    // Switch to browser's default onfocus behaviour when mouse-based navigation is detected  (IE9 focus handling fix).
                    .bind('mousedown', function() { suppressOnFocus = true; })
                    // Switch back to keyboard-based navigation mode  (IE9 focus handling fix).
                    .bind('mouseup', function() { suppressOnFocus = false; })
                    // The onfocus behaviour intended only for keyboard-based navigation (IE9 focus handling fix).
                    .focus(function(event) {
                        if ( !suppressOnFocus ) {
                            WikiHeader.hideNav();
                            WikiHeader.showSubNav($(event.currentTarget).closest(".subnav").parent("li"));
                        }
                    });
		//Hide when focus out of first and last anchor
		WikiHeader.nav.children("ul").find("li:first-child a").focusout(WikiHeader.hideNav);
		WikiHeader.subnav.last().find("li:last-child a").focusout(WikiHeader.hideNav);

		//Mouse out of browser
		$(document).mouseout(function(e){
			if(WikiHeader.isDisplayed) {
				var from = e.relatedTarget || e.toElement;
				if(!from || from.nodeName == 'HTML'){
					WikiHeader.hideNav();
				}
			}
		});
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
			WikiHeader.isDisplayed = true;
			subnav.css("top", WikiHeader.navtop).show();
			$.hideAds();

			$.tracker.byStr('wikiheader/wikinav/open');
		}
	},

	hideNav: function() {
		WikiHeader.isDisplayed = false;
		//Hide subnav
		if($('body').data('accessible')) {
			WikiHeader.subnav.css("top", "-9999px");
		} else {
                    WikiHeader.subnav.css("display", "none");
		}
		$.showAds();
	},

	positionNav: function() {
		//This runs once. Sets the proper top position of the subnav. Can't be calculated earlier because custom font loading can adjust wiki nav height.
		WikiHeader.navtop = WikiHeader.nav.height();
	}

};

$(function() {
	WikiHeader.init()
});