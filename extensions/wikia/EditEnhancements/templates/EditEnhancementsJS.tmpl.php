<script type="text/javascript">

EditEnhancements = function() {
	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;
	jQuery.noConflict();

	this.calculate = function() {
		if (document.getElementById('wpTextbox1___Frame')) {
			textbox = 'wpTextbox1___Frame';
		} else {
			textbox = 'wpTextbox1';
		}

		viewport = Dom.getViewportHeight();
		textareaTop = jQuery("#" + textbox).offset().top;
		toolbar = jQuery("#edit_enhancements_toolbar").outerHeight(true);
		heightDiff = jQuery("#" + textbox).outerHeight(true) - jQuery("#" + textbox).height();
		
		targetHeight = viewport - textareaTop - toolbar - heightDiff + 'px';
		if (parseInt(targetHeight) > 200) {
			Dom.setStyle(textbox, 'height', targetHeight);
		}
	}
	
	this.calculate();
}

YAHOO.util.Event.on(window, 'load', EditEnhancements);
YAHOO.util.Event.on(window, 'resize', EditEnhancements);
</script>
