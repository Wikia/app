<script>window.addEventListener('load', function () {
	require(['ads', 'sloth', 'wikia.utils'], function (ads, sloth, $) {
		var MIN_ZEROTH_SECTION_LENGTH = 1000,
			firstSection = document.getElementsByClassName('collSec')[0];

		if(firstSection && $.findPos(firstSection) > MIN_ZEROTH_SECTION_LENGTH){

			firstSection.insertAdjacentHTML('beforebegin', '<div id=wkAdInContent></div>');

			sloth({
				on: document.getElementById('wkAdInContent'),
				threshold: 500,
				callback: function(adWrapper){
					ads.setupSlot({
						name: 'MOBILE_IN_CONTENT',
						size: '300x250',
						wrapper: adWrapper,
						init: function(found){
							if(found){
								adWrapper.className = 'show';
							}
						}
					});
				}
			})
		}
	});
});</script>
