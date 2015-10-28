var TopList = {
	_canVote: false,
	_mWrapper: null,

	_init: function() {
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

		$.post(wgScript,
			{
				'action': 'ajax',
 				'rs': 'TopListHelper::voteItem',
 				'title': $('#top-list-title').val() + '/' + this.id,
 				'token': mw.user.tokens.get('editToken')
			},
			function(response) {
				if(response.result === true){
					TopList.unblockInput();
					TopList._mWrapper.replaceWith(response.listBody);
					TopList._mWrapper = $('#toplists-list-body');
					TopList._mWrapper.find('#' + response.votedId).closest('li').find('.ItemNumber')
					.removeClass('NotVotable')
					.append('<div class="Voted"><span></span>' + response.message + '</div>');
					TopList.canVote = false;
				}
			}
		);

		return false;
	},

	addItem: function(ev) {
		ev.preventDefault();
		TopList.blockInput();

		$.post(wgScript,
			{
				'action': 'ajax',
				'cb' : Math.random(),
				'list': $('#top-list-title').val(),
				'rs': 'TopListHelper::addItem',
				'text': $('#toplist-new-item-name').val(),
				'token': mw.user.tokens.get('editToken')
			},
			function(response) {
				TopList.unblockInput();
				var errorDisplay = TopList._mWrapper.find('.NewItemForm .error');
				errorDisplay.html('');

				if(response.result === true) {
					TopList._mWrapper.replaceWith(response.listBody);
					TopList._mWrapper = $('#toplists-list-body');
					TopList.attachEvents();
					TopList.enableVotes();
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
					'title': $('#top-list-title').val(),
					'cb' : Math.random()
				},
				function(response) {
					if(response.result === true){
						if(response.canVote === true){
							TopList.canVote = true;
							TopList.enableVotes();
						}
					}
				}
		);
		return false;
	},

	enableVotes: function() {
		if( TopList.canVote ) {
			TopList._mWrapper.find('.VoteButton').css('visibility', 'visible');
			TopList._mWrapper.find('li .ItemNumber').removeClass('NotVotable');
		}
	},

	attachEvents: function() {
		TopList._mWrapper.find('.VoteButton').unbind('click').bind('click', TopList.voteItem);
		TopList._mWrapper.parent().find('.NewItemForm').unbind('submit').bind('submit', TopList.addItem);
	}
}

$(function() {
	TopList._init();
});