var WikiaRss = WikiaRss || (function(){
	/** @private **/

	/** @public **/
	return {
		init: function(options) {
			$.nirvana.sendRequest({
				controller: 'WikiaRssExternalController',
				method: 'getRssFeeds',
				type: 'GET',
				format: 'json',
				data: {
					options: options
				},
				callback: function(data) {
					if( data.status == true ) {
						$('.wikiaRssPlaceholder[data-id="' + options.id + '"]').html(data.html);
					} else {
						$('.wikiaRssPlaceholder[data-id="' + options.id + '"]').html(data.error);
					}
				},
				onErrorCallback: function(jqXHR, textStatus, errorThrown) {
					$('.wikiaRssPlaceholder[data-id="' + options.id + '"]').html(options.ajaxErrorMsg);
				}
			});
		}
	};
})();
