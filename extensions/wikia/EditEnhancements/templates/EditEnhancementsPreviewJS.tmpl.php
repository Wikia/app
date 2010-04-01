<script type="text/javascript">
EditEnhancementsPreview = {

	timestamp: 0,

	calculate: function() {
		editBarHeight = $('#edit_enhancements_toolbar').outerHeight();
		scrollBottomOffset = YAHOO.util.Dom.getDocumentScrollTop() + YAHOO.util.Dom.getViewportHeight();

		if (typeof FCK == 'undefined') {
			textAreaOffset = $('#wpTextbox1').offset().top + $('#wpTextbox1').outerHeight();
		}
		else {
			textAreaOffset = $('#wpTextbox1___Frame').offset().top + $('#wpTextbox1___Frame').outerHeight();
		}

		if (typeof RTE  == 'object') {
			if ($('#cke_wpTextbox1').offset() == null) return;
			textAreaOffset = $('#cke_wpTextbox1').offset().top + $('#cke_wpTextbox1').outerHeight();
		}
		
		var positionFixed = false;

		// choose positioning method
		if ( scrollBottomOffset < (textAreaOffset + editBarHeight + 8) ) {
			bodyContentLeft = $("#bodyContent").offset().left;
			bodyContentWidth = $("#bodyContent").width();
			widthDiff = $("#edit_enhancements_toolbar").outerWidth(true) - $("#edit_enhancements_toolbar").width();

			$("#edit_enhancements_toolbar").css({'left' : bodyContentLeft + 'px', 'width' : parseInt(bodyContentWidth) - parseInt(widthDiff) + 'px'}).removeClass('edit_enhancements_toolbar_static').addClass('edit_enhancements_toolbar_fixed');

			// add margin-top to #editpage-copywarn to keep the same scroll height
			$('#editpage-copywarn').css('marginTop', editBarHeight + 10 + 'px');

			positionFixed = true;
		}
		else {
			$("#edit_enhancements_toolbar").removeClass('edit_enhancements_toolbar_fixed').addClass('edit_enhancements_toolbar_static').css('width', 'auto');

			// remove margin-top from #editpage-copywarn to keep the same scroll height
			$('#editpage-copywarn').css('marginTop', '0px');
		}

		// fix for IE
		if ($.browser.msie && $.browser.version.substr(0,1)<7) {
			$('#edit_enhancements_toolbar').css( positionFixed ? {
				'left': 	$(document.body).hasClass('editingTips') && !$(document.body).hasClass('editingWide') ? '215px' : 0,
				'position': 	'absolute',
				'top':		(document.documentElement.scrollTop+document.documentElement.clientHeight) - (window.FCK ? 70 : 105),
				'width':	$('#wpTextbox1').width() + 'px'
			} : {
				'position': 	'static'
			});
		}

		// rescale summary box
		var Dom = YAHOO.util.Dom;
		var items = Dom.get('edit_enhancements_toolbar').getElementsByTagName('li');
		var summaryBox = $('#wpSummaryEnhanced');
		var itemsWidth = 0;
		
		for (i=0; i<items.length; i++) {
			itemsWidth += $(items[i]).innerWidth() + 5;
		}

		itemsWidth -= summaryBox.innerWidth();

		var newSummaryWidth =  ($("#edit_enhancements_toolbar").innerWidth() - 10) - itemsWidth - 10;

		newSummaryWidth = Math.max(newSummaryWidth, 200);
		newSummaryWidth = Math.min(newSummaryWidth, 500);

		Dom.setStyle('wpSummaryEnhanced', 'width', newSummaryWidth + 'px');

	},

	onEvent: function() {
		// update timestamp - do interval for next x miliseconds
		this.timestamp = (new Date()).getTime() + 1*1000

		// recalculate position
		this.calculate();

		// start interval for smooth scrolling
		if (!$.browser.msie) {
			if (!this.interval) {
				this.interval = setInterval(this.loop, 25);
			}
		}
	},

	interval: false,

	loop: function() {
		EditEnhancementsPreview.calculate();

		// we're done, clear interval
		if ( EditEnhancementsPreview.timestamp < (new Date()).getTime() ) {
			clearInterval(EditEnhancementsPreview.interval);
			EditEnhancementsPreview.interval = false;
		}
	}
};

YAHOO.util.Event.on(window, 'load',   function() {
	// change the id of summary box, so changing its size works in IE
	$('#wpSummary').attr('id', 'wpSummaryEnhanced');

	EditEnhancementsPreview.onEvent();
});
YAHOO.util.Event.on(window, 'resize', function() {EditEnhancementsPreview.onEvent();});
YAHOO.util.Event.on(window, 'scroll', function() {EditEnhancementsPreview.onEvent();});
</script>
