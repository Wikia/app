EditEnhancementsPreview = {
		
	/**
	 *  Run once ondomready
	 */
	init: function() {	
		/* Repostion elements in layout */
		$('<div id="edit_enhancements_toolbar"><ul>').insertBefore("#editpage-copywarn");
		var elements = ["#wpSave", "#wpPreview", /* plb */ "#wpDraft", "#wpPreviewform", "#wpPreviewarticle" ];
		
		// NS_3 is User_Talk and shouldn't have the summary field and label repositioned.
		if (wgNamespaceNumber != 3) {
			elements.unshift("#wpSummaryLabel", "#wpSummary");
		}
		
		$(elements.join(",")).each(function() {
			$(this).wrap("<li>").parent().appendTo("#edit_enhancements_toolbar ul");
		});
		// Checkboxes are done outside of each loop because it must appear last, but isn't last in original layout.
		$(".editCheckboxes").removeClass().wrap('<li class="editCheckboxes">').parent().appendTo("#edit_enhancements_toolbar ul");
		// Add scroll down arrow
		$('<li id="scroll_down_arrow"><span onclick="window.scrollTo(0,document.getElementById(\'editform\').offsetTop);WET.byStr(\'EditEnhancements/scrollArrow\');">&darr;</span></li>').appendTo("#edit_enhancements_toolbar ul");
	
		EditEnhancementsPreview.calculate();

		// Bind events
		$(window).bind({
			'resize': EditEnhancementsPreview.calculate,
			'scroll': EditEnhancementsPreview.calculate
		});
	},
	

	calculate: function() {
		var editBarHeight = $('#edit_enhancements_toolbar').outerHeight();
		var scrollBottomOffset = $(document).scrollTop() + $(window).height();

		if (typeof FCK == 'undefined') {
			textAreaOffset = $('#wpTextbox1').offset().top + $('#wpTextbox1').outerHeight();
		} else {
			textAreaOffset = $('#wpTextbox1___Frame').offset().top + $('#wpTextbox1___Frame').outerHeight();
		}

		if (typeof RTE  == 'object') {
			if ($('#cke_wpTextbox1').offset() == null) return;
			textAreaOffset = $('#cke_wpTextbox1').offset().top + $('#cke_wpTextbox1').outerHeight();
		}

		// choose positioning method
		if ( scrollBottomOffset < (textAreaOffset + editBarHeight + 8) ) {
			bodyContentLeft = $( window.skin == 'oasis' ? '#WikiaArticle' : "#bodyContent" ).offset().left;
			bodyContentWidth = $( window.skin == 'oasis' ? '#WikiaArticle' : "#bodyContent" ).width();
			widthDiff = $("#edit_enhancements_toolbar").outerWidth(true) - $("#edit_enhancements_toolbar").width();

			$("#edit_enhancements_toolbar").css({'left' : bodyContentLeft + 'px', 'width' : parseInt(bodyContentWidth) - parseInt(widthDiff) + 'px'}).removeClass('edit_enhancements_toolbar_static').addClass('edit_enhancements_toolbar_fixed');

			// add margin-top to #editpage-copywarn to keep the same scroll height
			$('#editpage-copywarn').css('marginTop', editBarHeight + 10 + 'px');

		} else {
				
			$("#edit_enhancements_toolbar").removeClass('edit_enhancements_toolbar_fixed').addClass('edit_enhancements_toolbar_static').css('width', 'auto');

			// remove margin-top from #editpage-copywarn to keep the same scroll height
			$('#editpage-copywarn').css('marginTop', '0px');
		}
	}

};

$(function() {
	EditEnhancementsPreview.init();
});