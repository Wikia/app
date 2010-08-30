$(function() {
	WikiaButtons.init()
});

var WikiaButtons = {

	settings: {
		delay: 350
	},
	
	init: function() {
	
		//Variables
		WikiaButtons.menuButtons = $(".wikia-menu-button");
		WikiaButtons.timer = null;
		
		//Events
		WikiaButtons.menuButtons
			.one("mouseover", WikiaButtons.setup)
			.hover(WikiaButtons.mouseover, WikiaButtons.mouseout)
			.click(WikiaButtons.click);
	},
	
	setup: function() {
		//This function is run only once per button to detect arrow starting position and set menu min-width.
		
		var buttonWidth = $(this).outerWidth();
		
		//Store where the arrow begins (arrow section of menu buttons is 20px wide)
		$(this).data("arrowStart", buttonWidth - 20);
		
		//Store where the button begins
		$(this).data("buttonStart", $(this).offset().left);
		
		//Set min-width of menu, minus 4 for borders
		$(this).find("ul").css("min-width", buttonWidth - 14);
	},

	click: function(event) {
		if (event.pageX > $(this).data("arrowStart") + $(this).data("buttonStart")) {
			//Mouse is on arrow. Show menu.
			$(this).toggleClass("active");
		} else {
			//Mouse is not on arrow. Go to first anchor's href.
			document.location = $(this).find("a").first().attr("href");
		}
	},
	
	mouseover: function() {
	
		//Stop mouseout timer if running
		clearTimeout(WikiaButtons.timer);
		
	},
	
	mouseout: function(event) {

		//Delay before hiding menu
		WikiaButtons.timer = setTimeout(function() {
			$(event.currentTarget).removeClass("active");
		}, WikiaButtons.settings.delay);

	}
	
};