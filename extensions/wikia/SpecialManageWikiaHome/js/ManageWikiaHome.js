var ManageWikiaHome = function() {};

ManageWikiaHome.prototype = {
	MIN_CHARS_TO_START_FILTERING: 3,
	//todo: use JsVars instead of those "consts" to keep values in PHP&JS consistent
	MODAL_TYPE_BLOCKED: 1,
	MODAL_TYPE_UNBLOCKED: 2,
	MODAL_TYPE_PROMOTED: 3,
	MODAL_TYPE_DEMOTED: 4,
	isListChangingDelayed: false,
	modalObject: {content: '', type: 0, target: {}},
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
			$('#wikisWithVisualizationList').on('click', '.wiki-list a', $.proxy(this.showEditModal, this));
		}, this));

		$('body')
			.on('click', '.modalWrapper #cancel-button', $.proxy(this.modalCancel, this))
			.on('click', '.modalWrapper #submit-button', $.proxy(this.modalSubmit, this));

		$().log('ManageWikiaHome.init');
	},
	changeVisualizationLang: function(e) {
		(new window.Wikia.Querystring()).setVal('vl', e.target.value).goTo();
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
	modalCancel: function() {
		$('.modalWrapper').closeModal();
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
	}
};

var ManageWikiaHomeInstance = new ManageWikiaHome();
$(function () {
	ManageWikiaHomeInstance.init();
});
