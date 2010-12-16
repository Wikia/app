/* -- (c) Aaron Schulz, Daniel Arnold 2008 */

/* Every time you change this JS please bump $wgFlaggedRevStyleVersion in FlaggedRevs.php */

var FlaggedRevs = {
	'messages': {
		'revreviewDiffToggleShow': '(show)',
		'revreviewDiffToggleHide': '(hide)'
	},
	/* Hide rating/diff clutter */
	'enableShowhide': function() {
		var toggle = document.getElementById('mw-fr-revisiontoggle');
		if( toggle ) {
			toggle.style.display = 'inline';
			var ratings = document.getElementById('mw-fr-revisionratings');
			if( ratings ) {
				ratings.style.display = 'none';
			}
		}
		toggle = document.getElementById('mw-fr-difftoggle');
		if( toggle ) {
			toggle.style.display = 'inline';
			var diff = document.getElementById('mw-fr-stablediff');
			if( diff ) {
				diff.style.display = 'none';
			}
		}
		toggle = document.getElementById('mw-fr-logtoggle');
		if( toggle ) {
			toggle.style.display = 'inline';
			var log = document.getElementById('mw-fr-logexcerpt');
			if( log ) {
				log.style.display = 'none';
			}
		}
	},
	
	/* Toggles ratings */
	'toggleRevRatings': function() {
		var ratings = document.getElementById('mw-fr-revisionratings');
		if( !ratings ) return;
		if( ratings.style.display == 'none' ) {
			ratings.style.display = 'inline';
		} else {
			ratings.style.display = 'none';
		}
	},
	
	/* Toggles diffs */
	'toggleDiff': function() {
		var diff = document.getElementById('mw-fr-stablediff');
		if( !diff ) return;
		var toggle = document.getElementById('mw-fr-difftoggle');
		if( diff.style.display == 'none' ) {
			diff.style.display = 'inline';
			if( toggle ) {
				toggle.innerHTML = this.messages.revreviewDiffToggleHide;
			}
		} else {
			diff.style.display = 'none';
			if( toggle ) {
				toggle.innerHTML = this.messages.revreviewDiffToggleShow;
			}
		}
	},
	
	/* Toggles log excerpts */
	'toggleLog': function() {
		var log = document.getElementById('mw-fr-logexcerpt');
		if( !log ) return;
		var toggle = document.getElementById('mw-fr-logtoggle');
		if( log.style.display == 'none' ) {
			log.style.display = 'inline';
			if( toggle ) {
				toggle.innerHTML = '';
			}
		}
	}
};

addOnloadHook(FlaggedRevs.enableShowhide);
