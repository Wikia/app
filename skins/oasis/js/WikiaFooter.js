$(function() {
	WikiaFooterApp.init();
});

WikiaFooterApp = {

	settings: {
		delay: 350,
		float: false
	},

	init: function() {
		WikiaFooterApp.myToolsSetup();

		//Variables
		var footer = $("#WikiaFooter");
		if(footer) {	
			var toolbar = footer.children(".toolbar");
			var windowObj = $(window);
	
			//Scroll Detection
			windowObj.resolvePosition = function() {
				var scroll = windowObj.scrollTop() + windowObj.height();
				var line = 0;
				if(footer.offset()){
					line = footer.offset().top + toolbar.outerHeight();
				}

				//Scrolled past line? Lock that footer!
				if (scroll > line && toolbar.hasClass("float")) {
					WikiaFooterApp.settings.float = false;
					toolbar.removeClass("float").css({
						left: "50%",
						right: "auto"
					});
				} else if (scroll < line && !toolbar.hasClass("float")) {
					toolbar.addClass("float");
					WikiaFooterApp.settings.float = true;
					windowObj.centerBar();
				}
			};
						
			//Resize Detection
			windowObj.resize(function() {
				//Resizing should run all functions bound to scrolling because the location of "the fold" is changing.
				windowObj.scroll();
				
				windowObj.centerBar();
			});
			
			windowObj.centerBar = function () {
				if (WikiaFooterApp.settings.float) {
					var viewport = parseInt($(window).width());
					var page = parseInt($("#WikiaPage").width());
					var edge = Math.ceil((viewport - page) / 2) - 5; //ribbon effect offsets width by 5
					
					if (edge < -5) {
						edge = -5;
					}
					
					toolbar.css({
						left: edge,
						right: edge
					});
				}
			};

			windowObj.resolvePosition();
			
			windowObj.scroll(windowObj.resolvePosition);
		}
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
			}, WikiaFooterApp.settings.delay);
		});

	}

};