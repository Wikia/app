<script>window.addEventListener('load', function () {
var MIN_ZEROTH_SECTION_LENGTH = 700,
	MIN_PAGE_LENGTH = 2000;

require(['ads', 'sloth', 'jquery', 'JSMessages'], function (ads, sloth, $, msg) {
	var $firstSection = $('.collSec').first(),
		$footer = $('#wkMainCntFtr'),
		firstSectionTop = ($firstSection.length && $firstSection.offset().top) || 0,
		showInContent = firstSectionTop > MIN_ZEROTH_SECTION_LENGTH,
		showBeforeFooter = document.height > MIN_PAGE_LENGTH || firstSectionTop < MIN_ZEROTH_SECTION_LENGTH,
		loading = false,
		lazyLoadAd = function(elem, slotName){
			sloth({
				on: elem,
				threshold: 200,
				callback: function onEnter(adWrapper){
					if(!loading) {
						//Do not load both ads at the same time
						//postscribe cant handle that, as a matter of fact nothing can
						loading = true;

						ads.setupSlot({
							name: slotName,
							size: '300x250',
							wrapper: adWrapper,
							init: function onInit(found){
								if(found) {
									adWrapper.innerHTML += '<label class="wkAdLabel inContent">' + msg('wikiamobile-ad-label') + '</label>';
									adWrapper.className += ' show';
								}

								loading = false;
							}
						});
					} else {
						lazyLoadAd(elem, slotName);
					}
				}
			})
		};

	if(showInContent && Wikia.AbTest && ['A', 'C', 'D', 'F'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS")) != -1){
		$firstSection.before('<div id=wkAdInContent class=ad-in-content />');
		lazyLoadAd(document.getElementById('wkAdInContent'), 'MOBILE_IN_CONTENT');
	}

	if(showBeforeFooter && Wikia.AbTest && ['F'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS")) != -1){
		$footer.after('<div id=wkAdBeforeFooter class=ad-in-content />');
		lazyLoadAd(document.getElementById('wkAdBeforeFooter'), 'MOBILE_PREFOOTER');
	}

	sloth();
});
});</script>
