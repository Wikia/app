$(function() {
	SC.init();
});

var SC = {
	init: function() {
		$("#mw-data-after-content, #content .printfooter, #column-one, #footer, #siteSub, #contentSub, #jump-to-nav, #content div.picture-attribution, #content .toc").remove();
		
		SC.c = $("#bodyContent");
		SC.h = SC.c.find(">h2");
		SC.f = SC.h.first();
		SC.l = SC.h.last();
		
		SC.ct = {};
		var cindex = -1;
		SC.c.contents().each(function(i, el) {
			if (this) {
				if (this.nodeName == 'H2') {
					$(this).before('<div style="clear:both">');
					$(this).append('<a class="showbutton">Show</a>');
					cindex++;
					SC.ct["c"+cindex] = [];
				}
				
				if (this.id && this.id == 'catlinks') {
				} else if (this.nodeName != 'H2' && cindex > -1) {
					SC.ct["c"+cindex].push(this);
					$(this).remove();
				}
			}
		});
		
		SC.b = SC.h.find(".showbutton");
		SC.b.each(function(i, el) {
			$(el).data("c", "c" + i);
		});
		
		SC.b.click(SC.toggle);
	},
	toggle: function(e) {
		e.preventDefault();
		if($(this).data("s")) {
			$(SC.ct[$(this).data("c")]).remove();
			$(this).data("s", false);
			$(this).text("Show");
		} else {
			$(this).closest("h2").after($(SC.ct[$(this).data("c")]));
			$(this).data("s", true);
			$(this).text("Hide");
		}
	}
};