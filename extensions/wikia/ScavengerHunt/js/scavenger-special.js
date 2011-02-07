var SpecialScavengerHunt = {
	entry: null,

	init: function() {
		SpecialScavengerHunt.entry = $('.scavenger-entry').eq(0).clone();
		SpecialScavengerHunt.entry.find('input').val('');
		$('#gameName').focus();
		$('.scavenger-form').delegate('.scavenger-page-title', 'blur', SpecialScavengerHunt.onPageTitleBlur);
		$('input[name=delete]').bind('click.sumbit', SpecialScavengerHunt.onDeleteClick);
	},

	// console logging
	log: function(msg) {
		$().log(msg, 'SpecialScavengerHunt');
	},

	onPageTitleBlur: function(e) {
		var titles = $('.scavenger-page-title');
		var count = titles.length;
		titles.each(function(i,e) {
			if ($(this).val()) {
				count--;
			}
		});

		if (!count) {
			$('.scavenger-entry').last().after(SpecialScavengerHunt.entry.clone())
		}
	},

	onDeleteClick: function(e) {
		e.preventDefault();
		var button = $(this);
		$.confirm({
			//TODO: add i18n if this extension will be used outside staff group
			content: 'Are you sure to delete this game?',
			onOk: function() {
				button.unbind('.sumbit').click();
			}
		});
	}
};

$(SpecialScavengerHunt.init);