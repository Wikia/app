<script>window.addEventListener('load', function () {
if(Wikia.AbTest && ~['B', 'C', 'D'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS"))){
	require(['ads', 'media', 'modal'], function (ads, media, modal) {
		var changes = 0,
			adTimer;

		media.on('open', function onOpen(length){
			if(length > 5){

				modal.getWrapper().addEventListener('touchend', function(ev){
					var t = ev.target;

					if(t.tagName == 'IMG' && ~t.parentElement.className.indexOf('wkAdPlace')){
						ev.stopPropagation();

						var adWrapper;

						//remove any left videos from DOM
						//videos tend to be heavy on resources we shouldn't have more than one at a time
						if(adWrapper = document.querySelector('.swiperPage .wkAdWrapper')) {
							adWrapper.parentElement.removeChild(adWrapper);
						}

						t.parentElement.className = t.parentElement.className.replace('wkAdPlace', '');
					}
				});

				media.on('change', function(data){
					var adWrapper;

					//remove any left videos from DOM
					//videos tend to be heavy on resources we shouldn't have more than one at a time
					if(adWrapper = document.querySelector('.swiperPage:not(.current) .wkAdWrapper')) {
						adWrapper.parentElement.removeChild(adWrapper);
					}
					clearTimeout(adTimer);


					//increase changes by 1 if it is equal to five reset it to zero and let logic run
					if((++changes >= 5)) {

						adTimer = setTimeout(function(){
							console.log('SHOW')
							var wrapper = data.wrapper;
							data.zoomable = false;
							wrapper.className += ' wkAdPlace';
							media.hideShare();
							modal.setCaption();

							wrapper.insertAdjacentHTML('afterbegin', '<div class=wkAdWrapper></div>');
							var ad = wrapper.getElementsByClassName('wkAdWrapper')[0];

							ads.setupSlot({
								name: 'MOBILE_MODAL_INTERSTITIAL',
								size: '300x250',
								wrapper: ad,
								init: function(found){
									if(found) {
										setTimeout(function(){

											ad.className += ' show';
										},300)

									}else{
										ad.parentElement.removeChild(ad);
									}
								}
							});

							changes = 0;
						},1000);
					}
				})
			}


			media.remove('open', onOpen);
		})
	});
}
});</script>
