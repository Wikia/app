<script type="text/javascript">

EditEnhancementsPreview = function() {
	var Dom = YAHOO.util.Dom;
	var Event = YAHOO.util.Event;
	jQuery.noConflict();

	this.calculate = function() {
		bodyContentLeft = jQuery("#bodyContent").offset().left;
		bodyContentWidth = Dom.getStyle('bodyContent', 'width');
		widthDiff = jQuery("#edit_enhancements_toolbar").outerWidth(true) - jQuery("#edit_enhancements_toolbar").width();

		Dom.setStyle('edit_enhancements_toolbar', 'left', bodyContentLeft + 'px');
		Dom.setStyle('edit_enhancements_toolbar', 'width', parseInt(bodyContentWidth) - parseInt(widthDiff) + 'px');
		Dom.setStyle('edit_enhancements_toolbar', 'position', 'fixed');
		Dom.setStyle('edit_enhancements_toolbar', 'bottom', '0px');
		Dom.setStyle('edit_enhancements_toolbar', 'margin', '0px');
		Dom.setStyle('edit_enhancements_toolbar', 'z-index', '500');
	}
	
	this.calculate();
}

YAHOO.util.Event.on(window, 'load', EditEnhancementsPreview);
YAHOO.util.Event.on(window, 'resize', EditEnhancementsPreview);
</script>
