
$(function() {
	TopList.init();
});

var TopList = {
	_mWrapper: null,
	
	init: function() {
		TopList._mWrapper = $('#toplists-list-body');
		TopList.attachEvents();
		TopList.checkList();
	},

	unblockInput: function(){
		$('#toplists-loading-screen').remove();
	},

	blockInput: function(){
		TopList.unblockInput();
		TopList._mWrapper.prepend('<div id="toplists-loading-screen"></div>');
	},

	voteItem: function(e) {
		TopList.blockInput();
		
		$.getJSON(wgScript,
			{
				'action': 'ajax',
				'rs': 'TopListHelper::voteItem',
				'title': $('#top-list-title').val() + '/' + this.id
			},
			function(response) {
				if(response.result === true){
					TopList.unblockInput();
					TopList._mWrapper.replaceWith(response.listBody);
					TopList._mWrapper = $('#toplists-list-body');
					TopList._mWrapper.find('#' + response.votedId).closest('li').find('.ItemNumber').
						append('<div class="Voted"><span></span>' + response.message + '</div>');
					
				}
			}
		);
		return false;
	},

	addItem: function(ev) {
		ev.preventDefault();
		TopList.blockInput();

		$.getJSON(wgScript,
			{
				'action': 'ajax',
				'rs': 'TopListHelper::addItem',
				'list': $('#top-list-title').val(),
				'text': $('#toplist-new-item-name').val()
			},
			function(response) {
				TopList.unblockInput();
				var errorDisplay = TopList._mWrapper.find('.NewItemForm .error');
				errorDisplay.html('');
				
				if(response.result === true) {
					TopList._mWrapper.replaceWith(response.listBody);
					TopList._mWrapper = $('#toplists-list-body');
				} else {
					$('#toplist-new-item-name').addClass('error');
					errorDisplay.html(response.errors.join('<br/>'));
				}

				
			}
		);
		
		return false;
	},

	checkList: function() {
		$.getJSON(wgScript,
				{
					'action': 'ajax',
					'rs': 'TopListHelper::checkListStatus',
					'title': $('#top-list-title').val()
				},
				function(response) {
					if(response.result === true){
						if(response.canVote === true){
							TopList._mWrapper.find('.VoteButton').css('visibility', 'visible');
							TopList._mWrapper.find('li .ItemNumber').removeClass('NotVotable');
						}
					}
				}
		);
		return false;
	},

	attachEvents: function() {
		TopList._mWrapper.find('.VoteButton').bind('click', TopList.voteItem);
		TopList._mWrapper.parent().delegate('.NewItemForm', 'submit', TopList.addItem );
	}
}