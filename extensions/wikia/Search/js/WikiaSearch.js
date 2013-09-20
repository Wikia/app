(function($, window) {

var WikiaSearch = {
	init: function() {
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

		$('#mw-search-select-all').click(function(){
			if ($(this).attr('checked')) {
				advancedCheckboxes.attr('checked', 'checked');
			} else {
				advancedCheckboxes.attr('checked', false);
			}
		});
		
		this.initVideoTabEvents();
	},
	initVideoTabEvents: function() {
		var videoFilterOptions = $('.search-filter-sort');

		if(!videoFilterOptions.length) {
			return;
		}
		
		videoFilterOptions.find('.search-filter-sort-overlay').remove();
		
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

			if(isDisabled && categoryOptions.val().length > 0) {
				// Refresh search results
				searchForm.submit();
			}
		});
		
		// If the input isn't handled above, do a form submit
		videoFilterOptions.find('input, select').not(categoryInput.add(filterInputs)).on('change', function() {
			// Refresh search results
			searchForm.submit();		
		});
		
	}
}


$(function() {
	WikiaSearch.init();
});

})(jQuery, this);