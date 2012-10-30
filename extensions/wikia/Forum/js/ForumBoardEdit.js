(function(window, $) {
	
	/* dom cache */
	var createNewBoardButton = $('#CreateNewBoardButton'),
		boardList = $('#ForumBoardEdit .boards'),
		modalCache = {};
		
	function makeBoardModal(modalMethod, modalData, submissionMethod, submissionData) {
		var deferred = $.Deferred();
		$.nirvana.sendRequest({
			controller: 'ForumSpecialController',
			method: modalMethod,
			format: 'html',
			data: modalData,
			callback: function(html) {
				var dialog = $(html).makeModal({
					width: 600
				});
				
				dialog.form = new WikiaForm(dialog.find('.WikiaForm'));
				dialog.buttons = dialog.find('button');
				
				dialog.on('click.EditBoard', '.cancel', function(e) {
					dialog.closeModal();
				}).on('click.CreateNewBoard', '.submit', function(e) {
					dialog.buttons.attr('disabled', true);
					$.nirvana.sendRequest({
						controller: 'ForumExternalController',
						method: submissionMethod,
						format: 'json',
						data: $.extend({
							boardTitle: dialog.find('input[name=boardTitle]').val(),
							boardDescription: dialog.find('input[name=boardDescription]').val()
						}, submissionData),
						callback: function (json) {
							$().log(json);
							if(json) {
								if(json.status === 'ok') {
									UserLoginAjaxForm.prototype.reloadPage(); // reload, waiting on pull request
								} else if(json.status === 'error') {
									if(json.errorfield) {
										dialog.form.showInputError(json.errorfield, json.errormsg);
									} else {
										dialog.form.showGenericError(json.errormsg);
									}
									dialog.buttons.removeAttr('disabled');
								}
							}
						}
					});
				});
				
				deferred.resolve(dialog);
			}
		});
		
		return deferred.promise();
	};
	
	/* Board edit event handlers */
	function handleCreateNewBoardButtonClick(e) {
		$.when(makeBoardModal('createNewBoardModal', {}, 'createNewBoard', {})).done(function(dialog) {
			// done
		});
	};
	
	function handleEditBoardButtonClick(e) {
		var boardItem = $(e.target).closest('.board');
		var boardId = boardItem.data('id');
		$.when(makeBoardModal('editBoardModal', {boardId: boardId}, 'editBoard', {boardId: boardId})).done(function(dialog) {
			// done
		});
	};
	
	/* Board edit event bindings */
	createNewBoardButton.on('click.CreateNewBoard', '', handleCreateNewBoardButtonClick);
	boardList.on('click.editBoard', '.board .edit-pencil', handleEditBoardButtonClick);
	
})(window, jQuery);