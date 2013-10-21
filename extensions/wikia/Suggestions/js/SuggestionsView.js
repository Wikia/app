define('SuggestionsView', ['SuggestionsViewModel'], function( viewModel ) {
	'use strict';
	var ads = $('[id$=\'TOP_RIGHT_BOXAD\']'),
		keyCodes = [ 13 /*enter*/, 38 /*up*/, 40 /*down*/ ],
		keyEventsActive = true,
		searchInput, dropdown;
	function buildTitleMarkup( result ) {
		if ( result.match && ( result.match.type === 'title' ) ) {
			return result.match.prefix + '<span class="match">' +result.match.match + '</span>' +
				result.match.suffix;
		} else {
			return result.title;
		}
	}
	function buildRedirectMarkup( result ) {
		if ( result.match && ( result.match.type === 'redirect' ) ) {
			return '<span class="redirect"><span class="redirect-from">' +
				$.msg('suggestions-redirect-from') + ': </span>' + result.match.prefix +
				'<span class="match">' + result.match.match + '</span>' + result.match.suffix + '</span>';
		} else {
			return '';
		}
	}
	function buildSeeAllResultsMarkup( i ) {
		++i;
		return '<li class="all" tabindex="' + i + '"><a href="#"><span>' + $.msg('suggestions-see-all') +
			'</span></a></li>';
	}
	function hideAds() {
		ads.each(function() {
			$(this).children().css('margin-left', '-9999px');
		});
	}
	function showAds() {
		ads.each(function() {
			$(this).children().css('margin-left', 'auto');
		});
	}
	function handleNavigation(key) {
		var active = document.activeElement,
			next, href;
		if ( !keyEventsActive ) { return; }
		if ( key === 13 ) {
			href = $(active).children('a').attr('href');
			if ( href && href !== '#' ) {
				emitEvent('newSuggestionsEnter');
				window.location.pathname = href;
			} else {
				emitEvent('newSuggestionsSearchEnter');
				searchInput[0].form.submit();
			}
			return;
		}
		//we are in input, go to list
		if( active.form &&
			active.form.id === 'WikiaSearch' &&
			key === 40 &&
			dropdown.children().length ) {
			dropdown.children()[0].focus();
		} else if( active.parentNode === dropdown[0] ) {
			if( key === 40 ) {
				//down
				next = $(active).next();
			} else if ( key === 38 ) {
				//up
				next = $(active).prev();
			}
			if ( next && next.length ) {
				next[0].focus();
			} else {
				//if went to end, focus input
				searchInput[0].focus();
			}
		}
	}
	function blurDropdown() {
		setTimeout( function() {
			if ( document.activeElement.parentNode !== dropdown[0] &&
				document.activeElement !== searchInput[0] ) {
				showAds();
				dropdown.empty();
			}
		}, 0);
	}
	function emitEvent( eventName ) {
		dropdown.trigger( eventName );
	}
	function bindEvents() {
		viewModel.on( 'displayResults changed', function() {
			var results = viewModel.getDisplayResults(),
				html, res, i, $el;
			dropdown.empty();
			if ( !viewModel.getUse() ) { return; }
			for( i in results ) {
				res = results[i];
				html = '<li tabindex="' + i + '">' +
					'<a href="' + res.path + '">' +
					'<img class="search-suggest-image" src="' + res.thumbnail + '" />' +
					'<div class="wraper">' +
					'<div class="block">' +
					'<span class="title">' + buildTitleMarkup( res ) + '</span>' +
					buildRedirectMarkup( res ) +
					'</div>' +
					'</div>' +
					'</a>' +
					'</li>';
				$el = $(html).appendTo(dropdown);
				$el.blur( blurDropdown );
			}
			if ( results.length ) {
				html = buildSeeAllResultsMarkup(i);
				$el = $(html).appendTo(dropdown);
				$el.click( function() {
					emitEvent('newSuggestionsSearchClick');
					searchInput[0].form.submit();
				});
				hideAds();
				emitEvent('newSuggestionsShow');
			} else {
				showAds();
			}
		});
		searchInput.on( 'blur', blurDropdown );
		searchInput.on( 'keypress', function (e) {
			if ( keyCodes.indexOf(e.keyCode) === -1 ) {
				window.setTimeout(function() {
					var value = searchInput.val();
					viewModel.setQuery( value );
				}, 0);
			}
		});
		searchInput.on( 'keyup', function (e) {
			if ( keyCodes.indexOf(e.keyCode) === -1 ) {
				var value = searchInput.val();
				viewModel.setQuery( value );
			}
		});
		searchInput.on( 'keydown', function (e) {
			if ( keyCodes.indexOf(e.keyCode) !== -1 &&
				( e.keyCode !== 13 || document.activeElement !== searchInput[0] ) ) {
				handleNavigation(e.keyCode);
				return false;
			}
		});
		dropdown.on( 'keydown', function (e) {
			if ( keyCodes.indexOf(e.keyCode) !== -1 &&
				( e.keyCode !== 13 || document.activeElement !== searchInput[0] ) ) {
				handleNavigation(e.keyCode);
				return false;
			}
		});
		dropdown.on( 'mouseenter', function () {
			//switch off keyboard events
			keyEventsActive = false;
			searchInput[0].focus();
		});
		dropdown.on( 'mouseleave', function () {
			//switch on keyboard events
			keyEventsActive = true;
		});
	}
	return {
		init: function( input, target, wikiId ) {
			searchInput = input;
			dropdown = target;
			viewModel.setWiki( wikiId );
			bindEvents();
			return this;
		},
		setAsMainSuggestions: function( name ) {
			if ( window.Wikia.autocomplete && window.Wikia.autocomplete[name] ) {
				window.Wikia.autocomplete[name].inUse = false;
			}
		},
		setOldSuggestionsOn: function( name ) {
			if ( window.Wikia.autocomplete && window.Wikia.autocomplete[name] ) {
				window.Wikia.autocomplete[name].inUse = true;
			}
			window.Wikia.newSearchSuggestions = false;
			showAds();
			dropdown.empty();
			viewModel.setUse( false );
		}
	};
});
