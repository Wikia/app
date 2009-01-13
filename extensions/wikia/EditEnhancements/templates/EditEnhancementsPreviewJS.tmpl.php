<script type="text/javascript">
EditEnhancementsPreview = function() {
	jQuery.noConflict();

	this.calculate = function() {

		scrollBottomOffset = YAHOO.util.Dom.getDocumentScrollTop() + YAHOO.util.Dom.getViewportHeight();

		if (typeof FCK == 'undefined') {
			textAreaOffset = jQuery('#wpTextbox1').offset().top + jQuery('#wpTextbox1').height();
		}
		else {
			textAreaOffset = jQuery('#wpTextbox1___Frame').offset().top + jQuery('#wpTextbox1___Frame').height();
		}

		// choose positioning method
		if (scrollBottomOffset < textAreaOffset + 50) {
			bodyContentLeft = jQuery("#bodyContent").offset().left;
			bodyContentWidth = jQuery("#bodyContent").width();
			widthDiff = jQuery("#edit_enhancements_toolbar").outerWidth(true) - jQuery("#edit_enhancements_toolbar").width();
	
			jQuery("#edit_enhancements_toolbar").css({'left' : bodyContentLeft + 'px', 'width' : parseInt(bodyContentWidth) - parseInt(widthDiff) + 'px', 'position' : 'fixed', 'bottom' : '0px', 'margin' : '0px', 'z-index' : '500'});
		}
		else {
			jQuery("#edit_enhancements_toolbar").css({'position' : 'static', 'margin' : '5px 0px', 'width': 'auto'});
		}
	}
	
	this.calculate();
}

YAHOO.util.Event.on(window, 'load',   EditEnhancementsPreview);
YAHOO.util.Event.on(window, 'resize', EditEnhancementsPreview);
YAHOO.util.Event.on(window, 'scroll', EditEnhancementsPreview);
</script>
