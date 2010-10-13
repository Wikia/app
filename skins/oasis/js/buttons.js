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
		//This function is run only once per button
		$(this).data('menu', $(this).find("ul"));
	},

	click: function(event) {
		if(typeof $(this).attr('disabled') === 'undefined'){
			if(event.target.tagName !== 'A'){
				var width = $(this).outerWidth();

				if(width !== $(this).data('prevWidth')){
					$(this).data('prevWidth', width);

					var menu = $(this).data('menu');
					width = width - (parseInt(menu.css('padding-left')) + parseInt(menu.css('padding-right')) + parseInt(menu.css('border-left-width')) + parseInt(menu.css('border-right-width')));

					menu.css("min-width", width);
				}

				$(this).toggleClass("active");
			}
		}
		else{
			event.preventDefault();
			return false;
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