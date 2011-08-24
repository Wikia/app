var WikiFeatures = {
	init: function() {
		WikiFeatures.sliders = $('#WikiFeatures .slider');
		WikiFeatures.sliders.find('.button').click(function(e) {
			var el = $(this).closest('.slider');
			el.toggleClass('on');
		});
	}
};

$(function() {
	WikiFeatures.init();
});
