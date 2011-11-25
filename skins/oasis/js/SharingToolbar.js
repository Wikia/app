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

		// FIX ME if facebook api provides the functionality to run code after iframe render
		setTimeout(function(){
			var maxWidth = 0, elementWidth = 0;
			var nodes = document.getElementById('SharingToolbar').childNodes;
			for(var i=0; i<nodes.length; i++) {
				elementWidth = parseInt(0 + $(nodes[i]).width());
				if (parseInt(0 + $(nodes[i]).width()) > parseInt(0 + $(nodes[i]).children().width())) {
					elementWidth = parseInt(0 + $(nodes[i]).width());
				}
				else elementWidth = parseInt(0 + $(nodes[i]).children().width());
				if (elementWidth > maxWidth) maxWidth = elementWidth;
			}
			$('#SharingToolbar').css(
				'width',
				maxWidth
			);
		}, 10000);
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
		lightboxShareEmailLabelAddress = node.attr('data-lightboxShareEmailLabelAddress');
		if ( !window.wgIsLogin && window.wgComboAjaxLogin ) {
			showComboAjaxForPlaceHolder(false, "", function() {
				// show email modal when the page reloads (BugId:15911)
				AjaxLogin.clickAfterLogin = '#SharingToolbar .email-link';
			});
			return false;
		}
		else {
			SharingToolbar.showEmailModal(lightboxShareEmailLabel, lightboxSend, lightboxShareEmailLabelAddress);
		}
	},
	showEmailModal: function(lightboxShareEmailLabel, lightboxSend, lightboxShareEmailLabelAddress) {
		$.showModal(
			lightboxShareEmailLabel,
			'<label>'+lightboxShareEmailLabelAddress+'<br/>'
			+'<input type="text" id="lightbox-share-email-text" /></label>'
			+'<input type="button" value="'+lightboxSend+'" id="lightbox-share-email-button" />',
			{
				id: 'shareEmailModal',
				width: 690,
				showCloseButton: true,
				callback: function() {
					$('#lightbox-share-email-button').click(function(ev) {
						var button = $(this).prop('disabled', true);

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

								button.prop('disabled', false);

								// close email modal when share is successful (BugId:16061)
								if (result.success) {
									$('#shareEmailModal').closeModal();
								}
							}
						});
					});
				}
			}
		);
	},
	toolbarToggle: function(e) {
		var button = $(e.target);
		button.toggleClass('share-enabled');
		this.toolbarNode.toggle();

		// click tracking
		this.track(button.hasClass('share-enabled') ? 'share-activate' : 'share-deactivate');
	}
}

$(function() {
	SharingToolbar.init();
});
