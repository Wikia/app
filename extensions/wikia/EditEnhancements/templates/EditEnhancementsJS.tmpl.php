<script type="text/javascript">

EditEnhancements = function() {

	this.calculate = function() {
		// rescale textbox
		if (document.getElementById('wpTextbox1___Frame')) {
			// FCK
			var textbox = $('#wpTextbox1___Frame');
		}
		else if (document.getElementById('cke_contents_wpTextbox1')) {
			// CKeditor
			var textbox = $('#cke_contents_wpTextbox1');
		}
		else {
			// MW editor
			var textbox = $('#wpTextbox1');
		}

		var toolbar = $('#edit_enhancements_toolbar');

		// resize edit box
		var viewport = $.getViewportHeight();
		var textareaTop = parseInt(textbox.offset().top);

		//count height of elements between bottom of textarea and top of EditEnhancements box
		var otherStuff = parseInt(toolbar.offset().top) - (textareaTop + textbox.height());
		//var heightDiff = $("#" + textbox).outerHeight(true) - $("#" + textbox).height();
		//+4 is for extra margin
		var targetHeight = viewport - textareaTop - toolbar.outerHeight(true) - otherStuff + 4;

		// limit the height to be within <300, 800>
		targetHeight = Math.min(Math.max(targetHeight, 300), 800);
		textbox.height(targetHeight);

		// rescale summary box
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

		// inform RTE that its editarea has been resized (RT#36994)
		if (typeof window.RTE !='undefined' && typeof window.RTE.instance == 'object') {
			RTE.instance.fire('resize');
		}
	}

	this.calculate();
}

EditEnhancementsLoad = function() {
	var EditEnhancementsLoop = function() {
		if (count == 3) {
			clearInterval(interval);
		} else {
			EditEnhancements();
			count++;
		}
	}
	var count = 0;

	// change the id of summary box, so changing its size works in IE
	$('#wpSummary').attr('id', 'wpSummaryEnhanced');

	var interval = setInterval(EditEnhancementsLoop, 500);

	// modifications for Oasis
	if (window.skin == 'oasis') {
		var toolbar = $('#edit_enhancements_toolbar');
		var toolbarItems = toolbar.children().children('li');

		// fix left margin of "minor" checkbox
		toolbarItems.filter('.minor').
			css('marginLeft', $('#wpSummaryLabel').width() + 5);

		// changes for "Show changes" button
		$('#wpDiff').addClass('secondary');
	}
}

$(window).bind({
	'load': EditEnhancementsLoad,
	'resize': EditEnhancements
});

</script>
