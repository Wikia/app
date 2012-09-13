var WikiaBar = {
	WIKIA_BAR_BOXAD_NAME: 'WIKIA_BAR_BOXAD_1',
	init: function() {
		//folding the bar
		$('.WikiaBarWrapper .arrow').click(function (e) {
			$('.WikiaBarWrapper').addClass('hidden');
			$('.WikiaBarCollapseWrapper').removeClass('hidden');
			e.preventDefault();
		});
		$('.WikiaBarCollapseWrapper .wikia-bar-collapse').click(function (e) {
			$('.WikiaBarWrapper').removeClass('hidden');
			$('.WikiaBarCollapseWrapper').addClass('hidden');
			e.preventDefault();
		});
		//getting the ad
		this.getAd();
		return true;
	},
	getAd: function() {
		var weeboBoxAd = $(this.WIKIA_BAR_BOXAD_NAME);
		if( weeboBoxAd.hasClass('wikia-ad') == false ) {
			LiftiumOptions.placement = this.WIKIA_BAR_BOXAD_NAME;
			Liftium.callInjectedIframeAd("300x250", document.getElementById(this.WIKIA_BAR_BOXAD_NAME + "_iframe"));
			weeboBoxAd.addClass('wikia-ad');
		}
		return true;
	},
	collapse: function() {
		return true;
	}
};

$(function() {
	WikiaBar.init();
});
