(function(window, $) {
	
	/* dom cache */
	var createNewBoardButton = $('#CreateNewBoardButton'),
		modalCache = {};
	
	/* Board edit event handlers */
	function handleCreateNewBoardButtonClick(e) {
		$.nirvana.sendRequest({
			controller: 'ForumSpecialController',
			method: 'createNewBoardModal',
			format: 'html',
			data: {
			},
			callback: function(html) {
				var dialog = $(html).makeModal({
					width: 600
				});
				dialog.on('click.CreateNewBoard', '.cancel', function(e) {
					dialog.closeModal();
				}).on('click.CreateNewBoard', '.submit', function(e) {
					$.nirvana.sendRequest({
						controller: 'ForumExternalController',
						method: 'createNewBoard',
						format: 'json',
						data: {
							boardTitle: dialog.find('input[name=boardTitle]').val(),
							boardDescription: dialog.find('input[name=boardTitle]').val()
						},
						callback: function (json) {
							console.log(json);
							alert('save returned, check console');
						}
					});
				});
			}
		});
	};
	
	/* Board edit event bindings */
	createNewBoardButton.on('click.CreateNewBoard', '', handleCreateNewBoardButtonClick);
	
})(window, jQuery);