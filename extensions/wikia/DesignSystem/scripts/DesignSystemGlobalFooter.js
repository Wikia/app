require(['jquery', 'wikia.geo', 'wikia.log'],
	function ($, geo, log) {

		if ($.cookie('useskin') === 'oasis')  {
			$('.mobile-site-link')
				.click(mobileSiteLinkClicked)
				.addClass("mobile-site-link--active");
		}

		function mobileSiteLinkClicked(){
			$.cookie("useskin", null, {path: '/', domain: wgCookieDomain});
		}

		if (!(geo.getCountryCode() === 'US' && geo.getRegionCode() === 'CA')) {
			log('Hiding "Do Not Sell My Info" link outside of US-CA.', log.levels.debug, 'us-privacy');

			var links = $('section.wds-global-footer__section.wds-is-community a[data-tracking-label="community.usp-do-not-sell"]');

			if (links.length > 0) {
				links[0].closest('li').remove();
			}
		}
	}
);
