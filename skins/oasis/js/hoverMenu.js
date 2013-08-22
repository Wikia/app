(function(window, $) {

var HoverMenu = function(selector) {

	//Settings
	this.settings = {
		mouseoverDelay: 300,
		mouseoutDelay: 350
	};

	//Timers
	this.mouseoverTimer = null;
	this.mouseoutTimer = null;
	this.mouseoverTimerRunning = false;

	//Variables
	this.event = {};
	this.selector = selector;
	this.menu = $(this.selector);

	// no submenu - leave here
	if (!this.menu.find('ul').exists()) {
		$().log('skipping ' + this.selector, 'HoverMenu');
		return;
	}

	//Events
	this.menu.children("li").hover($.proxy(this.mouseover, this), $.proxy(this.mouseout, this));

	//Accessibility
	//Show when any inner anchors are in focus
	this.menu.children("li").children("a").focus($.proxy(function(event) {
		this.hideNav();
		this.showNav($(event.currentTarget).closest("li"));
	}, this));

	this.menu.find(".subnav a").focus($.proxy(function(event) {
		this.hideNav();
		this.showNav($(event.currentTarget).closest(".subnav").closest("li"));
	}, this));

	//Hide when focus out of first and last anchor
	this.menu.children("li").first().children("a").focusout($.proxy(this.hideNav, this));
	this.menu.find(".subnav>li:last-child li:last-child a").focusout($.proxy(this.hideNav, this));
};

var globalNavigationMenusCached = false;
HoverMenu.prototype.mouseover = function(event) {
	this.event = event;

	//Hide all subnavs except for this one
	this.menu.children("li").children("ul").not($(event.currentTarget).find("ul")).removeClass("show");

	//Cancel mouseoutTimer
	clearTimeout(this.mouseoutTimer);

	this.handleShowNav(event);
};

HoverMenu.prototype.handleShowNav = function(event) {

	// Mouse is not coming from within the nav.
	if ($(event.relatedTarget).closest(this.selector).length == 0) {

		//Delay before showing subnav.
		var currentTarget = event.currentTarget;
		this.mouseoverTimer = setTimeout($.proxy(function() {
			this.showNav(currentTarget);
		}, this), this.settings.mouseoverDelay);

		this.mouseoverTimerRunning = true;

	//Mouse IS coming from within the nav
	} else {

		//Don't show subnavs when quickly moving mouse horizontally through wiki nav
		if (this.mouseoverTimerRunning) {

			//Stop current timer
			clearTimeout(this.mouseoverTimer);

			//Start new timer
			this.mouseoverTimer = setTimeout($.proxy(function() {
				this.showNav(event.currentTarget);
			}, this), this.settings.mouseoverDelay);

		//Mouseover timer isn't running, so show subnavs immediately
		} else {
			this.showNav(event.currentTarget);
		}
	}
};

HoverMenu.prototype.mouseout = function(event) {
	this.event = event;

	//Mouse has exited the nav.
	if ($(event.relatedTarget).closest(this.selector).length == 0) {

		//Stop mouseoverTimer
		clearTimeout(this.mouseoverTimer);
		this.mouseoverTimerRunning = false;

		//Start mouseoutTimer
		this.mouseoutTimer = setTimeout($.proxy(function() {
			this.hideNav();
		}, this), this.settings.mouseoutDelay);

	//Mouse is still within the nav
	} else {

		//Hide nav immediately
		this.hideNav();
	}
};

HoverMenu.prototype.showNav = function(parent) {
	var nav = $(parent).children('ul');
	window.HoverMenuGlobal.hideAll();
	this.mouseoverTimerRunning = false;

	if (nav.exists()) {
		nav.addClass("show");
	}
};

HoverMenu.prototype.hideNav = function() {
	this.menu.find(".subnav").removeClass("show");
};

/**
 * static singleton that holds all menu instances in skin, and the utility functions
 * push new instance to menus[] if need be, be sure to implement hideNav()
 */
var HoverMenuGlobal = {
	menus: [],
	hideAll: function() {
		var menus = HoverMenuGlobal.menus;
		for(var i = 0; i < menus.length; i++) {
			menus[i].hideNav();
		}
	}
};

$(function() {
	//Create instances of HoverMenu
	HoverMenuGlobal.menus.push(new HoverMenu("#AccountNavigation"));
	HoverMenuGlobal.menus.push(new HoverMenu("#WallNotifications"));
	//Accessbility
	$("div.skiplinkcontainer a").focus(function(evt) {
		$("body").data("accessible", "true");
		$("#WikiHeader .subnav").show();
	});
});

// Exports
window.HoverMenu = HoverMenu;
window.HoverMenuGlobal = HoverMenuGlobal;

})(this, jQuery);
