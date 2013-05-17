var ManageWikiaHome = function() {
	this.flags[window.FLAG_PROMOTED] = 'promoted';
	this.flags[window.FLAG_BLOCKED] = 'blocked';
	this.flags[window.FLAG_OFFICIAL] = 'official';
};

ManageWikiaHome.prototype = {
	MIN_CHARS_TO_START_FILTERING: 3,
	isListChangingDelayed: false,
	isBlocked: false,
	visualizationLang: 'en',
	modalObject: {
		content: '',
		type: 0,
		target: {},
		collectionsEdit: false,
		flagType: '',
		type: ''
	},
	flags: {},
	modalInfo: { content: '' },
	wikisPerCollection: [],
	SLOTS_IN_TOTAL: 0,
	wereCollectionsWikisChanged: false,
	init: function() {
		$('#visualizationLanguagesList').on(
			'change',
			this.changeVisualizationLang
		);
//TODO: Does dynamic search will be still in use?
/*
		$('#wiki-name-filer-input').on(
			'keyup',
			$.proxy(this.renderWikiListPage, this)
		);
*/
		$('#wiki-filter-reset').click(
			this.resetFormFields
		);

		$.when(
			$.loadMustache(),
			Wikia.getMultiTypePackage({
				mustache: 'extensions/wikia/SpecialManageWikiaHome/templates/ManageWikiaHome_modal.mustache,extensions/wikia/SpecialManageWikiaHome/templates/ManageWikiaHome_modalInfo.mustache'
			})
		).done($.proxy(function(libData, templateData) {
			this.modalObject.content = $.mustache(
				templateData[0].mustache[0], {
					question: $.msg('manage-wikia-home-modal-content-unblocked'),
					messageYes: $.msg('manage-wikia-home-modal-button-yes'),
					messageNo: $.msg('manage-wikia-home-modal-button-no')
				}
			);
			this.modalInfo.content = $.mustache(
				templateData[0].mustache[1], {
					messageYes:$.msg('manage-wikia-home-modal-button-okay')
				}
			);
			$('#wikisWithVisualizationList')
				.on('click', '.wiki-list a', $.proxy(this.showEditModal, this))
				.on('click', '.collection-checkbox', $.proxy(this.addWikiToCollection, this));
		}, this));

		$('body')
			.on('click', '.modalWrapper #cancel-button', $.proxy(this.modalCancel, this))
			.on('click', '.modalWrapper #submit-button', $.proxy(this.modalSubmit, this));
		
		this.SLOTS_IN_TOTAL = window.wgSlotsInTotal || 0;
		this.wikisPerCollection = window.wgWikisPerCollection || [];
		this.visualizationLang = $('#visualizationLang').val();
		
		$().log('ManageWikiaHome.init');
	},
	changeVisualizationLang: function(e) {
		window.Wikia.Querystring().setVal('vl', e.target.value).goTo();
	},
	renderWikiListPage: function(e) {
		e.preventDefault();
		var input = e.target.value;

		var renderData = {
			visualizationLang: this.visualizationLang
		};

		// CHeck if it's still required after filtering

		if( input.length >= this.MIN_CHARS_TO_START_FILTERING && this.isListChangingDelayed === false ) {
			this.isListChangingDelayed = true;
			renderData['wikiHeadline'] = input;
		}

		if( input.length === 0  || typeof renderData['wikiHeadline'] !== 'undefined') {
			this.renderAllWikiListPage(renderData);
		}
	},
	renderAllWikiListPage: function(renderData) {
		$.nirvana.sendRequest({
			controller: 'ManageWikiaHome',
			method: 'renderWikiListPage',
			format: 'html',
			type: 'post',
			data: renderData,
			callback: $.proxy( function(response) {
				$("#wikisWithVisualizationList").html(response);
				this.isListChangingDelayed = false;
			}, this)
		});
	},
	resetFormFields: function(e) {
		e.preventDefault();
		var form = $('#wiki-name-filter');

		form.find('select option:selected').removeAttr('selected');
		form.find('input[type=text]').val('');
		form.find('input:checked').removeAttr('checked');
	},
	addWikiToCollection: function(e) {
		var msg = '';
		this.isBlocked = false;
		this.modalObject.target = $(e.target);

		if (this.modalObject.target.is(':checked')) {
			msg = $.msg('manage-wikia-home-modal-content-add-blocked-wiki-warning');
			this.modalObject.type = window.CHANGE_FLAG_ADD;
		} else {
			msg = $.msg('manage-wikia-home-modal-content-blocked-wiki-in-collection-warning');
			this.modalObject.type = window.CHANGE_FLAG_REMOVE;
		}

		$.when(
			this.isWikiBlocked()
		).done($.proxy(function(isBlocked){
			this.isBlocked = isBlocked.status;
			if (this.isBlocked) {
				this.showInformationModal(msg);
			} else {
				this.showCollectionEditModal(e);
			}
		}, this));
	},
	showInformationModal: function(msg) {
		$.showModal(
			$.msg('manage-wikia-home-modal-content-blocked-wiki-title'),
			this.modalInfo.content,
			{
				callback: $.proxy(function () {
					$('.info-container').text(msg);

					this.modalObject.collectionsEdit = true;
				}, this),
				onAfterClose: $.proxy(function() {
					if( !this.wereCollectionsWikisChanged ) {
						if (this.isBlocked && this.modalObject.type == window.CHANGE_FLAG_REMOVE) {
							this.editWikiCollection();
						}
						this.changeCollectionCheckbox();
					} else {
						this.wereCollectionsWikisChanged = false;
					}

					this.modalObject.collectionsEdit = false;
				}, this)
			}
		);
	},
	showEditModal: function(e) {
		e.preventDefault();
		this.modalObject.target = $(e.target);
		$.when(
			this.isWikiInCollection()
		).done($.proxy(function(isInCollection){
			if (isInCollection.status) {
				var msg = $.msg('manage-wikia-home-modal-content-removed-blocked-in-collection')
				this.showInformationModal(msg);
			} else {
				$.showModal(
					$.msg('manage-wikia-home-modal-title'),
					this.modalObject.content,
					{
						callback: $.proxy(function () {
							var targetObject = $(e.target);

							this.modalObject.target = targetObject;
							this.modalObject.flagType = targetObject.data('flag-type');
							this.modalObject.type = targetObject.data('flags');

							if (targetObject.data('flags') == 1) {
								this.modalObject.type = window.CHANGE_FLAG_REMOVE;
							} else {
								this.modalObject.type = window.CHANGE_FLAG_ADD;
							}

							$('.question-container').text(
								$.msg(
									'manage-wikia-home-modal-content-'
										+ this.modalObject.type + '-'
										+ this.flags[this.modalObject.flagType]
								)
							);
						}, this)
					}
				);
			}
		}, this));
	},
	showCollectionEditModal: function(e) {
		$.showModal(
			$.msg('manage-wikia-home-modal-title-collection'),
			this.modalObject.content,
			{
				callback: $.proxy(function () {
					var targetObject = $(e.target);

					if (targetObject.is(':checked')) {
						$('.question-container').text($.msg('manage-wikia-home-modal-content-add-collection'));
						this.modalObject.type = window.CHANGE_FLAG_ADD;
					} else {
						$('.question-container').text($.msg('manage-wikia-home-modal-content-remove-collection'));
						this.modalObject.type = window.CHANGE_FLAG_REMOVE;
					}

					this.modalObject.target = targetObject;
					this.modalObject.collectionsEdit = true;
				}, this),
				onAfterClose: $.proxy(function() {
					if( !this.wereCollectionsWikisChanged ) {
						this.changeCollectionCheckbox();
					} else {
						// wiki was added/removed to/from collection; let's switch the flag
						this.wereCollectionsWikisChanged = false;
					}
					
					this.modalObject.collectionsEdit = false;
				}, this)
			}
		);
	},
	modalCancel: function() {
		$('.modalWrapper').closeModal();
		this.changeCollectionCheckbox();
	},
	modalSubmit: function() {
		$('.modalWrapper').startThrobbing(); //we don't fire stopThrobbing() because closeModal() deletes container from DOM

		if(this.modalObject.collectionsEdit) {
			this.editWikiCollection();
		} else {
			this.editFlag(this.modalObject.flagType, this.modalObject.type);
		}

	},
	isWikiBlocked: function() {
		return $.nirvana.sendRequest({
			controller: 'ManageWikiaHome',
			method: 'isWikiBlocked',
			type: 'post',
			data: {
				lang: this.visualizationLang,
				wikiId: this.modalObject.target.data('id')
			}
		});
	},
	isWikiInCollection: function() {
		return $.nirvana.sendRequest({
			controller: 'ManageWikiaHome',
			method: 'isWikiInCollection',
			type: 'post',
			data: {
				wikiId: this.modalObject.target.data('id')
			}
		});
	},
	editFlag: function(flagType, type) {
		var yesNoMessageKey = (type == window.CHANGE_FLAG_ADD) ? 'yes' : 'no';

		var message = $.msg('manage-wikia-home-wiki-list-' + this.flags[flagType] + '-' + yesNoMessageKey);

		$.nirvana.sendRequest({
			controller: 'ManageWikiaHome',
			method: 'changeFlag',
			type: 'post',
			data: {
				type: type,
				flag: flagType,
				lang: this.visualizationLang,
				corpWikiId: $('#visualizationWikiId').val(),
				wikiId: this.modalObject.target.data('id')
			},
			callback: $.proxy(function(response) {
				$('.modalWrapper').closeModal();
				this.modalObject.target.data('flags', (type == window.CHANGE_FLAG_ADD) ? 1 : 0).text(message);
			}, this)
		});
	},
	editWikiCollection: function() {
		var collectionId = this.modalObject.target.val();
		var action = this.modalObject.type;

		if (this.isValidWikisAmount(collectionId, action)) {
			if (action == window.CHANGE_FLAG_ADD) {
				this.wikisPerCollection[collectionId]++;
			} else {
				this.wikisPerCollection[collectionId]--;
			}
			this.updateCounterDisplay(collectionId);
			this.updateCollection();
		} else {
			$('.modalWrapper').closeModal();
			alert( $.msg('manage-wikia-home-modal-too-many-wikis-in-collection') );
		}
	},
	updateCollection: function() {
		$.nirvana.sendRequest({
			controller: 'ManageWikiaHome',
			method: 'switchCollection',
			type: 'post',
			data: {
				switchType: this.modalObject.type,
				collectionId: this.modalObject.target.val(),
				wikiId: this.modalObject.target.attr('data-id')
			},
			callback: $.proxy(function(response) {
				this.wereCollectionsWikisChanged = true;
				$('.modalWrapper').closeModal();
			}, this)
		});
	},
	changeCollectionCheckbox: function() {
		if( this.modalObject.collectionsEdit ) {
			if( this.modalObject.type == window.CHANGE_FLAG_ADD ) {
				this.modalObject.target.attr('checked', false);
			} else if (!this.isBlocked) {
				this.modalObject.target.attr('checked', true);
				this.isBlocked = false;
			}
		}
	},
	isValidWikisAmount: function(collectionId, action) {
		return 
			!this.wikisPerCollection[collectionId] //there are no wikis in the collection yet 
			|| this.wikisPerCollection[collectionId] < this.SLOTS_IN_TOTAL //or there is still place for another wiki in the collection
			|| (this.wikisPerCollection[collectionId] >= this.SLOTS_IN_TOTAL && action == window.CHANGE_FLAG_REMOVE ) //or there are too many wikis in the collection and user is removing them
	},
	updateCounterDisplay: function(collectionId) {
		var counterContainer = $('.collection-module[data-collection-id="' + collectionId + '"] .collection-wikis-counter p');
		
		counterContainer.text('');
		counterContainer.text($.msg('manage-wikia-home-collections-wikis-in-collection',
			this.wikisPerCollection[collectionId],
			this.SLOTS_IN_TOTAL
		));
	}
};

var ManageWikiaHomeInstance = new ManageWikiaHome();
$(function () {
	ManageWikiaHomeInstance.init();
});
