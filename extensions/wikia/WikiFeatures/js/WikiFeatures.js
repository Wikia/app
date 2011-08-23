var WikiFeatures = {
	init: function() {
		WikiFeatures.sliders = $('#WikiFeatures .slider');
		WikiFeatures.sliders.find('.button').click(e) {
			var el = $(this).closest('.slider');
			el.toggleClass('on');
		}
	}
};

$(function() {
	WikiFeatures.init();
});