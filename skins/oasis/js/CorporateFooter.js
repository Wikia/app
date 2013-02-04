(function(){
	/**
	 * If the pageview is generated by a conversion from the mobile skin then show a link to go back to it
	 */

	var corporateFooter = $('footer.CorporateFooter');

	if(Wikia.Cookies.get('mobilefullsite')){
		var linksWrapper = corporateFooter.find('nav ul').first();

		if(linksWrapper.exists()){
			$.getMessages('Oasis-mobile-switch').then(function(resp){
				var mobileSwitch = $('<li><a href="#">' + $.msg('oasis-mobile-site') + '</a></li>');

				mobileSwitch.on('click', function(ev){
					ev.preventDefault();
					ev.stopPropagation();

					Wikia.Cookies.set('mobilefullsite', null);//invalidate cookie

					WikiaTracker.track({
						category: 'corporate-footer',
						action: WikiaTracker.ACTIONS.CLICK_LINK_BUTTON,
						label: 'mobile-switch',
						trackingMethod: 'both'
					});

					Wikia.Querystring().setVal('useskin', 'wikiamobile').addCb().goTo();
				});

				linksWrapper.prepend(mobileSwitch.wrap('<li></li>'));
			});
		}
	}
})();