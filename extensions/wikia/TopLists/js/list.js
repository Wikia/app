
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
				if( response.result == true ) {
					console.log(response.listBody);
					$('#toplists-list-body').html(response.listBody);
				}
			}
		);

		return false;
	},

	attachEvents: function() {
		$('.item-vote-button').bind('click', TopList.voteItem);
	}
}