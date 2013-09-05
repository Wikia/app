// Use the table overflow technique (VE-164)
jQuery(function( $ ) {
	'use strict';

	var $article = $( '#WikiaArticle' ),
		scrollableTemplate = '<div class="table-scrollable" />';

	// Scans tables inside of the article and applies overflow hint styles
	// on any tables that are wider than the article content area.
	function scan() {
		$article.find( '.table-wrapper' ).each(function() {
			var $wrapper = $( this ),
				$table = $wrapper.find( 'table' ),
				isWide = $table.width() > $article.width();

			$wrapper.toggleClass( 'table-is-wide', isWide );

			if ( isWide && !$table.parent( '.table-scrollable' ).length ) {
				$table.wrap( scrollableTemplate );
			}
		});
	}

	scan();

	// Listen for window resizes and check again for wide tables
	$( window ).on( 'resize', $.debounce( 100, scan ) );
});

// TODO: get rid of everything below here once the old table handling method
// is completely phased out (have to wait for article caches to update).
(function($) {
var WikiaWideTables = {
	settings: {
		article: "#WikiaArticle",
		tables: [],
		popouts: null
	},
	article: undefined,

	init: function() {

		var that = this;

		this.article = $(this.settings.article);

		//Get tables
		this.getTables();

		if (this.settings.tables.length) {

			//Add styling
			$.each(this.settings.tables, function() {
				var table = this,
					wrapper;

				// check if we've already handled this table
				if ( table.hasClass('willPopOut') ) {
					return;
				}

				// Note that this table has been processed already
				table.addClass('willPopOut');

				//Add wrapper for overflow
				wrapper = table.wrap('<div class="WikiaWideTablesWrapper"><div class="table"></div></div>').parent().parent();

				//Add expand button
				$('<img src="' + wgBlankImgUrl + '" class="sprite popout">').click(that.makeModal).prependTo(wrapper);

				//If table is too wide, add jagged edge styling
				if (table.attr("data-overflow") == "true") {
					//$('<div class="jagged"></div>').prependTo(wrapper).css("height", wrapper.height());

					var canvas = $('<canvas></canvas>').prependTo(wrapper);
					if (canvas.get(0).getContext) {
						var context = canvas.get(0).getContext("2d"),
							y = 0,
							x = 15;

						canvas
							.css({
								position: "absolute",
								right: 0,
								top: 0
							})
							.attr("width", 15)
							.attr("height", wrapper.height());

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

						context.fillStyle = window.sassParams['color-page'];
						context.fill();
					} else {
						//This is a browser that can't draw in canvas
						canvas.remove();
						wrapper.addClass("border");
					}
				}
			});

			//Add scroll magic to popout buttons
			this.settings.popouts = $(".WikiaWideTablesWrapper > .popout");
			$(window).scroll($.proxy(this.popoutScrolling, this));
		}
	},

	getTables: function() {

		var that = this;

		this.article.find("table").each(function() {
			var table = $(this);

			//Ignore tables using the overflow method
			if (table.parent( '.table-scrollable' ).length ) {
				return;
			}

			//If the table isn't very wide and doesn't have class="popout", ignore it
			if (table.width() <= that.article.width() && !table.hasClass('popout')) {
				return;
			}

			//Is table wider than article area?
			if (table.width() > that.article.width()) {
				table.attr("data-overflow", "true");
			}

			that.settings.tables.push(table);
		});
	},

	//This function is called by the "expand" button
	makeModal: function(event) {
		var table = $(event.currentTarget).next(".table").children("table:first"),
			$sortableTable;
		table.clone().makeModal({
			id: "ModalTable",
			width: $(window).width() - 100
		});
		$("#ModalTable .modalContent").css({
			overflow: "auto",
			height: $(window).height() - 150
		});
		$sortableTable = $( '#ModalTable' ).find( 'table.sortable' );
		if ( $sortableTable.length ) {
			$sortableTable.tablesorter();
		}
	},

	popoutScrolling: function() {
		this.settings.popouts.each(function() {
			var popout = $(this),
				wrapper = popout.parent(),
				tableTop = wrapper.offset().top,
				tableBottom = tableTop + wrapper.height(),
				scrolledBy = $(window).scrollTop();

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

$(function() {
	WikiaWideTables.init();
	$(window).on('wikiaTabClicked', function() {
		WikiaWideTables.init.call(WikiaWideTables);
	});
});

}(jQuery));