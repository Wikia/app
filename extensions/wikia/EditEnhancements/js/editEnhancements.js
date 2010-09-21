EditEnhancements = function() {
	this.calculate = function() {
		
		if ($('#wpTextbox1___Frame').exists()) { // FCK-editor
			
			var textbox = $('#wpTextbox1___Frame');
		}	
		else if ( $('#cke_contents_wpTextbox1').exists()) { // CKeditor
			var textbox = $('#cke_contents_wpTextbox1');
		}
		
		else  {// MW editor
			var textbox = $('#wpTextbox1');
		}
		
		var toolbar = $('#cke_contents_wpTextbox1');

		var viewportHeight = $(window).height();
		var viewportHeight = window.innerHeight ? window.innerHeight : $(window).height(); // Opera 9.5
					
		var textareaTop = Math.floor(textbox.offset().top);

		var stuff = Array(
		//'#blogInfo', '.blogPostForm',	// @todo blog stuff elements
		'#toolbar', // mediaWiki
		'.cke_top','#csMainContainer','#edit_enhancements_toolbar');
		
		var height = 0;
		$.each( stuff, function(i, l){
			if ($(l).exists()) {
				height += $(l).outerHeight();
			}
		});
		
		var targetHeight = viewportHeight - height;
		
		// limit the height-changes to be within <300, 800>
		targetHeight = Math.min(Math.max(targetHeight, 200), 800);
		
		//set the textbox height
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
		// Bernhard: buggy at the summary box width!
		//summaryBox.width(newSummaryWidth);

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

	// scoll to editor top on load
	
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


/** enables jump to top of the edtir after editor has been loaded **/
$(document).ready(function() {
	if (skin == 'oasis') {
		jumpToEditor();
	}
});


jumpToEditor = function() {
	// TinyMCE enabled
	if ($('.cke_editor').exists()) {
		$('html, body').animate({ scrollTop: $('.cke_editor').eq(0).offset().top }, 1);
	}
	// mediaWiki Editor enabled
	else if ($('#toolbar').exists() && $('#toolbar').is(':visible') == true) {
		$('html, body').animate({ scrollTop: $('#toolbar').eq(0).offset().top }, 1);		
	}
	else {
		var checkForFinalEditorLoad = window.setTimeout('jumpToEditor()', 100);
	}
}

