(function($) {

var script_url = wgServer +
	((wgScript == null) ? (wgScriptPath + "/index.php") : wgScript);

function set_status(html) {
	if (html) {
		$('#collectionSuggestStatus').css('visibility', 'visible').html(html);
	} else {
		$('#collectionSuggestStatus').css('visibility', 'hidden').html('&nbsp;');
	}
}

function collectionSuggestCall(func, args) {
		set_status('...');
		$.post(script_url, {
			'action': 'ajax',
			'rs': 'wfAjaxCollectionSuggest' + func,
			'rsargs[]': args
		}, function(result) {
			wfCollectionSave(result.collection);
			if (func == 'undo') {
				set_status(false);
			} else {
				set_status(result.last_action);
			}
			$('#collectionSuggestions').html(result.suggestions_html);
			$('#collectionMembers').html(result.members_html);
			$('#coll-num_pages').text(result.num_pages);
			$.getJSON(script_url, {
				'action': 'ajax',
				'rs': 'wfAjaxCollectionGetBookCreatorBoxContent',
				'rsargs[]': ['suggest', null, wgPageName]
			}, function(result) {
				$('#coll-book_creator_box').html(result.html);
			});
		}, 'json');
}

window.collectionSuggestCall = collectionSuggestCall;

})(jQuery);

