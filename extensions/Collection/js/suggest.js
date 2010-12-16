(function() {

var jQuery = collection_jQuery;

var script_url = wgServer +
	((wgScript == null) ? (wgScriptPath + "/index.php") : wgScript);

function set_status(html) {
	if (html) {
		jQuery('#collectionSuggestStatus').css('visibility', 'visible').html(html);
	} else {
		jQuery('#collectionSuggestStatus').css('visibility', 'hidden').html('&nbsp;');
	}
}

function collectionSuggestCall(func, args) {
		set_status('...');
		jQuery.post(script_url, {
			'action': 'ajax',
			'rs': 'wfAjaxCollectionSuggest' + func,
			'rsargs[]': args
		}, function(result) {
			if (func == 'undo') {
				set_status(false);
			} else {
				set_status(result.last_action);
			}
			jQuery('#collectionSuggestions').html(result.suggestions_html);
			jQuery('#collectionMembers').html(result.members_html);
			jQuery('#coll-num_pages').text(result.num_pages);
			sajax_do_call('wfAjaxCollectionGetBookCreatorBoxContent', ['suggest', null], function(xhr) {
				jQuery('#coll-book_creator_box').html(xhr.responseText);
			});
		}, 'json');
}

window.collectionSuggestCall = collectionSuggestCall;

})();

