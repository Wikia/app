var WikiaBar = {
	//WEEBO_BOXAD_NAME: 'WEEBO_BOXAD_1',
	WEEBO_BOXAD_NAME: 'INCONTENT_BOXAD_1',
	WEEBO_BOXAD_ANIMATION_TIME: 1000,

	init: function() {
		$('.WikiaBarWrapper .arrow').click(function (e) {
			$('.WikiaBarWrapper').addClass('hidden');
			e.preventDefault();
		});
		/*
		$(this.WEEBO_BOXAD_NAME + '_iframe').ready($.proxy(function() {
			this.animateWeeboBoxAd();
		}, this));
		*/
		this.getAd();
		return true;
	},

	getAd: function() {
		var weeboBoxAd = $(this.WEEBO_BOXAD_NAME);
		if( weeboBoxAd.hasClass('wikia-ad') == false ) {
			LiftiumOptions.placement = this.WEEBO_BOXAD_NAME;
			Liftium.callInjectedIframeAd("300x250", document.getElementById(this.WEEBO_BOXAD_NAME + "_iframe"));
			weeboBoxAd.addClass('wikia-ad');

		}
		return true;
	},

	animateWeeboBoxAd: function() {
		$().log('=========================');
		$().log('=========================');

		var weeboBoxAd = $(this.WEEBO_BOXAD_NAME);
		var weeboBoxAdHeight = weeboBoxAd.height();

		$().log('Before animation...');
		$().log('weeboBoxAd: ' + weeboBoxAd);
		$().log('weeboBoxAdHeight: ' + weeboBoxAdHeight);

		weeboBoxAd.animate({top: '-' + weeboBoxAdHeight + 'px'}, this.WEEBO_BOXAD_ANIMATION_TIME);

		$().log('After animation...');
		$().log('=========================');
		$().log('=========================');
	},

	collapse: function() {
		return true;
	}
};

$(function() {
	WikiaBar.init();
});
