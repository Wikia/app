
$(function() {
	TopList.init();
});

var TopList = {

	init: function() {
		TopList.attachEvents();
	},

	voteItem: function(e) {
		$.getJSON(wgScript,
			{
				'action':'ajax',
				'rs':'TopListHelper::voteItem',
				'title':this.id
			},
			function(response) {
				console.log(response);
				if( response.result == true ) {
					$('#toplists-list-body').html(response.listBody);
					TopList.attachEvents();
				}
			}
		);

		return false;
	},

	attachEvents: function() {
		$('#toplists-list-body').delegate('.item-vote-button', 'click', TopList.voteItem);
	}
}