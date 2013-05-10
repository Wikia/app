var ManageWikiaHome = function() {};

ManageWikiaHome.prototype = {
	MIN_CHARS_TO_START_FILTERING: 3,
	//todo: use JsVars instead of those "consts" to keep values in PHP&JS consistent
	MODAL_TYPE_BLOCKED: 1,
	MODAL_TYPE_UNBLOCKED: 2,
	MODAL_TYPE_PROMOTED: 3,
	MODAL_TYPE_DEMOTED: 4,
	isListChangingDelayed: false,
	modalObject: {content: '', type: 0, target: {}, collections: 0},
	init: function() {
		$('#visualizationLanguagesList').on(
			'change',
			this.changeVisualizationLang
		);

		$('#wiki-name-filer-input').on(
			'keyup',
			$.proxy(this.renderWikiListPage, this)
		);

		$.when(
			$.loadMustache(),
			Wikia.getMultiTypePackage({
				mustache: 'extensions/wikia/SpecialManageWikiaHome/templates/ManageWikiaHome_modal.mustache'
			})
		).done($.proxy(function(libData, templateData) {
			this.modalObject.content = $.mustache(
				templateData[0].mustache[0], {
					question: $.msg('manage-wikia-home-modal-content-unblocked'),
					messageYes: $.msg('manage-wikia-home-modal-button-yes'),
					messageNo: $.msg('manage-wikia-home-modal-button-no')
				}
			);
			$('#wikisWithVisualizationList')
				.on('click', '.wiki-list a', $.proxy(this.showEditModal, this))
				.on('click', '.collection-checkbox', $.proxy(this.showCollectionEditModal, this));
		}, this));

		$('body')
			.on('click', '.modalWrapper #cancel-button', $.proxy(this.modalCancel, this))
			.on('click', '.modalWrapper #submit-button', $.proxy(this.modalSubmit, this));

		$().log('ManageWikiaHome.init');
	},
	changeVisualizationLang: function(e) {
		window.Wikia.Querystring().setVal('vl', e.target.value).goTo();
	},
	renderWikiListPage: function(e) {
		e.preventDefault();
		var input = e.target.value;
		var vl = $('#visualizationLang').val();

		//todo: set only data in "if" statements and leave only one $.nirvana.sendRequest() not to duplicate code
		if( input.length >= this.MIN_CHARS_TO_START_FILTERING && this.isListChangingDelayed === false ) {
			this.isListChangingDelayed = true;

			//todo: use post instead of get to have the most valid list
			$.nirvana.sendRequest({
				controller: 'ManageWikiaHome',
				method: 'renderWikiListPage',
				format: 'html',
				type: 'get',
				data: {
					visualizationLang: vl,
					wikiHeadline: input
				},
				callback: $.proxy( function(response) {
					$("#wikisWithVisualizationList").html(response);
					this.isListChangingDelayed = false;
				}, this)
			});
		}

		if( input.length === 0 ) {
			$.nirvana.sendRequest({
				controller: 'ManageWikiaHome',
				method: 'renderWikiListPage',
				format: 'html',
				type: 'get',
				data: {
					visualizationLang: vl
				},
				callback: $.proxy( function(response) {
					$("#wikisWithVisualizationList").html(response);
					this.isListChangingDelayed = false;
				}, this)
			});
		}
	},
	showEditModal: function(e) {
		e.preventDefault();
		$.showModal(
			$.msg('manage-wikia-home-modal-title'),
			this.modalObject.content,
			{
				callback: $.proxy(function () {
					var targetObject = $(e.target);

					//todo: remove nested "ifs" and instead use new function which checks it
					if (targetObject.hasClass('status-blocked')) {
						if (targetObject.data('flags') == '1') {
							$('.question-container').text($.msg('manage-wikia-home-modal-content-blocked'));
							this.modalObject.type = this.MODAL_TYPE_BLOCKED;
						}
						else {
							$('.question-container').text($.msg('manage-wikia-home-modal-content-unblocked'));
							this.modalObject.type = this.MODAL_TYPE_UNBLOCKED;
						}
					}
					else if (targetObject.hasClass('status-promoted')) {
						if (targetObject.data('flags') == '1') {
							$('.question-container').text($.msg('manage-wikia-home-modal-content-demoted'));
							this.modalObject.type = this.MODAL_TYPE_DEMOTED;
						}
						else {
							$('.question-container').text($.msg('manage-wikia-home-modal-content-promoted'));
							this.modalObject.type = this.MODAL_TYPE_PROMOTED;
						}
					}
					this.modalObject.target = targetObject;
				}, this)
			}
		);
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
						this.modalObject.type = window.SWITCH_COLLECTION_TYPE_ADD;
					} else {
						$('.question-container').text($.msg('manage-wikia-home-modal-content-remove-collection'));
						this.modalObject.type = window.SWITCH_COLLECTION_TYPE_REMOVE;
					}

					this.modalObject.target = targetObject;
					this.modalObject.collections = 1;
				}, this)
			}
		);
	},
	modalCancel: function() {
		$('.modalWrapper').closeModal();
		if(this.modalObject.collections) {
			if(this.modalObject.type == window.SWITCH_COLLECTION_TYPE_ADD) {
				this.modalObject.target.attr('checked', false);
			} else {
				this.modalObject.target.attr('checked', true);
			}
		}
	},
	modalSubmit: function() {
		var method, message, flag = '';
		switch(this.modalObject.type) {
			case this.MODAL_TYPE_BLOCKED:
				method = 'removeWikiFromBlocked';
				message = $.msg('manage-wikia-home-wiki-list-blocked-no');
				break;
			case this.MODAL_TYPE_UNBLOCKED:
				method = 'setWikiAsBlocked';
				message = $.msg('manage-wikia-home-wiki-list-blocked-yes');
				flag = 1;
				break;
			case this.MODAL_TYPE_PROMOTED:
				method = 'setWikiAsPromoted';
				message = $.msg('manage-wikia-home-wiki-list-blocked-yes');
				flag = 1;
				break;
			case this.MODAL_TYPE_DEMOTED:
				method = 'removeWikiFromPromoted';
				message = $.msg('manage-wikia-home-wiki-list-blocked-no');
				break;
			default:
		}

		$('.modalWrapper').startThrobbing(); //we don't fire stopThrobbing() because closeModal() deletes container from DOM

		if(this.modalObject.collections) {
			this.editWikiCollection();
		} else {
			this.editBlockedPromoted(method, message, flag);
		}

	},
	editBlockedPromoted: function(method, message, flag) {
		$.nirvana.sendRequest({
			controller: 'ManageWikiaHome',
			method: method,
			type: 'post',
			data: {
				lang: $('#visualizationLang').val(),
				corpWikiId: $('#visualizationWikiId').val(),
				wikiId: this.modalObject.target.data('id')
			},
			callback: $.proxy(function(response) {
				$('.modalWrapper').closeModal();
				this.modalObject.target.data('flags', flag).text(message);
			}, this)
		});
	},
	editWikiCollection: function() {
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
				this.recalculateWikisInCollection();
				$('.modalWrapper').closeModal();
			}, this)
		});
	},
	recalculateWikisInCollection: function(collectionId, switchType) {
		var collectionId = this.modalObject.target.val();
		var action = this.modalObject.type;
		//var wikisPerCollection = window.wgWikisPerCollection[collectionId]; 
		
		if( action == window.SWITCH_COLLECTION_TYPE_ADD ) {
			window.wgWikisPerCollection[collectionId]++;
		} else if( action == window.SWITCH_COLLECTION_TYPE_REMOVE ) {
			window.wgWikisPerCollection[collectionId]--;
		}
	}
};

var ManageWikiaHomeInstance = new ManageWikiaHome();
$(function () {
	ManageWikiaHomeInstance.init();
});
