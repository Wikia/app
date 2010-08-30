$(function() {
	WikiaFooter.init();
});

WikiaFooter = {

	settings: {
		delay: 350
	},

	init: function() {

		WikiaFooter.myToolsSetup();

		//Variables
		var footer = $("#WikiaFooter");
		var sharebar = footer.children(".toolbar");
		var windowObj = $(window);

		//float the share bar
		sharebar.addClass("float");

		//scroll detection
		windowObj.scroll(function() {
			var scroll = windowObj.scrollTop() + windowObj.height();
			var line = footer.offset().top + sharebar.outerHeight();

			//Scrolled past line? Lock that footer!
			if (scroll > line && sharebar.hasClass("float")) {
				sharebar.removeClass("float");
			} else if (scroll < line && !sharebar.hasClass("float")) {
				sharebar.addClass("float");
			}
		});

	},

	myToolsSetup: function() {

		var timer = null;

		//share bar click
		$("#WikiaFooter").find(".mytools").children("a, img").click(function(event) {
			event.preventDefault();
			$("#my-tools-menu").toggle();
		});

		$('#WikiaFooter').children(".toolbar").hover(function() {
			clearTimeout(timer);
		}, function() {
			timer = setTimeout(function() {
				$("#my-tools-menu").hide();
			}, WikiaFooter.settings.delay);
		});

	}

};