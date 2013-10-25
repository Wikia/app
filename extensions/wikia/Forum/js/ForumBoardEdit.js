(function(window, $) {
	
	/* dom cache */
	var createNewBoardButton = $('#CreateNewBoardButton'),
		boardList = $('#ForumBoardEdit .boards'),
		currentDialog = false;
		
	function makeBoardModal(modalMethod, modalData, submissionMethod, submissionData) {
		// ==========================================================================
		var deferred = $.Deferred();
		$.nirvana.sendRequest({
			controller: 'ForumSpecialController',
			method: modalMethod,
			format: 'json',
			data: modalData,
			callback: function( jsonResponse ) {
				require( [ 'wikia.ui.factory' ], function( uiFactory ) {
					uiFactory.init( [ 'button', 'modal' ] ).then( function( uiButton, uiModal ) {
						var cancelBtnMsg = $.msg( 'cancel' ),
							cancelBtn = uiButton.render( {
								type: 'link',
								vars: {
									id: 'cancel',
									href: '#',
									classes: [ 'normal', 'secondary' ],
									value: cancelBtnMsg,
									title: cancelBtnMsg
								}
							}),
							submitBtn = uiButton.render( {
								type: 'link',
								vars: {
									id: 'submit',
									href: '#',
									classes: [ 'normal', 'primary' ],
									value: jsonResponse.submitLabel,
									title: jsonResponse.submitLabel
								}
							}),
							modalId = 'BoardModal',
							forumModal = uiModal.render( {
							type: 'default',
							vars: {
								id: modalId,
								size: 'small',
								content: jsonResponse.html,
								title: jsonResponse.title,
								closeButton: true,
								closeText: $.msg( 'close' ),
								primaryBtn: submitBtn,
								secondBtn: cancelBtn
							}
						} );
						require( [ 'wikia.ui.modal' ], function( modal ) {
							forumModal = modal.init( modalId, forumModal );
							forumModal.form = new WikiaForm( forumModal.$element.find( '.WikiaForm' ) );

							forumModal.$element.find( '#cancel' ).click( function() {
								forumModal.close();
								forumModal.$element.remove(); //@todo - fix it
							} );
							window.forumModal = forumModal;
							forumModal.$element.find( '#submit' ).click( function() {
								// @todo - how to disable all buttons including modal close?
								forumModal.$element.find( 'footer .buttons a' ).attr('disabled', true);
								$.nirvana.sendRequest( {
									controller: 'ForumExternalController',
									method: submissionMethod,
									format: 'json',
									data: $.extend({
										boardTitle: forumModal.$element.find( 'input[name=boardTitle]' ).val(),
										boardDescription: forumModal.$element.find( 'input[name=boardDescription]' ).val()
									}, typeof submissionData === 'function' ? submissionData( forumModal ) : submissionData ),
									callback: function( json ) {
										if( json ) {
											if( json.status === 'ok' ) {
												Wikia.Querystring().addCb().goTo();
											} else if( json.status === 'error' ) {
												forumModal.form.clearAllInputErrors();
												if( json.errorfield ) {
													forumModal.form.showInputError( json.errorfield, json.errormsg );
												} else {
													forumModal.form.showGenericError( json.errormsg );
												}
												// @todo - implement, enable button clicks
												forumModal.$element.find( 'footer .buttons a' ).removeAttr( 'disabled' );
											}
										}
									}
								} );
							} );
							forumModal.show();
							deferred.resolve( forumModal );
						} );
					} );
				} );
				return;

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
									Wikia.Querystring().addCb().goTo();
								} else if(json.status === 'error') {
									dialog.form.clearAllInputErrors();
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
	}
	
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
				boardId: boardId,
				// this global currentDialog is just plain wrong
				// but we can use a callback parameter here... :)
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