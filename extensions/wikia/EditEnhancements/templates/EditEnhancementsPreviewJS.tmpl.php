<script type="text/javascript">
EditEnhancementsPreview = {

	timestamp: 0,

	calculate: function() {
		var editBarHeight = $('#edit_enhancements_toolbar').outerHeight();
		var scrollBottomOffset = $(document).scrollTop() + $.getViewportHeight();

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
			bodyContentLeft = $( window.skin == 'oasis' ? '#WikiaArticle' : "#bodyContent" ).offset().left;
			bodyContentWidth = $( window.skin == 'oasis' ? '#WikiaArticle' : "#bodyContent" ).width();
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
		var toolbar = $('#edit_enhancements_toolbar');
		var items = toolbar.find('li');
		var summaryBox = $('#wpSummaryEnhanced');
		var itemsWidth = 0;

		items.each(function() {
			var item = $(this);

			// on Oasis "minor edit" checkbox is below summary field
			if (window.skin == 'oasis' && item.hasClass('minor')) {
				return false;
			}

			itemsWidth += item.innerWidth() + 5;
		});
		itemsWidth -= summaryBox.innerWidth();

		var newSummaryWidth =  (toolbar.innerWidth() - 10) - itemsWidth - 10;

		// limit the width of summary box to be within <200, 500>
		newSummaryWidth = Math.min(Math.max(newSummaryWidth, 200), 500);
		summaryBox.width(newSummaryWidth);
	},

	onEvent: function() {
		var self = EditEnhancementsPreview;

		// update timestamp - do interval for next x miliseconds
		self.timestamp = (new Date()).getTime() + 1*1000

		// recalculate position
		self.calculate();

		// start interval for smooth scrolling
		if (!$.browser.msie) {
			if (!self.interval) {
				self.interval = setInterval(self.loop, 25);
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

$(function() {
	// change the id of summary box, so changing its size works in IE
	$('#wpSummary').attr('id', 'wpSummaryEnhanced');

	EditEnhancementsPreview.onEvent();

	$(window).bind({
		'resize': EditEnhancementsPreview.onEvent,
		'scroll': EditEnhancementsPreview.onEvent
	});
});
</script>
