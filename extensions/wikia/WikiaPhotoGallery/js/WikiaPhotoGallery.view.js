/* JS to be used in view mode in Monaco skin */
var WikiaPhotoGalleryView = {
	log: function(msg) {
		$().log(msg, 'ImageGallery');
	},

	// check are we on view page (ignore diffs between revisions, edit page previews, special pages)
	isViewPage: function() {
		var urlVars = $.getUrlVars();
		return (window.wgAction == 'view') && (typeof urlVars.oldid == 'undefined') && (window.wgNamespaceNumber != -1);
	},

	init: function() {
		var self = this;

		// don't run on edit page and view with oldid param in URL (leave galleries shown in preview)
		if (!this.isViewPage()) {
			return;
		}

		// find galleries in article content
		var galleries = $('#bodyContent').find('.wikia-gallery').not('.template');
		if (!galleries.exists()) {
			return;
		}

		this.log('found ' + galleries.length + ' galleries');

		galleries.
			children('.wikia-gallery-add').
				// show "Add a picture to this gallery" button
				show().

				children('a').
					// show editor after click on a link
					click(function(ev) {
						ev.preventDefault();

						var gallery = $(this).parent().parent();
						var hash = gallery.attr('hash');
						var id = gallery.attr('id');
						self.log(gallery);

						var gallery = $().find('.wikia-gallery');
						var showEditorFn = function() {
							// tracking
							window.jQuery.tracker.byStr('articleAction/photogallery/init');

							WikiaPhotoGallery.ajax('getGalleryData', {hash:hash, title:wgPageName}, function(data) {
								if (data && data.info == 'ok') {
									data.gallery.id = id;
									WikiaPhotoGallery.showEditor({
										from: 'view',
										gallery: data.gallery
									});
								} else {
									WikiaPhotoGallery.showAlert(
										data.errorCaption,
										data.error
									);
								}
							});
						}

						if (typeof WikiaPhotoGallery == 'undefined') {
							$.getScript(wgExtensionsPath + '/wikia/WikiaPhotoGallery/js/WikiaPhotoGallery.js', showEditorFn);
						} else {
							showEditorFn();
						}
					}).

					// highlight gallery
					hover(
						// onmousein - highlight the gallery
						function(ev) {
							$(this).parent().parent().
								css({
									'border-style': 'solid',
									'border-width': '1px',
									'padding': 0
								}).
								addClass('accent');
						},

						// onmouseout
						function (ev) {
							$(this).parent().parent().
								css({
									'border': '',
									'padding': '1px'
								}).
								removeClass('accent');
						}
					);

	}
};

$(function() {
	WikiaPhotoGalleryView.init.call(WikiaPhotoGalleryView);
});
