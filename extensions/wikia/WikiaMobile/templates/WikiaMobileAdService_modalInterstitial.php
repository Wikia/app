<script>window.addEventListener('load', function () {
if(Wikia.AbTest && ~['B', 'C', 'D'].indexOf(Wikia.AbTest.getGroup("WIKIAMOBILEADSLOTS"))){
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
			ad = {
				toString: toString,
				type: type,
				caption: caption
			};

		media.on('setup', function (data){
			var l = data.length;

			if(l > 5){
				data.images.forEach(function(val,key){
					if(key > 0 && key % 5 == 0){
						data.images.splice(key, 0, ad);
					}
				});

				media.on(type, function(data){
					var ad = data.wrapper.getElementsByClassName('wkAdWrapper')[0];

					media.hideShare();
					media.resetZoom();
					data.zoomable = false;

					ads.setupSlot({
						name: 'MOBILE_IN_CONTENT',
						size: '300x250',
						wrapper: ad,
						init: function(found){
							if(found) {
								setTimeout(function(){
									ad.className += ' show';
								},50)

							}else{
								ad.parentElement.removeChild(ad);
							}
						}
					});
				})
			}
		})
	});
}
});</script>
