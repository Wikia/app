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
				
				var form = new WikiaForm(dialog.find('.WikiaForm')),
					buttons = window.asdf = dialog.find('button');
				
				dialog.on('click.CreateNewBoard', '.cancel', function(e) {
					dialog.closeModal();
				}).on('click.CreateNewBoard', '.submit', function(e) {
					buttons.attr('disabled', true);
					$.nirvana.sendRequest({
						controller: 'ForumExternalController',
						method: 'createNewBoard',
						format: 'json',
						data: {
							boardTitle: dialog.find('input[name=boardTitle]').val(),
							boardDescription: dialog.find('input[name=boardDescription]').val()
						},
						callback: function (json) {
							$().log(json);
							if(json) {
								if(json.status === 'ok') {
									UserLoginAjaxForm.prototype.reloadPage(); // reload, waiting on pull request
								} else if(json.status === 'error') {
									if(json.errorfield) {
										form.showInputError(json.errorfield, json.errormsg);
									} else {
										form.showGenericError(json.errormsg);
									}
									buttons.removeAttr('disabled');
								}
							}
						}
					});
				});
			}
		});
	};
	
	/* Board edit event bindings */
	createNewBoardButton.on('click.CreateNewBoard', '', handleCreateNewBoardButtonClick);
	
})(window, jQuery);