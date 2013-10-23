define('SuggestionsView', ['SuggestionsViewModel'], function( viewModel ) {
	'use strict';
	var ads = $('[id$=\'TOP_RIGHT_BOXAD\']'),
		keyCodes = [ 13 /*enter*/, 38 /*up*/, 40 /*down*/ ],
		searchInput, dropdown;

	/* html markups */
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
	function buildSeeAllResultsMarkup() {
		return '<li class="all"><a><span>' + $.msg('suggestions-see-all') +
			'</span></a></li>';
	}
	function buildSuggestionMarkup( result ) {
		var img = '';
		if ( result.thumbnail !== null ){
			img = '<img class="search-suggest-image" src="' + result.thumbnail + '" />';
		}
		return '<li>' +
			'<a href="' + result.path + '">' +
			'<div class="search-suggest-img-wrapper">' +
			img +
			'</div>' +
			'<div class="wraper">' +
			'<div class="block">' +
			'<span class="title">' + buildTitleMarkup( result ) + '</span>' +
			buildRedirectMarkup( result ) +
			'</div>' +
			'</div>' +
			'</a>' +
			'</li>';
	}
	/* helpers */
	function blurDropdown() {
//		showAds();
//		dropdown.empty();
	}
	function emitEvent( eventName ) {
		dropdown.trigger( eventName );
	}
	function showImage(e) {
		e.currentTarget.style.display = 'block';
	}
	function select( e ) {
		removeSelect();
		$(e.currentTarget).addClass('highlight');
	}
	function removeSelect() {
		var active = dropdown.find('.highlight');
		if ( active.length ) {
			active.removeClass('highlight');
		}
	}
	function stopPropagation() {
		return false;
	}
	/* ads handling */
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
	/* events handling */
	function handleNavigation(key) {
		var active = dropdown.find('.highlight'),
			next, href;
		if( dropdown.children().length ) {
			if( key === 40 ) {
				//down
				if(!active.length) {
					//nothing highlighted, go to first
					select( { currentTarget: dropdown.children()[0] } );
				} else {
					next = active.next();
				}
			} else if ( key === 38 ) {
				//up
				if(active.length) {
					next = active.prev();
				}
				if(next && !next.length) {
					//remove selection, we are at the top
					removeSelect();
				}
			}
			if ( next && next.length ) {
				select( { currentTarget: next[0] } );
			}
		}
		//press enter key
		if ( key === 13 ) {
			if( active.length ) {
				//something is highlighted, go to that
				href = active.find('a').attr('href');
			}
			if ( href && href !== '#' ) {
				emitEvent('newSuggestionsEnter');
				window.location.pathname = href;
			} else {
				emitEvent('newSuggestionsSearchEnter');
				searchInput[0].form.submit();
			}
		}
	}
	function bindEvents() {
		viewModel.on( 'displayResults changed', function() {
			var results = viewModel.getDisplayResults(),
				html, res, i, $el, $title;
			dropdown.empty();
			if ( !viewModel.getUse() ) { return; }
			for( i in results ) {
				res = results[i];
				html = buildSuggestionMarkup ( res );
				$el = $(html).appendTo(dropdown);
				$el.find('.search-suggest-image').load( showImage );
				if($el.find('.redirect').length) {
					$el.find('.title').addClass('titleShort');
				}
				bindSuggestionEvents( $el );
			}
			if ( results.length ) {
				html = buildSeeAllResultsMarkup(i);
				$el = $(html).appendTo(dropdown);
				$el.click( function() {
					emitEvent('newSuggestionsSearchClick');
					searchInput[0].form.submit();
				});
				bindSuggestionEvents( $el );
				emitEvent('newSuggestionsShow');
				hideAds();
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
			if ( keyCodes.indexOf(e.keyCode) !== -1 ) {
				handleNavigation(e.keyCode);
				return false;
			}
		});
	}
	function bindSuggestionEvents( element ) {
		//we dont need to focus those
		element.mousedown( stopPropagation );
		//add highlight on hover
		element.mouseenter( select );
		//remove highlight when leaving
		element.mouseleave( removeSelect );
	}

	return {
		init: function( input, target, wikiId ) {
			var value;
			searchInput = input;
			dropdown = target;
			viewModel.setWiki( wikiId );
			bindEvents();
			value = searchInput.val();
			if ( value ) {
				//send first request after loading if input not empty
				viewModel.setQuery( value );
			}
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
			blurDropdown();
			viewModel.setUse( false );
		}
	};
});
