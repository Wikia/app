var RecipesTweaks = {
	init: function() {
		// setup clicks tracking
		$('#add_recipe_tab').find('a').click(function() {
			RecipesTweaks.track('addarecipe');
		});

		$('#recipes_contributed_by').children('a').click(function() {
			RecipesTweaks.track('attribution');
		});

		$('#recipes_searchform').submit(function() {
			RecipesTweaks.track('searchbox/submit');
		});

		$('#user_masthead_tab_savedpages').children('a').click(function() {
			RecipesTweaks.track('savedpages_tab');
		});

		$('#star-rating').find('a').click(function(ev) {
			var target = $(ev.target);
			var rating = target.attr('id').substr(4,1);

			RecipesTweaks.track('rating/' + rating);
		});

		// deleting / unwatching pages on Special:SavedPages
		if(wgCanonicalSpecialPageName == 'SavedPages') {
			$('.recipes_saved_pages').click(function(ev) {
				var target = $(ev.target);

				if(target.is('img')) {
					// "delete" icon
					$.get(target.parent().fadeOut(250).end().prev().attr('href'), {action: "unwatch"});
					RecipesTweaks.track('savedpages_delete');
				}
				else if (target.is('a')) {
					if (target.parent().is('li')) {
						// saved page title
						RecipesTweaks.track('savedpages_item_title');
					}
					else {
						// saved page contributor
						RecipesTweaks.track('savedpages_item_user');
					}
				}
			});
		}
	},
	track: function(url) {
		WET.byStr('newrecipes/' + url)
	}
};

$(RecipesTweaks.init);
