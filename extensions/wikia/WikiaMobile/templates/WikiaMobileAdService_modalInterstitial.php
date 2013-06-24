<script>window.addEventListener('load', function () {
if(Wikia.AbTest && ['B', 'C', 'D'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS")) != -1){
	require(['ads', 'media', 'modal','JSMessages'], function (ads, media, modal, msg) {

		var type = 'ad',
			adHTML = '<section data-type=' + type + '><div class=wkAdWrapper></div></section>',
			toString = function(){
				return adHTML;
			},
			captionHTML = '<label class=wkAdLabel>' + msg('wikiamobile-ad-label') + '</label>',
			caption = function(){
				return captionHTML;
			},
			FREQUENCY = 5;

		function Ad(num){
			this.caption = caption;
			this.type = type;
			this.toString = toString;
			this.imgNum = num;
		}

		media.on('setup', function (data){
			var l = data.images.length;

			if(l > FREQUENCY){
				data.images.forEach(function(val,key){
					if(key % (FREQUENCY+1) == FREQUENCY){
						data.images.splice(key, 0, new Ad(key));
						data.skip.push(key);
					}
				});

				media.on(type, function(data){
					var ad = data.wrapper.getElementsByClassName('wkAdWrapper')[0];

					media.hideShare();
					media.resetZoom();
					media.toggleGallery(false);
					modal.showUI();
					data.zoomable = false;

					//Don't load ad if something is already there
					if(ad && ad.children.length == 0) {
						ads.setupSlot({
							name: 'MOBILE_MODAL_INTERSTITIAL',
							size: '300x250',
							wrapper: ad,
							init: function(found){
								if(found) {
									setTimeout(function(){
										ad.className += ' show';
									},50)

								}else{
									ad.innerHTML = '';
									media.skip();
								}
							}
						});
					}
				})
			}
		})
	});
}
});</script>
