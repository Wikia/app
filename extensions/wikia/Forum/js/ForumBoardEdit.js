/* global WikiaForm */

(function (window, $) {
	'use strict';

	/* dom cache */
	var createNewBoardButton = $('#CreateNewBoardButton'),
		boardList = $('#ForumBoardEdit .boards'),
		bucky = window.Bucky('ForumBoardEdit');

	function makeBoardModal(modalMethod, modalData, submissionMethod, submissionData) {
		var deferred = $.Deferred();
		$.nirvana.sendRequest({
			controller: 'ForumSpecialController',
			method: modalMethod,
			format: 'json',
			data: modalData,
			callback: function (jsonResponse) {
				bucky.timer.start('getBoardModalData');
				require(['wikia.ui.factory'], function (uiFactory) {
					uiFactory.init(['modal']).then(function (uiModal) {
						var submitButton = {
								vars: {
									value: jsonResponse.submitLabel,
									classes: ['normal', 'primary', 'submit'],
									data: [{
										key: 'event',
										value: 'submit'
									}]
								}
							},
							cancelButton = {
								vars: {
									value: $.msg('cancel'),
									data: [{
										key: 'event',
										value: 'close'
									}]
								}
							},
							forumModalConfig = {
								vars: {
									id: 'EditBoardModal',
									size: 'small',
									content: jsonResponse.html,
									title: jsonResponse.title,
									buttons: [
										submitButton,
										cancelButton
									]
								}
							};

						uiModal.createComponent(forumModalConfig, function (forumModal) {
							bucky.timer.start('makeBoardModal');
							forumModal.bind('submit', function () {
								var forumModalForm = new WikiaForm(forumModal.$element.find('.WikiaForm'));
								forumModal.deactivate();
								$.nirvana.sendRequest({
									controller: 'ForumExternalController',
									method: submissionMethod,
									format: 'json',
									data: $.extend({
										boardTitle: forumModal.$element
											.find('input[name=boardTitle]').val(),
										boardDescription: forumModal.$element
											.find('input[name=boardDescription]').val(),
										token: forumModal.$element
											.find('input[name=token]').val()
									}, typeof submissionData === 'function' ?
										submissionData(forumModal) :
										submissionData),
									callback: function (json) {
										if (json) {
											if (json.status === 'ok') {
												Wikia.Querystring().addCb().goTo();
											} else if (json.status === 'error') {
												forumModalForm.clearAllInputErrors();
												if (json.errorfield) {
													forumModalForm.showInputError(json.errorfield, json.errormsg);
												} else {
													forumModalForm.showGenericError(json.errormsg);
												}

												forumModal.activate();
											}
										}
										bucky.timer.stop('makeBoardModal');
									}
								});
							});
							forumModal.show();
						});
						bucky.timer.stop('getBoardModalData');
					});
				});
			}
		});

		return deferred.promise();
	}

	/* Board edit event handlers */
	function handleCreateNewBoardButtonClick(/* e */) {
		$.when(makeBoardModal('createNewBoardModal', {}, 'createNewBoard', {})).done(function (/* dialog */) {
			// done
		});
	}

	function handleEditBoardButtonClick(e) {
		var boardItem = $(e.target).closest('.board'),
			boardId = boardItem.data('id');
		$.when(makeBoardModal('editBoardModal', { boardId: boardId }, 'editBoard', { boardId: boardId }))
			.done(function (/* dialog */) {
				// done
			});
	}

	/* boardId1 should always be before boardId2 */
	function swapBoards(boardId1, boardId2) {
		bucky.timer.start('swapBoards');
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
				if (json.status === 'error') {
					// critical error message that users should not see
					window.alert('Something went wrong, please reload the page and try again');
				}
				bucky.timer.stop('swapBoards');
			}
		});

		return deferred.promise();
	}

	function handleMoveUpClick(e) {
		var boardItem = $(e.target).closest('.board'),
			previousItem = boardItem.prev(),
			boardId1,
			boardId2;
		if (previousItem.exists()) {
			boardId1 = boardItem.data('id');
			boardId2 = previousItem.data('id');
			swapBoards(boardId2, boardId1);
			boardItem.insertBefore(previousItem);
		}
	}

	function handleMoveDownClick(e) {
		var boardItem = $(e.target).closest('.board'),
			nextItem = boardItem.next(),
			boardId1,
			boardId2;
		if (nextItem.exists()) {
			boardId1 = boardItem.data('id');
			boardId2 = nextItem.data('id');
			swapBoards(boardId1, boardId2);
			boardItem.insertAfter(nextItem);
		}
	}

	function handleRemoveBoardButtonClick(e) {
		var boardItem = $(e.target).closest('.board'),
			boardId = boardItem.data('id');
		$.when(makeBoardModal('removeBoardModal', { boardId: boardId }, 'removeBoard', function (boardModal) {
			return {
				boardId: boardId,
				destinationBoardId: boardModal.$element.find('.destinationBoardId option:selected').val()
			};
		})).done(function (/*dialog*/) {
			// done
		});
	}

	/* Board edit event bindings */
	createNewBoardButton.on('click.CreateNewBoard', '', handleCreateNewBoardButtonClick);
	boardList.on('click.editBoard', '.board .edit-pencil', handleEditBoardButtonClick)
		.on('click.editBoard', '.board .trash', handleRemoveBoardButtonClick)
		.on('click.editBoard', '.board .moveup', handleMoveUpClick)
		.on('click.editBoard', '.board .movedown', handleMoveDownClick);

})(window, jQuery);
