/**
 * @author Inez Korczynski, Christian Williams
 */
TieDivLibrary = new function() {

	var items = Array();

	this.tie = function(slotname) {
		items.push([slotname]);
	}

	this.calculate = function() {
		for(i = 0; i < items.length; i++) {
			YAHOO.log("slotname: " + items[i][0]);
			jQuery.noConflict();
			if (YAHOO.util.Dom.getStyle(items[i][0], "float") == 'right') {
				jQuery("#" + items[i][0] + "_load").css({
					position: "absolute", 
					top: jQuery("#" + items[i][0]).offset().top, 
					right: YAHOO.util.Dom.getViewportWidth() - jQuery("#" + items[i][0]).offset().left - jQuery("#" + items[i][0]).width()
				});
			} else {
				jQuery("#" + items[i][0] + "_load").css({
					position: "absolute", 
					top: jQuery("#" + items[i][0]).offset().top, 
					left: jQuery("#" + items[i][0]).offset().left
				});
			}
		}
	}

	/*** Recalculation events ***/
	
	//Resize Window
	YAHOO.util.Event.addListener(window, 'resize', function() {
		TieDivLibrary.calculate();
	});
}

