var SpecialScavengerHunt = {
	entry: null,

	init: function() {
		SpecialScavengerHunt.entry = $('.scavenger-entry').clone();
		SpecialScavengerHunt.entry.find('input').val('');
		$('#gameName').focus();
		$('.scavenger-form').delegate('.scavenger-page-title', 'blur', SpecialScavengerHunt.onPageTitleBlur);
	},

	// console logging
	log: function(msg) {
		$().log(msg, 'SpecialScavengerHunt');
	},

	onPageTitleBlur: function(e) {
		var titles = $('.scavenger-page-title');
		var count = titles.length;
		SpecialScavengerHunt.log('count [1]:' + count);
		titles.each(function(i,e) {
			if ($(this).val()) {
				count--;
			}
		});
		SpecialScavengerHunt.log('count [2]:' + count);

		if (!count) {
			$('.scavenger-entry').last().after(SpecialScavengerHunt.entry.clone())
		}
	},
};

$(SpecialScavengerHunt.init);