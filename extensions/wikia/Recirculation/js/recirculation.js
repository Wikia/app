require([
	'jquery',
	'wikia.window',
	'wikia.log',
	'ext.wikia.recirculation.utils',
	'ext.wikia.recirculation.discussions',
	'ext.wikia.recirculation.helpers.liftigniter',
	require.optional('videosmodule.controllers.rail')
], function ($,
             w,
             log,
             utils,
             discussions,
             liftigniter,
             videosModule) {
	/**
	 *
	 *  var recircModules = [
	 *    {
	 *  		id: 'unique identifier - only used if you want to use data across multiple views',
	 *  		viewModule: 'name of the view',
	 *  		options: {
	 *  			any options to pass to the liftigniter helper
	 *  		}
	 *  	}
	 *  ];
	 *
	 */
	'use strict';

	var recircModules = [
			{
				id: 'LI_rail',
				viewModule: 'ext.wikia.recirculation.views.premiumRail',
				options: {
					max: 5,
					widget: 'wikia-rail',
					source: 'fandom',
					flush: true,
					opts: {
						resultType: 'cross-domain',
						domainType: 'fandom.wikia.com'
					}
				}
			},
			// TODO - remove old recirculation footers
			// {
			// 	id: 'LI_impactFooter',
			// 	viewModule: 'ext.wikia.recirculation.views.impactFooter',
			// 	options: {
			// 		max: 9,
			// 		widget: 'wikia-impactfooter',
			// 		source: 'fandom',
			// 		opts: {
			// 			resultType: 'cross-domain',
			// 			domainType: 'fandom.wikia.com'
			// 		}
			// 	}
			// },
			// {
			// 	id: 'LI_footer',
			// 	viewModule: 'ext.wikia.recirculation.views.footer',
			// 	options: {
			// 		max: 3,
			// 		widget: 'wikia-footer-wiki-rec',
			// 		source: 'wiki',
			// 		title: 'Discover New Wikis',
			// 		width: 332,
			// 		height: 187,
			// 		flush: true,
			// 		opts: {
			// 			resultType: 'subdomain',
			// 			domainType: 'fandom.wikia.com'
			// 		}
			// 	}
			// }
		],
		logGroup = 'ext.wikia.recirculation.experiments.mix',
		// Each view holds an array of promises used to gather data for that view
		views = {},
		// An array of promises to keep track of which views have completed rendering
		completed = [],
		liftigniterHelpers = {};


		discussions();



	fetchFandomReccomendations();
	fetchWikiRecomendationss();

	function fetchFandomReccomendations() {
		var fandomOptions = {
				max: 17,
				widget: 'wikia-rail',
				opts: {
					resultType: 'cross-domain',
					domainType: 'fandom.wikia.com'
				},
			callback: function(resp){
				console.log(resp)
			}
		};

		var deferred = $.Deferred();

		w.$p("register", fandomOptions);

		w.$p('fetch');
	}
	function fetchWikiRecomendationss() {
		var wikiaOptions = {
			max: 17,
			widget: 'footer',
			callback: function(resp){
				console.log(resp)
			}
		};

		var deferred = $.Deferred();

		setTimeout(function() {
			w.$p("register", wikiaOptions);
			w.$p('fetch');
			}, 350)

	}
});
