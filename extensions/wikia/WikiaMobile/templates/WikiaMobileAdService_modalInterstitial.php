<script>window.addEventListener('load', function () {
if(~['B', 'C', 'D'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS"))){
	require(['ads'], function (ads) {
		ads.setupSlot({
			name: 'MOBILE_MODAL_INTERSTITIAL',
			size: '300x250',
			wrapper: document.body
		});
	});
}
});</script>
