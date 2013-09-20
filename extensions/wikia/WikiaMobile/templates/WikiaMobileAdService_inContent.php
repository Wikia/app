<script>window.addEventListener('load', function () {
if(Wikia.AbTest && ['A', 'C', 'D'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS")) != -1){
		require(['ads', 'sloth', 'jquery', 'JSMessages'], function (ads, sloth, $, msg) {
			var MIN_ZEROTH_SECTION_LENGTH = 1000,
				$firstSection = $('.collSec');

			if($firstSection.length && $firstSection.offset().top > MIN_ZEROTH_SECTION_LENGTH){

				$firstSection.before('<div id=wkAdInContent />');

				sloth({
					on: document.getElementById('wkAdInContent'),
					threshold: 500,
					callback: function(adWrapper){
						ads.setupSlot({
							name: 'MOBILE_IN_CONTENT',
							size: '300x250',
							wrapper: adWrapper,
							init: function(found){
								if(found) {
									adWrapper.innerHTML += '<label class="wkAdLabel inContent">' + msg('wikiamobile-ad-label') + '<label>';
									adWrapper.className = 'show';
								}
							}
						});
					}
				})
			}
		});
}
});</script>
