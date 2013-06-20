<script>window.addEventListener('load', function () {
	require(['ads'], function (ads) {

		var firstSection = document.getElementsByClassName('collSec')[0];

		if(firstSection){
			firstSection.insertAdjacentHTML('beforebegin', '<div id=wkAdInContent></div>');

			ads.setupSlot({
				name: 'MOBILE_TOP_LEADERBOARD',
				size: '300x250',
				wrapper: document.getElementById('wkAdInContent'),
				init: function(){
				}
			});
		}
	});
});</script>
