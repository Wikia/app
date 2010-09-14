
$(function() {
	TopList.init();
});

var TopList = {

	init: function() {
		$('.item-vote-button').bind('click', TopList.voteItem);
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
					$('#'+response.votesCountId).html(response.msg);
				}
			}
		);

		return false;
	}
}