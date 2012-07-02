(function($,mw) {	
	var bucket = mw.user.bucket( 'ACWInterstitialTest', {
		'buckets': { 'control': 99, 'test': 1 },
		'version': 1,
	} );

	if( bucket === 'test' ) {
		// extract the path, article title, and query string as separate components.
		var locationParts = location.href.match(/(.+)\/([^\/]+?)((\?.*)|$)/);

		// change the link to point to the new special page
		$("div.noarticletext").find('a[href*="action=edit"]').attr(
			'href',
			locationParts[1] + '/' + 'Special:ArticleCreationLanding' + '/' + locationParts[2]
		);
	}
})( jQuery, window.mediaWiki );
