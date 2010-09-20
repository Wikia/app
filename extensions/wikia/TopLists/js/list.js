
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
					$('#toplists-list-body').html(response.listBody);
				}
			}
		);
		return false;
	},

	checkList: function( title ) {
		$.getJSON(wgScript,
				{
					'action':'ajax',
					'rs':'TopListHelper::checkListStatus',
					'title':title
				},
				function(response) {
					if( response.result == true ) {
						console.log(response);
						//$('#toplists-list-body').html(response.listBody);
					}
				}
		);
		return false;
	},

	attachEvents: function() {
		$('.item-vote-button').bind('click', TopList.voteItem);
	}
}