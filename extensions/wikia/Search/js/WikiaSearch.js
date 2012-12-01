(function($, window) {

var WikiaSearch = {
	init: function() {
		this.videoFilterOptions = $('.search-filter-sort');

		$('form#powersearch input[name=title]').val('Special:WikiaSearch');
	
		var hiddenInputs = $('input.default-tab-value');
		$('section.AdvancedSearch input[type="checkbox"]').change(function() {
			hiddenInputs.remove();
		});
		
		var advancedDiv = $('#AdvancedSearch'),
			advancedInput = advancedDiv.find('input[name="advanced"]'),
			advancedCheckboxes = advancedDiv.find('input[type="checkbox"]');
			
		$('#advanced-link').on('click', function(e) {
			e.preventDefault();
			advancedDiv.slideToggle('fast', function() {
				var $this = $(this),
					isVisible = $this.is(':visible');
				
				// update hidden input
				advancedInput.val(Number(isVisible));
				
				if(!isVisible) {
					advancedCheckboxes.attr('checked', false);
				}
				
			});
		});
		
		this.initVideoTabEvents();
	},
	initVideoTabEvents: function() {
		if(!this.videoFilterOptions.length) {
			return;
		}
		
		this.videoFilterOptions.find('.search-filter-sort-overlay').remove();
		
		var searchForm = $('#search-v2-form'),
			videoRadio = $('#filter-is-video'),
			videoOptions = videoRadio.parent().next(),
			categoryInput = $('#filter-by-category'),
			categoryOptions = categoryInput.parent().next(),
			filterInputs = $('input[type="radio"][name="filters[]"]');
			
		// Show and hide video filter options when radio buttons change. 
		filterInputs.on('change', function() {
			if(videoRadio.is(':checked')) {
				videoOptions
					.find('input') // only re-enable inputs, we'll handle the select input separately
					.attr('disabled', false);
			} else {
				videoOptions
					.find('input, select') 
					.attr('disabled', true)
					.attr('checked', false);
			}
			// Refresh search results
			searchForm.submit();
		});

		// Video wiki categories only
		categoryInput.on('change', function() {
			var isDisabled = !$(this).is(':checked');
			categoryOptions.attr('disabled', isDisabled);
			
			if(isDisabled) {
				// Refresh search results
				searchForm.submit();
			}
		});
		
		// If the input isn't handled above, do a form submit
		this.videoFilterOptions.find('input, select').not(categoryInput.add(filterInputs)).on('change', function() {
			// Refresh search results
			searchForm.submit();		
		});
		
	}
}


$(function() {
	WikiaSearch.init();
});

})(jQuery, this);