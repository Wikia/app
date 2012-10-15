var PageHeader = {

	settings: {
		mouseoverDelay: 300,
		mouseoutDelay: 350
	},

	init: function() {
		// RT #72155: resize FB like wrapper to match width of an iframe
		if (typeof FB != 'undefined' && typeof FB.Event != 'undefined' /* (BugId: 11701) */) {
			FB.Event.subscribe('xfbml.render', function() {
				var likeWrapper = $('.commentslikes').children('.likes');

				// allow wrapper to resize
				likeWrapper.css('width', 'auto');
			});
		}

		// RT #83920: make <fb:like> tags work in IE
		if (typeof $.browser.msie != 'undefined' && typeof $.browser.version != 'undefined' && $.browser.version && $.browser.version.substring(0, $.browser.version.indexOf('.')) < 9) {
			GlobalTriggers.bind('fbinit', function() {
				$('.likes').each(function() {
					var node = $(this),
						html = node.html();

					// FB JS adds 'fb' namespace support in IE, regenerate FBML tags
					node.html('').append(html);

					// force like button to be rendered again
					FB.XFBML.parse(node.get(0));
				});

				$().log('fixed like buttons', 'FB');
			});
		}
	}
};

var ProfileSyncButton = {
	init: function() {
		ProfileSyncButton.attachEventListeners();
	},
	
	attachEventListeners: function() {
		$('a[data-id=syncprofile]').click(function() {
			window.location.href = $(this).attr('data-href');
			return false;
		});
	}
}

$(function() {
	PageHeader.init();
	ProfileSyncButton.init();
});