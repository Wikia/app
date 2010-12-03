$(function() {
	WikiaWideTables.init();
});

WikiaWideTables = {
	
	settings: {
		article: $("#WikiaArticle"),
		tables: new Array()
	},
	
	init: function() {	
		//Get tables
		WikiaWideTables.getTables();
		
		if (WikiaWideTables.settings.tables.length) {
		
			//Add styling
			$.each(WikiaWideTables.settings.tables, function() {
				var table = this;
				var wrapper;
		
				//Add wrapper for overflow
				wrapper = table.wrap('<div class="WikiaWideTablesWrapper"><div class="table"></div></div>').parent().parent();
		
				//Add expand button
				$('<img src="' + stylepath + '/common/blank.gif" class="sprite popout">').click(WikiaWideTables.makeModal).prependTo(wrapper);
				
				//If table is too wide, add jagged edge styling
				if (table.attr("data-overflow") == "true") {
					//$('<div class="jagged"></div>').prependTo(wrapper).css("height", wrapper.height());
										
					var canvas = $('<canvas></canvas>').prependTo(wrapper);
					if (canvas.get(0).getContext) {
						var context = canvas.get(0).getContext("2d");
					
						canvas
							.css({
								position: "absolute",
								right: 0,
								top: 0
							})
							.attr("width", 15)
							.attr("height", wrapper.height());
						
						
						var y = 0;
						var x = 15;
						context.moveTo(x, y);
						while (y < canvas.height()) {
							x = 6;
							y += 17;
							context.lineTo(x, y); 
							x = 13;
							y += 21;
							context.lineTo(x, y); 
							x = 0;
							y += 21;
							context.lineTo(x, y); 
							x = 10;
							y += 19;
							context.lineTo(x, y); 
							x = 3;
							y += 18;
							context.lineTo(x, y); 
							x = 15;
							y += 27;
							context.lineTo(x, y); 
						}
			
						context.fillStyle = $("#WikiaPage").css("background-color"); 
						context.fill();
					} else {
						//This is a browser that can't draw in canvas
						canvas.remove();
						wrapper.addClass("border");
					}
				}

			});
			
			//Add scroll magic to popout buttons
			$(window).scroll(WikiaWideTables.popoutScrolling);
			
		}
	},
	
	getTables: function() {
		WikiaWideTables.settings.article.find("table").each(function() {
			table = $(this);
			
			//Is table wider than article area?
			if (table.width() > WikiaWideTables.settings.article.width()) {
				table.attr("data-overflow", "true");
			}
			
			WikiaWideTables.settings.tables.push(table);
			
		});
	
	},
	
	//This function is called by the "expand" button
	makeModal: function(event) {
		table = $(event.currentTarget).next(".table").children("table:first");
		table.clone().makeModal({
			id: "ModalTable",
			width: $(window).width() - 100
		});
		$("#ModalTable .modalContent").css({
			overflow: "auto",
			height: $(window).height() - 150
		});
	},
	
	popoutScrolling: function() {
		$(".WikiaWideTablesWrapper > .popout").each(function() {
			var popout = $(this);
			var wrapper = popout.parent();
			var tableTop = wrapper.offset().top;
			var tableBottom = tableTop + wrapper.height();
			var scrolledBy = $(window).scrollTop();

			if (scrolledBy > tableTop && scrolledBy < tableBottom && popout.css("position") == "absolute") {
				//Top of the table was just scrolled out of view - float the popout
				popout
					.css("margin-left", popout.offset().left - ($(window).width()/2))
					.addClass("float");				
			} else if ( (scrolledBy < tableTop || scrolledBy > tableBottom) && popout.hasClass("float")) {
				//Top of the table was just scrolled back into view or table was fully scrolled out of view - stop floating the popout
				popout
					.css("margin-left", "auto")
					.removeClass("float");				
			}
		});
	}
	
};