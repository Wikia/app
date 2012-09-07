var WikiaBar = {
	init: function() {
		$('.WikiaBarWrapper .arrow').click(function (e) {
			$('.WikiaBarWrapper').addClass('hidden');
			e.preventDefault();
		});
		return true;
	},
	getAd: function() {
		return true;
	},
	collapse: function() {
		return true;
	}
};

$(function() {
	WikiaBar.init();
});
