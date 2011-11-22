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
		this.toolbarNode.children('.email-link').bind('click', this.onEmailClick);

		// FIX ME if facebook api provides the functionality to run code after iframe render
		setTimeout(function(){
			var maxWidth = 0, elementWidth = 0;
			var nodes = document.getElementById('SharingToolbar').childNodes;
			for(var i=0; i<nodes.length; i++) {
				elementWidht = parseInt(0 + $(nodes[i]).width());
				if (elementWidht > maxWidth) maxWidth = elementWidht;
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
			showComboAjaxForPlaceHolder(false, "");
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
			+'<input type="text" id="lightbox-share-email-text" /><br />'
			+'<input type="button" value="'+lightboxSend+'" id="lightbox-share-email-button" />'
			+'<img src="'+stylepath+'/common/images/ajax.gif" class="throbber" style="display:none" /></label>',
			{
				id: 'shareEmailModal',
				width: 690,
				showCloseButton: true,
				callback: function() {
					$('#lightbox-share-email-button').click(function() {
						$.nirvana.sendRequest({
							controller: 'SharingToolbarModule',
							method: 'sendMail',
							format: 'json',
							data: {
								pageName: wgPageName,
								addresses: $('#shareEmailModal #lightbox-share-email-text').val(),
								messageId: 1
							},
							callback: function(result) {
								$.showModal(result.result['info-caption'], result.result['info-content']);
							}
						});
					});
				}
			}
		);
	}
}

$(function() {
	SharingToolbar.init();
});
