<script type="text/javascript">

EditEnhancementsPreview = function() {
	jQuery.noConflict();

	this.calculate = function() {
		bodyContentLeft = jQuery("#bodyContent").offset().left;
		bodyContentWidth = jQuery("#bodyContent").width();
		widthDiff = jQuery("#edit_enhancements_toolbar").outerWidth(true) - jQuery("#edit_enhancements_toolbar").width();

		jQuery("#edit_enhancements_toolbar").css({'left' : bodyContentLeft + 'px', 'width' : parseInt(bodyContentWidth) - parseInt(widthDiff) + 'px', 'position' : 'fixed', 'bottom' : '0px', 'margin' : '0px', 'z-index' : '500'});
	}
	
	this.calculate();
}

YAHOO.util.Event.on(window, 'load', EditEnhancementsPreview);
YAHOO.util.Event.on(window, 'resize', EditEnhancementsPreview);
</script>
