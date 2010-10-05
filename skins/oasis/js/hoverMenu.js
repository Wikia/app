$(function() {
	//Create instances of HoverMenu
	new HoverMenu("#GlobalNavigation");
	new HoverMenu("#AccountNavigation");
});

HoverMenu = function(selector) {

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
	this.ads = $(".wikia-ad:first", "#WikiaPage").add(".wikia-ad:first", "#WikiaRail");

	//Events
	$(selector).children("li").hover($.proxy(this.mouseover, this), $.proxy(this.mouseout, this));

	//Accessibility
	//Show when any inner anchors are in focus
	$(selector).children("li").children("a").focus($.proxy(function(event) {
		this.hideNav();
		this.showNav($(event.currentTarget).closest("li"));
	}, this));
	$(selector).find(".subnav a").focus($.proxy(function(event) {
		this.hideNav();
		this.showNav($(event.currentTarget).closest(".subnav").closest("li"));
	}, this));
	//Hide when focus out of first and last anchor
	$(selector).children("li").first().children("a").focusout($.proxy(function() {
		this.hideNav();
	}, this));
	$(selector).find(".subnav>li:last-child li:last-child a").focusout($.proxy(function() {
		this.hideNav();
	}, this));
};

HoverMenu.prototype.mouseover = function(event) {

	var self = this;

	//Hide all subnavs except for this one
	$(this.selector).children("li").children("ul").not($(event.currentTarget).find("ul")).removeClass("show");

	//Cancel mouseoutTimer
	clearTimeout(this.mouseoutTimer);

	if ($(event.relatedTarget).closest(this.selector).length == 0) {
		//Mouse is not coming from within the nav.

		//Delay before showing subnav.
		this.mouseoverTimer = setTimeout(function() {
			self.showNav(event.currentTarget);
			self.mouseoverTimerRunning = false;
		}, this.settings.mouseoverDelay);
		this.mouseoverTimerRunning = true;

	} else {
		//Mouse IS coming from within the nav

		//Don't show subnavs when quickly moving mouse horizontally through wiki nav
		if (this.mouseoverTimerRunning) {

			//Stop current timer
			clearTimeout(this.mouseoverTimer);
			this.mouseoverTimerRunning = false;

			//Start new timer
			this.mouseoverTimer = setTimeout(function() {
				self.showNav(event.currentTarget);
			}, this.settings.mouseoverDelay);
			this.mouseoverTimerRunning = true;

		} else {
			//Mouseover timer isn't running, so show subnavs immediately
			this.showNav(event.currentTarget);
		}
	}

};

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
			//self.ads.css("visibility", "visible");
		}, this.settings.mouseoutDelay);

	} else {
		//Mouse is still within the nav

		//Hide nav immediately
		$(event.currentTarget).children("ul").removeClass("show");
		//self.ads.css("visibility", "visible");
	}

};

HoverMenu.prototype.showNav = function(parent) {
	var nav = $(parent).children('ul');

	if (nav.exists()) {
		nav.addClass("show");
		//this.ads.css("visibility", "hidden");

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
	$(this.selector).find(".subnav").removeClass("show");
};
