(function($) {

var script_url = wgServer + ((wgScript == null) ? (wgScriptPath + "/index.php") : wgScript);

function count_articles(items) {
	var count = 0;
	return count;
}

$(function() {
	var c = $.jStorage.get('collection');
	if (c) {
		var num_pages = 0;
		for (var i = 0; i < c.items.length; i++) {
			if (c.items[i]['type'] == 'article') {
				num_pages++;
			}
		}
		if (num_pages) {
			var txt = collection_dialogtxt;
			txt = txt.replace(/%TITLE%/, c.title ? '("' + c.title + '")' : '');
			txt = txt.replace(/%NUMPAGES%/, num_pages);
			if (confirm(txt)) {
				$.post(script_url, {
					'action': 'ajax',
					'rs': 'wfAjaxPostCollection',
					'rsargs[]': [JSON.stringify(c)]
				}, function(result) {
					window.location.href = result.redirect_url;
				}, 'json');
			}
		}
	}
});
 
})(jQuery);

