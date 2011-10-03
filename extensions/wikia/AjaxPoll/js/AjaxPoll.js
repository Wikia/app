var AjaxPoll = {
	callback: function( answer ) {
		// hide loading inicator & unblock submit button
		var pollId = answer.id;
		$('#pollSubmittingInfo' + pollId).css('visibility', 'hidden');
		$('#axPollSubmit' + pollId).attr('disabled', false);

		// update total and status info
		$('#wpPollTotal' + pollId).html(answer.total);
		$('#wpPollStatus' + pollId).html(answer.status);

		// update result bars
		var votes = answer.votes;
		$('div.wpPollBar' + pollId).each( function() {
			var barId = parseInt( this.id.split('-').pop() );

			if (typeof votes[barId] != 'undefined') {
				$(this).css('width', votes[barId].percent + '%');
				$('#wpPollVote' + pollId + '-' + barId).html(votes[barId].value).attr('title', votes[barId].title.replace(/&nbsp;/g, ' '));
			}
			else {
				$(this).css('width', '0px');
				$('#wpPollVote' + pollId + '-' + barId).html('0').attr('title', '0');
			}
		});

		// send purge request
		//$.post(wgScript, {action: 'purge', title: wgPageName});
	},

	submit: function( e ) {
		e.preventDefault();

		var form = this;
		var pollId = form.id.substring(6);

		// form AJAX request
		var params = {
			title: wgPageName,
			action: 'ajax',
			rs: 'axAjaxPollSubmit',
			wpPollId: pollId,
			wpVote: 'Vote!'
		};

		// get voted option
		$('input[name=wpPollRadio' + pollId + ']').each(function(){
			if (this.checked) {
				params['wpPollRadio' + pollId] = this.value;
			}
		});

		// loading inicator & block submit button
		$().log('submit #' + form.id, 'AjaxPoll');
		$('#pollSubmittingInfo' + pollId).css('visibility', 'visible');
		$('#axPollSubmit' + pollId).attr('disabled', true);

		// send AJAX request
		$.post(wgScript, params, AjaxPoll.callback, 'json');

		return false;
	},

	initialized: false,

	init: function() {
		$().log('JS loaded', 'AjaxPoll');
		if (this.initialized) {
			return;
		}

		var polls = $('.ajax-poll').children('form');
		if (polls.length == 0) {
			// no polls found
			return;
		}

		$().log('init', 'AjaxPoll');

		polls.each( function() {
			$(this).submit( AjaxPoll.submit );
		});

		this.initialized = true;
	}
};