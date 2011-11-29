var SharingToolbar = {
	pageWidth: 0,
	toolbarNode: false,
	contributeOffsetTop: 0,

	track: function(url) {
		$.tracker.byStr('/wikiheader/wikinav/' + url);
	},

	init: function() {
		this.toolbarNode = $('#SharingToolbar');

		// sharing toolbar is not shown on this page
		if (!this.toolbarNode.exists()) {
			return;
		}

		this.pageWidth = $('#WikiaPage').width();
		this.contributeOffsetTop = $('#WikiHeader > .buttons > .contribute').offset().top - 5 /* #SharingToolbar top */;

		$(window).bind('scroll', $.proxy(this.onScroll, this));
		this.toolbarNode.children('.email-link').bind('click', this.onEmailClick);
		$('.WikiHeaderRestyle .share-button').bind('click', $.proxy(this.toolbarToggle, this));

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
		if ( !window.wgIsLogin && window.wgComboAjaxLogin ) {
			showComboAjaxForPlaceHolder(false, "", function() {
				// show email modal when the page reloads (BugId:15911)
				AjaxLogin.clickAfterLogin = '#SharingToolbar .email-link';
			});
			return false;
		}
		else {
			SharingToolbar.showEmailModal(lightboxShareEmailLabel, lightboxSend, lightboxShareEmailLabelAddress, lightboxCancel);
		}
	},
	showEmailModal: function(lightboxShareEmailLabel, lightboxSend, lightboxShareEmailLabelAddress, lightboxCancel) {
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
							controller: 'SharingToolbarModule',
							method: 'sendMail',
							format: 'json',
							data: {
								pageName: wgPageName,
								addresses: $('#shareEmailModal #lightbox-share-email-text').val(),
								messageId: 1
							},
							callback: function(data) {
								var result = data.result;
								$.showModal(result['info-caption'], result['info-content']);
								// close email modal when share is successful (BugId:16061)
								if (result.success) {
									$('#shareEmailModal').closeModal();
								}
							}
						});
					}},
					{id:'cancel', message:'Cancel', handler:function(){$('#shareEmailModal').hideModal();}}
				]
			}
		);
	},
	checkWidth: function() {
		var maxWidth = 0, elementWidth = 0, node = null, nodes = $('#SharingToolbar').children();
		$.each(nodes, function(key, value) { 
			node = $(value);
			elementWidth = parseInt(0 + node.outerWidth());
			if (parseInt(0 + node.outerWidth()) > parseInt(0 + node.children().outerWidth())) {
				elementWidth = parseInt(0 + node.outerWidth());
			}
			else elementWidth = parseInt(0 + node.children().outerWidth());
			if (elementWidth > maxWidth) maxWidth = elementWidth;
		});
		$('#SharingToolbar').css(
			'width',
			maxWidth
		);
	},
	toolbarToggle: function(e) {
		var button = $(e.target);
		button.toggleClass('share-enabled');
		this.toolbarNode.toggle();

		// click tracking and width checking
		if (button.hasClass('share-enabled')) {
			this.track('share-activate');
			this.checkWidth();
		}
		else {
			this.track('share-deactivate');
		}
	}
}

$(function() {
	SharingToolbar.init();
});
