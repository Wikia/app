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
				var createNewBoardDialog = $(html).makeModal({
					width: 600
				});
				createNewBoardDialog.on('click.CreateNewBoard', '.cancel', function(e) {
					createNewBoardDialog.closeModal();
				});
			}
		});
	};
	
	/* Board edit event bindings */
	createNewBoardButton.on('click.CreateNewBoard', '', handleCreateNewBoardButtonClick);
	
})(window, jQuery);