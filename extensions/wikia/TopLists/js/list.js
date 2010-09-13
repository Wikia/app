
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
					'rs':'TopListItem::vote',
					'title':this.id
				},
				function(response) {
					console.log(response);
					
				}
			);
		return false;
	}
}