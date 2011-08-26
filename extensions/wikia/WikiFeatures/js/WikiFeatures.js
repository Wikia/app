var WikiFeatures = {
	init: function() {
		WikiFeatures.sliders = $('#WikiFeatures .slider');
		WikiFeatures.sliders.find('.button').click(function(e) {
			var el = $(this).closest('.slider');
			el.toggleClass('on');
		});
		$('#WikiFeatures .feedback').click(function(e) {
			e.preventDefault();
			var feature = $(this).closest('.feature');
			
		});
	}
};

$(function() {
	WikiFeatures.init();
});
