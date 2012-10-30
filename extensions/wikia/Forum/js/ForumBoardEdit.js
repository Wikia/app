(function(window, $) {
	
	/* dom cache */
	var createNewBoardButton = $('#CreateNewBoardButton'),
		boardList = $('#ForumBoardEdit .boards'),
		currentDialog = false;
		
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
				
				currentDialog = dialog;
				
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
						}, typeof submissionData === 'function' ? submissionData() : submissionData ),
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
	
	/* boardId1 should always be before boardId2 */
	function swapBoards(boardId1, boardId2) {
		var deferred = $.Deferred();
		$.nirvana.sendRequest({
			controller: 'ForumExternalController',
			method: 'swapOrder',
			format: 'json',
			data: {
				boardId1: boardId1,
				boardId2: boardId2
			},
			callback: function (json) {
				if(json.status == 'error') {
					alert('Something went wrong, please reload the page and try again');	// critical error message that users should not see
				}
			}
		});
		
		return deferred.promise();
	}
	
	function handleMoveUpClick(e) {
		var boardItem = $(e.target).closest('.board'),
			previousItem = boardItem.prev();
		if(previousItem.exists()) {
			var boardId1 = boardItem.data('id');
			var boardId2 = previousItem.data('id');
			swapBoards(boardId2, boardId1);
			boardItem.insertBefore(previousItem);
		}
	}
	
	function handleMoveDownClick(e) {
		var boardItem = $(e.target).closest('.board'),
			nextItem = boardItem.next();
		if(nextItem.exists()) {
			var boardId1 = boardItem.data('id');
			var boardId2 = nextItem.data('id');
			swapBoards(boardId1, boardId2);
			boardItem.insertAfter(nextItem);
		}
	}

	function handleRemoveBoardButtonClick(e) {
		var boardItem = $(e.target).closest('.board');
		var boardId = boardItem.data('id');
		$.when(makeBoardModal('removeBoardModal', {boardId: boardId}, 'removeBoard', function() {
			return {
				destinationBoardId: currentDialog.find('.destinationBoardId option:selected').val()
			};
		})).done(function(dialog) {
			// done
		});
	};
	
	/* Board edit event bindings */
	createNewBoardButton.on('click.CreateNewBoard', '', handleCreateNewBoardButtonClick);
	boardList.on('click.editBoard', '.board .edit-pencil', handleEditBoardButtonClick)
		.on('click.editBoard', '.board .trash', handleRemoveBoardButtonClick)
		.on('click.editBoard', '.board .moveup', handleMoveUpClick)
		.on('click.editBoard', '.board .movedown', handleMoveDownClick);
	
})(window, jQuery);