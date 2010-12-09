$(function() {
	WikiaFooterApp.init();
});

WikiaFooterApp = {

	settings: {
		mouseoverdelay: 300,
		mouseoutdelay: 350,
		float: false
	},

	init: function() {
		WikiaFooterApp.myToolsSetup();

		//Variables
		var footer = $("#WikiaFooter");
		var toolbar = footer.children(".toolbar");

		// avoid stack overflow in IE (RT #98938)
		if (toolbar.exists()) {
			var windowObj = $(window);
			var originalWidth = toolbar.width();

			//Scroll Detection
			windowObj.resolvePosition = function() {
				var scroll = windowObj.scrollTop() + windowObj.height();
				var line = 0;
				if(footer.offset()){
					line = footer.offset().top + toolbar.outerHeight();
				}

				if (scroll > line && toolbar.hasClass("float")) {
					toolbar.removeClass("float");
					windowObj.centerBar();
				} else if (scroll < line && !toolbar.hasClass("float")) {
					toolbar.addClass("float");
					windowObj.centerBar();
				}
			};

			windowObj.centerBar = function() {
				var w = windowObj.width();
				if(w < originalWidth && toolbar.hasClass('float')) {
					toolbar.css('width', w+10);
					if(!toolbar.hasClass('small')){
						toolbar.addClass('small');
					}
				} else if(toolbar.hasClass('small')) {
					toolbar.css('width', originalWidth);
					toolbar.removeClass('small');
				}
				windowObj.resolvePosition();
			};

			windowObj.resolvePosition();
			windowObj.centerBar();
			windowObj.scroll(windowObj.resolvePosition);
			windowObj.resize(windowObj.centerBar);
		}
	},

	myToolsSetup: function() {

		var timer = null;
		var showtimer = null;

		//my tools hover
		$("#WikiaFooter").find(".mytools").children("a, img").hover(function(event) {
			event.preventDefault();
			clearTimeout(timer);
			showtimer = setTimeout(function() {
				$("#my-tools-menu").show();
			}, WikiaFooterApp.settings.mouseoverdelay);
		});

		$('#WikiaFooter').children(".toolbar").hover(function() {
			clearTimeout(timer);
		}, function() {
			clearTimeout(showtimer);
			timer = setTimeout(function() {
				$("#my-tools-menu").hide();
			}, WikiaFooterApp.settings.mouseoutdelay);
		});

	}

};