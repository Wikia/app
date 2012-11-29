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
		
		this.initVideoTabEvents();
	},
	initVideoTabEvents: function() {
		var videoRadio = $('#filter-is-video'),
			videoOptions = videoRadio.parent().next(),
			categoryInput = $('#filter-by-category'),
			categoryOptions = categoryInput.parent().next();
			
		$('input[type="radio"][name="filters[]"]').on('change', function() {
			if(videoRadio.is(':checked')) {
				videoOptions
					.slideDown()
					.removeClass('hidden')
					.find('input') // only re-enable inputs, we'll handle the select input separately
					.attr('disabled', false);
			} else {
				videoOptions
					.slideUp()
					.find('input, select') 
					.attr('disabled', true)
					.attr('checked', false);
			}
		}).change();
		

		
		categoryInput.on('change', function() {
			categoryOptions.attr('disabled', !$(this).is(':checked'));
		}).change();
		
	}
}


$(function() {
	WikiaSearch.init();
});

})(jQuery, this);