$(function () {
	'use strict';
	var ManageWikiaHome = function () {
		this.flags[window.FLAG_PROMOTED] = 'promoted';
		this.flags[window.FLAG_BLOCKED] = 'blocked';
		this.flags[window.FLAG_OFFICIAL] = 'official';
	};

	ManageWikiaHome.prototype = {
		visualizationLang: 'en',
		flags: {},
		wikisPerCollection: [],
		SLOTS_IN_TOTAL: 0,
		uiModal: undefined,
		init: function () {
			$('#visualizationLanguagesList').on(
				'change',
				this.changeVisualizationLang
			);

			$('#wiki-filter-reset').click(
				this.resetFormFields
			);

			require( [ 'wikia.ui.factory' ], $.proxy( function ( uiFactory ) {
				uiFactory.init( [ 'modal' ] ).then( $.proxy( function ( uiModal ) {
					this.uiModal = uiModal;
				}, this ));
			}, this ));

			$('#wikisWithVisualizationList')
				.on('click', '.wiki-list a', $.proxy(this.handleChangeFlag, this))
				.on('click', '.collection-checkbox', $.proxy(this.handleCollectionChange, this));

			this.SLOTS_IN_TOTAL = window.wgSlotsInTotal || 0;
			this.wikisPerCollection = window.wgWikisPerCollection || [];
			this.visualizationLang = $('#visualizationLang').val();

			$().log('ManageWikiaHome.init');
		},
		changeVisualizationLang: function (e) {
			window.Wikia.Querystring().clearVals().setVal('vl', e.target.value).goTo();
		},
		resetFormFields: function (e) {
			e.preventDefault();
			$(':input', '#wiki-name-filter')
				.not(':button, :submit, :reset, :hidden')
				.val('')
				.removeAttr('checked')
				.removeAttr('selected');
		},
		isWikiBlocked: function (wikiId) {
			$('body').startThrobbing();
			return $.nirvana.sendRequest({
				controller: 'ManageWikiaHome',
				method: 'isWikiBlocked',
				type: 'post',
				data: {
					lang: this.visualizationLang,
					wikiId: wikiId
				},
				callback: function() {
					$('body').stopThrobbing();
				}
			});
		},
		isWikiInCollection: function (wikiId) {
			return $.nirvana.sendRequest({
				controller: 'ManageWikiaHome',
				method: 'isWikiInCollection',
				type: 'post',
				data: {
					wikiId: wikiId
				}
			});
		},
		editFlag: function (flagLink, wikiId, flagType, type, modal) {
			var yesNoMessageKey = (type === window.CHANGE_FLAG_ADD) ? 'yes' : 'no',
				message = $.msg('manage-wikia-home-wiki-list-' + this.flags[flagType] + '-' + yesNoMessageKey);

			$.nirvana.sendRequest({
				controller: 'ManageWikiaHome',
				method: 'changeFlag',
				type: 'post',
				data: {
					type: type,
					flag: flagType,
					lang: this.visualizationLang,
					corpWikiId: $('#visualizationWikiId').val(),
					wikiId: wikiId
				},
				callback: $.proxy(function () {
					modal.trigger('close');
					flagLink.data('flags', (type === window.CHANGE_FLAG_ADD) ? 1 : 0).text(message);
				}, this)
			});
		},
		editCollection: function (eventTarget, collectionId, wikiId, changeDirection, modal) {
			$.nirvana.sendRequest({
				controller: 'ManageWikiaHome',
				method: 'switchCollection',
				type: 'post',
				data: {
					switchType: changeDirection,
					collectionId: collectionId,
					wikiId: wikiId
				},
				callback: $.proxy(function (response) {
					modal.trigger('close');
					if ( !response.status ) {
						this.showInformationModal( response.message );
					} else {
						if ( changeDirection === window.CHANGE_FLAG_ADD ) {
							this.wikisPerCollection[collectionId]++;
							eventTarget.prop('checked', true);
						} else {
							this.wikisPerCollection[collectionId]--;
							eventTarget.prop('checked', false);
						}
						this.updateCounterDisplay(collectionId);
					}
				}, this)
			});
		},
		isValidWikisAmount: function (collectionId, action) {
			return !this.wikisPerCollection[collectionId] //there are no wikis in the collection yet
				|| this.wikisPerCollection[collectionId] < this.SLOTS_IN_TOTAL //or there is still place for another wiki in the collection
				|| (this.wikisPerCollection[collectionId] >= this.SLOTS_IN_TOTAL && action === window.CHANGE_FLAG_REMOVE ) //or there are too many wikis in the collection and user is removing them
		},
		updateCounterDisplay: function (collectionId) {
			var counterContainer = $(
				'.collection-module[data-collection-id="' + collectionId + '"] .collection-wikis-counter p'
			);

			counterContainer.text('');
			counterContainer.text($.msg('manage-wikia-home-collections-wikis-in-collection',
				this.wikisPerCollection[collectionId],
				this.SLOTS_IN_TOTAL
			));
		},
		showInformationModal: function (msg) {

			this.uiModal.createComponent({
				vars: {
					id: 'MWHinformationModal',
					size: 'small',
					title: $.msg('manage-wikia-home-modal-content-blocked-wiki-title'),
					content: msg,
					buttons: [{
						vars: {
							value: $.msg( 'manage-wikia-home-modal-button-okay' ),
							classes: [ 'normal', 'primary' ],
							data: [
								{
									key: 'event',
									value: 'close'
								}
							]
						}
					}]
				}
			}, function(modal) {
				modal.show();
			});
		},
		handleChangeFlag: function(event) {
			event.preventDefault();
			var flagLink = $( event.target ),
				wikiId = flagLink.data( 'id' ),
				flagType = flagLink.data( 'flag-type' ),
				flagChangeDirection = '';

			$.when(
					this.isWikiInCollection(wikiId)
				).done($.proxy(function (isInCollection) {
					var modalContent = '';

					if (isInCollection.status && flagType === window.FLAG_BLOCKED) {
						modalContent = $.msg('manage-wikia-home-modal-content-removed-blocked-in-collection');
						this.showInformationModal(modalContent);
					} else {
						flagChangeDirection = flagLink.data( 'flags' ) === 1 ?
							window.CHANGE_FLAG_REMOVE :
							window.CHANGE_FLAG_ADD;

						this.uiModal.createComponent({
								vars: {
									id: 'MWHchangeFlagModal',
									size: 'small',
									title: $.msg('manage-wikia-home-modal-title'),
									content: $.msg(
										'manage-wikia-home-modal-content-' + flagChangeDirection + '-' +
											this.flags[flagType]
									),
									buttons: [
										{
											vars: {
												value: $.msg( 'manage-wikia-home-modal-button-yes' ),
												classes: [ 'normal', 'primary' ],
												data: [
													{
														key: 'event',
														value: 'submit'
													}
												]
											}
										},
										{
											vars: {
												value: $.msg( 'manage-wikia-home-modal-button-no' ),
												data: [
													{
														key: 'event',
														value: 'close'
													}
												]
											}
										}
									]
								}
							},
							$.proxy( function( modal ) {
								modal.show();
								modal.bind( 'submit', $.proxy( function () {
									this.editFlag(
										flagLink,
										wikiId,
										flagType,
										flagChangeDirection,
										modal);
								}, this ));
							}, this)
						);
					}
				}, this));
		},
		handleCollectionChange: function (event) {
			event.preventDefault();
			var collectionCheckbox = $( event.target ),
				collectionId = collectionCheckbox.val(),
				wikiId = collectionCheckbox.data('id' ),
				changeDirection = collectionCheckbox.is(':checked') ?
					window.CHANGE_FLAG_ADD :
					window.CHANGE_FLAG_REMOVE,
				content = collectionCheckbox.is(':checked') ?
					$.msg('manage-wikia-home-modal-content-add-collection') :
					$.msg('manage-wikia-home-modal-content-remove-collection');

			if ( !this.isValidWikisAmount( collectionId, changeDirection ) ) {
				this.showInformationModal($.msg('manage-wikia-home-modal-too-many-wikis-in-collection'));
			} else {
				$.when(
						this.isWikiBlocked(wikiId)
					).done($.proxy(function (isBlocked) {
						var modalContent = '';

						if (isBlocked.status) {
							modalContent = $.msg('manage-wikia-home-modal-content-add-blocked-wiki-warning');
							this.showInformationModal(modalContent);
						} else {
							this.uiModal.createComponent({
									vars: {
										id: 'MWHchangeCollectionModal',
										size: 'small',
										title: $.msg('manage-wikia-home-modal-title-collection'),
										content: content,
										buttons: [
											{
												vars: {
													value: $.msg( 'manage-wikia-home-modal-button-yes' ),
													classes: [ 'normal', 'primary' ],
													data: [
														{
															key: 'event',
															value: 'submit'
														}
													]
												}
											},
											{
												vars: {
													value: $.msg( 'manage-wikia-home-modal-button-no' ),
													data: [
														{
															key: 'event',
															value: 'close'
														}
													]
												}
											}
										]
									}
								},
								$.proxy( function( modal ) {
									modal.show();

									modal.bind( 'submit', $.proxy( function () {
										this.editCollection(
											collectionCheckbox,
											collectionId,
											wikiId,
											changeDirection,
											modal
										);
									}, this));
								}, this)
							);
						}
					}, this));
			}
		}
	};

	var ManageWikiaHomeInstance = new ManageWikiaHome();
	ManageWikiaHomeInstance.init();
});
