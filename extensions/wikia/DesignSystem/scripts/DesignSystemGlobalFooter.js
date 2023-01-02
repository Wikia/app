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

		if (geo.getCountryCode() !== 'US') {
			log('Hiding "Do Not Sell My Info" link outside of US-CA.', log.levels.debug, 'us-privacy');

			var fandomLinks = $('section.wds-global-footer__section.wds-is-community a[data-tracking-label="community.usp-do-not-sell"]');

			if (fandomLinks.length > 0) {
				fandomLinks[0].closest('li').remove();
			}

			var wikiaOrgLinks = $('footer.wds-global-footer-wikia-org .wds-global-footer-wikia-org__links a[data-tracking-label="community.usp-do-not-sell"]');

			if (wikiaOrgLinks.length > 0) {
				wikiaOrgLinks[0].closest('li').remove();
			}
		}
	}
);
