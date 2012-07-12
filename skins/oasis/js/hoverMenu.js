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

var globalNavigationMenus = [];
HoverMenu.prototype.mouseover = function(event) {
	var li = $(event.currentTarget);

	//Hide all subnavs except for this one
	this.menu.children("li").children("ul").not(li.find("ul")).removeClass("show");

	//Cancel mouseoutTimer
	clearTimeout(this.mouseoutTimer);

	// Lazy load content for Global Navigation (BugId:36973)
	var index = li.data('index');
	if (this.selector == '#GlobalNavigation' && ($.inArray(index, globalNavigationMenus) < 0)) {
		$.nirvana.sendRequest({
			controller: 'GlobalHeaderController',
			method: 'menuItems',
			format: 'html',
			type: 'GET',
			data: {
				index: index
			},
			callback: $.proxy(function(html) {
				li.find('.subnav').html(html);
				globalNavigationMenus.push(index);
				this.handleShowNav(event);
			}, this)
		});

	// Everything else: handle show immediately
	} else {
		this.handleShowNav(event);
	}
};

HoverMenu.prototype.handleShowNav = function(event) {
	var self = this;

	// Mouse is not coming from within the nav.
	if ($(event.relatedTarget).closest(this.selector).length == 0) {

		//Delay before showing subnav.
		this.mouseoverTimer = setTimeout(function() {
			self.showNav(event.currentTarget);
			self.mouseoverTimerRunning = false;
		}, this.settings.mouseoverDelay);
		this.mouseoverTimerRunning = true;

	//Mouse IS coming from within the nav
	} else {

		//Don't show subnavs when quickly moving mouse horizontally through wiki nav
		if (this.mouseoverTimerRunning) {

			//Stop current timer
			clearTimeout(this.mouseoverTimer);

			//Start new timer
			this.mouseoverTimer = setTimeout(function() {
				self.showNav(event.currentTarget);
				self.mouseoverTimerRunning = false;
			}, this.settings.mouseoverDelay);
			this.mouseoverTimerRunning = true;

		//Mouseover timer isn't running, so show subnavs immediately
		} else {
			this.showNav(event.currentTarget);
		}
	}
}

HoverMenu.prototype.mouseout = function(event) {
	var self = this;

	if ($(event.relatedTarget).closest(this.selector).length == 0) {
		//Mouse has exited the nav.

		//Stop mouseoverTimer
		clearTimeout(this.mouseoverTimer);
		this.mouseoverTimerRunning = false;

		//Start mouseoutTimer
		this.mouseoutTimer = setTimeout(function() {
			$(event.currentTarget).children("ul").removeClass("show");
			if (!$(".modalWrapper:visible").length) {
				//no modals are visible. show ads.
				$.showAds();
			}
		}, this.settings.mouseoutDelay);

	} else {
		//Mouse is still within the nav

		//Hide nav immediately
		this.hideNav();
		$.showAds();
	}
};

HoverMenu.prototype.showNav = function(parent) {
	var nav = $(parent).children('ul');
	window.HoverMenuGlobal.hideAll();

	if (nav.exists()) {
		nav.addClass("show");
		$.hideAds();

		// tracking
		switch(this.selector) {
			case '#GlobalNavigation':
				$.tracker.byStr('globalheader/globalnav/open');

				// spotlights displaying
				var i = $(parent).index() + 1;
				if(typeof window["fillIframe_SPOTLIGHT_GLOBALNAV_"+i] == "function") {
					window["fillIframe_SPOTLIGHT_GLOBALNAV_"+i]();
					window["fillIframe_SPOTLIGHT_GLOBALNAV_"+i] = null;
				}
				else if(typeof window["fillElem_SPOTLIGHT_GLOBALNAV_"+i] == "function") {
					window["fillElem_SPOTLIGHT_GLOBALNAV_"+i]();
					window["fillElem_SPOTLIGHT_GLOBALNAV_"+i] = null;
				}

				break;

			case '#AccountNavigation':
				$.tracker.byStr('globalheader/usermenu/open');
				break;
		}
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
	HoverMenuGlobal.menus.push(new HoverMenu("#GlobalNavigation"));
	HoverMenuGlobal.menus.push(new HoverMenu("#AccountNavigation"));
	HoverMenuGlobal.menus.push(new HoverMenu("#WallNotifications"));
	//Accessbility
	$("div.skiplinkcontainer a").focus(function(evt) {
		$("body").data("accessible", "true");
		$("#GlobalNavigation .subnav, #WikiHeader .subnav").show();
	});
});

// Exports
window.HoverMenu = HoverMenu;
window.HoverMenuGlobal = HoverMenuGlobal;

})(this, jQuery);