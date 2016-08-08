require(['wikia.nirvana', 'jquery', 'BannerNotification'], function (nirvana, $, BannerNotification) {
	function setUserNotified() {
		nirvana.sendRequest({
			controller: 'RevisionUpvotesApi',
			method: 'setUserNotified',
			type: 'post',
			data: {
				token: mw.user.tokens.get('editToken')
			}
		});
	}

	function getAppreciations() {
		nirvana.sendRequest({
			controller: 'ContributionAppreciation',
			method: 'getAppreciations',
			type: 'get',
			format: 'json',
			callback: function (data) {
				if (data.html) {
					new BannerNotification(data.html, 'warn').show();
					setUserNotified();
				}
			}
		});
	}

	$(getAppreciations);
});
