<script>window.addEventListener('load', function () {
if(Wikia.AbTest && ~['B', 'C', 'D'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS"))){
	require(['ads', 'media', 'modal'], function (ads, media, modal) {
		var changes = 0,
			adTimer;

		media.on('open', function onOpen(length){
			var adWrapper,
				current;

			if(length > 5){

				modal.getWrapper().addEventListener('touchend', function(ev){
					var t = ev.target;

					if(t.tagName == 'IMG' && ~t.parentElement.className.indexOf('wkAdPlace')){
						ev.stopPropagation();

						media.openModal(current);
					}
				});

				media.on('change', function(data){
					//remove any left ads from DOM
					if(adWrapper = document.querySelector('.swiperPage:not(.current) .wkAdWrapper')) {
						adWrapper.parentElement.removeChild(adWrapper);
					}

					clearTimeout(adTimer);

					if((++changes >= 5)) {

						adTimer = setTimeout(function(){
							var wrapper = data.wrapper;

							wrapper.insertAdjacentHTML('afterbegin', '<div class=wkAdWrapper></div>');
							var ad = wrapper.getElementsByClassName('wkAdWrapper')[0];

							ads.setupSlot({
								name: 'MOBILE_IN_CONTENT',
								size: '300x250',
								wrapper: ad,
								init: function(found){
									if(found) {
										data.zoomable = false;
										media.hideShare();
										media.resetZoom();
										modal.setCaption();

										current = data.current;
										wrapper.className += ' wkAdPlace';

										setTimeout(function(){
											ad.className += ' show';
										},20)

									}else{
										ad.parentElement.removeChild(ad);
									}
								}
							});

							changes = 0;
						},900);
					}
				})
			}

			media.remove('open', onOpen);
		})
	});
}
});</script>
