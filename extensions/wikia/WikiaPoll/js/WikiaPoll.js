var WikiaPoll = {
	// anon cookie settings
	COOKIE_NAME: 'wikiapoll-votes',
	COOKIE_EXPIRES: 24 * 30, // in hours

	isAnon: false,
	initialized: false,

	// send AJAX request to extension's ajax dispatcher in MW
	ajax: function(method, params, callback) {
		$.post(wgScript + '?action=ajax&rs=WikiaPollAjax&method=' + method, params, callback, 'json');
	},

	init: function() {
		var self = WikiaPoll;

		// prevent multiple initializing
		if (self.initialized) {
			return;
		}

		self.isAnon = wgUserName === null;

		// find and init all polls
		var polls = $('#WikiaArticle .WikiaPoll');

		polls.each(function() {
			self.setupPoll.call(self, $(this));
		});

		self.initialized = true;
	},

	// init single poll
	setupPoll: function(poll) {
		var self = this;

		var answers = poll.find('ul'),
			pollId = poll.attr('data-id'),
			voteButton = poll.find('.details > input');

		// check voting status
		this.hasVoted(pollId, function() {
			// results mode
			answers.addClass('results');
		}, function() {
			// vote mode
			answers.addClass('vote');

			// setup voting form
			poll.children('form').bind('submit', function(ev) {
				ev.preventDefault();

				// get selected answer
				var answer = answers.find('input:checked').val();
				if (answer > -1) {

					// block "Vote" button
					voteButton.attr('disabled', true);
					poll.addClass('loading');

					self.ajax('vote', {
						pollId: pollId,
						answer: answer,
						title: wgPageName
					}, function(res) {
						// solve IE issue with innerHTML() not being able to handle HTML5
						var tmp = $('<div>').insertAfter(poll).html(res.html);

						// remove old poll and update jQuery reference with new poll
						poll.remove();
						poll = tmp.children('section');

						// show results
						poll.find('ul').addClass('results');
						poll.removeClass('loading');

						// register anon vote in a cookie
						if (self.isAnon) {
							var votes = self.getPollsWithVotes();
							votes.push(pollId);
							$.cookies.set(self.COOKIE_NAME, votes.join(','), {hoursToLive: self.COOKIE_EXPIRES});
						}
					});
				}
			});

			// show vote button
			voteButton.show();
		});
	},

	// get list of polls anon has voted in
	getPollsWithVotes: function() {
		var cookie = $.cookies.get(this.COOKIE_NAME);
		return cookie ? cookie.split(',') : [];
	},

	// checks if current user has voted (cookie for anons / AJAX request for logged-in) and fires proper callback
	hasVoted: function(pollId, onHasVoted, onHasNotVoted) {
		// check cookie (comma separated list of poll ids)
		if (this.isAnon) {
			var votes = this.getPollsWithVotes();
			if ($.inArray(pollId, votes) > -1) {
				onHasVoted();
			}
			else {
				onHasNotVoted();
			}
		}
		// check in database for logged-in
		else {
			this.ajax('hasVoted', {pollId: pollId}, function(res) {
				if (res.hasVoted) {
					onHasVoted();
				}
				else {
					onHasNotVoted();
				}
			});
		}
	}
};