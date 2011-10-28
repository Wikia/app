var ACT = {
	init: function() {
		$('#act-search-btn').bind('click', ACT.search);
	},

	search: function() {
		var username = $('#act-username').val();
		$('#act-form').submit();
	}
}

//on content ready
wgAfterContentAndJS.push( ACT.init );