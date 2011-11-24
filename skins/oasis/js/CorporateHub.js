var CorporateHub = {
	track: function(url) {
		$.tracker.byStr('hub/' + url);
	},
	onClick: function(ev) {
		var node = $(ev.target);

		// slider
		if (node.hasParent('#HomepageFeature')) {
			if (!node.is('a')) {
				node = node.parent();
			}

			// more button
			if (node.hasClass('secondary')) {
				this.track('slider');
			}
			// main large image
			else if (node.is('a') && node.parent().is('li')) {
				this.track('slider');
			}
		}
		// top wikis
		else if (node.hasParent('#top-wikis-lists-box')) {
			if (node.hasClass('top-wiki-link')) {
				this.track('top-wiki');
			}
		}
		// hot spots
		else if (node.hasParent('#wikia-global-hot-spots')) {
			if (node.hasClass('wikia-page-link')) {
				this.track('hot-spot-page');
			}
			else if (node.hasClass('wikia-wiki-link')) {
				this.track('hot-spot-wiki');
			}
		}
		// top editors
		else if (node.hasParent('#hub-top-contributors')) {
			if (node.hasClass('username')) {
				this.track('top-editor');
			}
		}
	},
	init: function() {
		// track pageview
		this.track('pv/' + wgPageName);

		// track clicks (BugId:15672)
		$('#WikiaPage').bind('click', $.proxy(this.onClick, this));
	}
}

$(function () {
	CorporateHub.init();
});
