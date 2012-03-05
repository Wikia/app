var WikiaButtons = {
	settings: {
		delay: 350
	},

	init: function(limit) {
		//Variables
		if(typeof limit == 'object') {
			WikiaButtons.menuButtons = $(".wikia-menu-button", limit);	
		} else {
			WikiaButtons.menuButtons = $(".wikia-menu-button");
		}
		
		WikiaButtons.timer = null;

		//Events
		WikiaButtons.add(WikiaButtons.menuButtons);
	},

	add: function( e, opts ) {
		 var defaults = {
		  click: WikiaButtons.click
		 };
		 var s = $.extend({},defaults,opts||{});
		 e.unbind('.wikiabutton')
		  .one("mouseover.wikiabutton", WikiaButtons.setup)
		  .bind('mouseenter.wikiabutton',WikiaButtons.mouseover)
		  .bind('mouseleave.wikiabutton',WikiaButtons.mouseout)
		  .bind('click.wikiabutton',s.click);
	},

	setup: function() {
		//This function is run only once per button
		$(this).data('menu', $(this).find("ul"));
	},

	click: function(event) {
		if(!$(this).attr('disabled')){
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

	clickToggle: function(event) {
		var m = $('>li>ul',$(this));
		if (m.length == 0 || $.contains(m[0],event.target)) {
			return;
		}
		$(this).toggleClass("active");
	},

	mouseover: function() {
		//Stop mouseout timer if running
		clearTimeout(WikiaButtons.timer);
	},

	mouseout: function(event) {
		//Delay before hiding menu
		var dalay = $(event.target).closest('.wikia-menu-button').attr('data-delay');
	
		if((typeof dalay) != 'string') {
			dalay = WikiaButtons.settings.delay;
		}		
		
		WikiaButtons.timer = setTimeout(function() {
			$(event.currentTarget).removeClass("active");
		}, dalay);
	}
};

$(function() {
	WikiaButtons.init();
});