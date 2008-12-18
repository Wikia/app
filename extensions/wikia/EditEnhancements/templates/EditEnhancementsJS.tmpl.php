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
		var toolbar = jQuery("#edit_enhancements_toolbar").outerHeight();
		var heightDiff = jQuery("#" + textbox).outerHeight(true) - jQuery("#" + textbox).height();
		
		var targetHeight = viewport - textareaTop - toolbar - heightDiff + 'px';
		if (parseInt(targetHeight) > 200) {
			Dom.setStyle(textbox, 'height', targetHeight);
		}
	}
	
	this.calculate();
}

YAHOO.util.Event.on(window, 'load', EditEnhancements);
YAHOO.util.Event.on(window, 'resize', EditEnhancements);
</script>
