var SharingToolbar = {
	pageWidth: 0,
	toolbarNode: false,
	contributeOffsetTop: 0,

	init: function() {
		this.toolbarNode = $('#SharingToolbar');

		// sharing toolbar is not shown on this page
		if (!this.toolbarNode.exists()) {
			return;
		}

		this.pageWidth = $('#WikiaPage').width();
		this.contributeOffsetTop = $('#WikiHeader > .buttons > .contribute').offset().top - 5 /* #SharingToolbar top */;

		$(window).bind('scroll', $.proxy(this.onScroll, this));
		this.toolbarNode.find('.email-link').bind('click', this.onEmailClick);
		$('.WikiHeaderRestyle .share-button').bind('click', this.toolbarToggle);
	},
	onScroll: function() {
		if ($(window).scrollTop() >= this.contributeOffsetTop) {
			this.toolbarNode.addClass('fixed');
		}
		else {
			this.toolbarNode.removeClass('fixed');
		}
	},
	onEmailClick: function(ev) {
		var node = $(this),
		lightboxShareEmailLabel = node.attr('data-lightboxShareEmailLabel'),
		lightboxSend = node.attr('data-lightboxSend'),
		lightboxShareEmailLabelAddress = node.attr('data-lightboxShareEmailLabelAddress'),
		lightboxCancel = node.attr('data-lightboxcancel');

		var showEmailModal = function() {
			SharingToolbar.showEmailModal(lightboxShareEmailLabel, lightboxSend, lightboxShareEmailLabelAddress, lightboxCancel);
		};

		if ( window.wgUserName == null ) {
			if (window.wgComboAjaxLogin) {
				showComboAjaxForPlaceHolder(false, false, function () {
					AjaxLogin.doSuccess = function () {
						$('#AjaxLoginBoxWrapper').closest('.modalWrapper').closeModal();
						showEmailModal();
					};
					AjaxLogin.close = function () {
						$('#AjaxLoginBoxWrapper').closeModal();
					};
				}, false, true);
			} else {
				UserLoginModal.show({
					callback: showEmailModal
				});
			}
			return false;
		}
		else {
			showEmailModal();
		}
	},
	showEmailModal: function(lightboxShareEmailLabel, lightboxSend, lightboxShareEmailLabelAddress, lightboxCancel) {
		var refreshPage = function() {
			window.Wikia.CacheBuster.reloadPageWithCacheBuster();
		};

		$.showCustomModal(
			lightboxShareEmailLabel,
			'<label>'+lightboxShareEmailLabelAddress+'<br/>'
			+'<input type="text" id="lightbox-share-email-text" /></label>',
			{
				id: 'shareEmailModal',
				width: 690,
				showCloseButton: true,
				buttons: [
					{id:'ok', defaultButton:true, message:lightboxSend, handler:function(){
						$.nirvana.sendRequest({
							controller: 'SharingToolbarController',
							method: 'sendMail',
							format: 'json',
							data: {
								pageName: wgPageName,
								addresses: $('#shareEmailModal #lightbox-share-email-text').val(),
								messageId: 1
							},
							callback: function(data) {
								var result = data.result;
								$.showModal(result['info-caption'], result['info-content'], {
									onClose: refreshPage
								});
								// close email modal when share is successful (BugId:16061)
								if (result.success) {
									$('#shareEmailModal').closeModal();

								}
							}
						});
					}},
					{id:'cancel', message:'Cancel', handler:function(){
							$('#shareEmailModal').hideModal();
						}
					}
				],
				onClose: refreshPage
			}
		);
	},
	checkWidth: function() {
		var maxWidth = 0,
			nodes = this.toolbarNode.children();

		$.each(nodes, function(key, value) {
			var node = $(value),
				elementWidth = Math.max(node.outerWidth(), node.children().outerWidth());

			maxWidth = Math.max(elementWidth, maxWidth);
		});

		this.toolbarNode.css('width', maxWidth);
	},
	toolbarToggle: function(ev) {
		var button = $(this),
			self = SharingToolbar;

		ev.preventDefault();

		button.toggleClass('share-enabled');
		self.toolbarNode.toggle();

		// width checking
		if (button.hasClass('share-enabled')) {
			self.checkWidth();
		}
	}
}

$(function() {
	SharingToolbar.init();
});