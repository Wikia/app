<script type="text/javascript">

EditEnhancements = function() {
	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;
	jQuery.noConflict();

	this.calculate = function() {
		if (document.getElementById('wpTextbox1___Frame')) {
			var textbox = 'wpTextbox1___Frame';
		} else {
			var textbox = 'wpTextbox1';
		}

		var viewport = Dom.getViewportHeight();
		var textareaTop = jQuery("#" + textbox).offset().top;
		var toolbar = jQuery("#edit_enhancements_toolbar").outerHeight(true);
		var heightDiff = jQuery("#" + textbox).outerHeight(true) - jQuery("#" + textbox).height();
		
		var targetHeight = viewport - textareaTop - toolbar - heightDiff + 'px';
		if (parseInt(targetHeight) > 200) {
			Dom.setStyle(textbox, 'height', targetHeight);
		}
	}
	
	this.calculate();
}

EditEnhancementsLoad = function() {
	this.EditEnhancementsLoop = function() {
		if (count == 3) {
			clearInterval(interval);
		} else {
			EditEnhancements();
			count++;
		}
	}
	var count = 0;
	var interval = setInterval("EditEnhancementsLoop()", 500);
}

YAHOO.util.Event.on(window, 'load', EditEnhancementsLoad);
YAHOO.util.Event.on(window, 'resize', EditEnhancements);
</script>
