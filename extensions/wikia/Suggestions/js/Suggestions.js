require( [ 'jquery', 'suggestions_client', 'wikia.log' ], function( $, client, log ) {
	'use strict';
	log('New search suggestions loading...', log.levels.info, 'suggestions');
	$(function() {
		var SuggestionsViewModel = function() {},
			SuggestionsView;
		SuggestionsViewModel.prototype = {
			inUse: true,
			setUse: function( inUse ) {
				this.inUse = inUse;
			},

			getUse: function() {
				return this.inUse;
			},

			setQuery: function( query ) {
				if (!query && this.query === query || !this.inUse) { return; }
				this.query = query;
				this.sendQuery();
				this.trigger( 'query changed', query );
			},

			setWiki: function( wiki ) {
				this.wiki = wiki;
				this.sendQuery();
				this.trigger( 'wiki changed', wiki );
			},

			sendQuery: function() {
				var self = this,
					sentQuery = this.query;
				client.getSuggestions( this.wiki, this.query, function(res) {
					self.setResults(res, sentQuery);
				} );
			},

			setResults: function( results, sentQuery ) {
				//trigger only for the last sent query
				if ( sentQuery === this.query ) {
					log('result set for: ' + sentQuery, log.levels.info, 'suggestions');
					this.results = results;
					this.setDisplayResults( results );
					this.trigger( 'results changed', results );
				}
			},


			setDisplayResults: function( results ) {
				this.displayResults = (results || []).slice(0, 8);
				this.trigger( 'displayResults changed', results );
			},
			getDisplayResults: function( ) {
				return this.displayResults;
			},

			// event emitter pattern
			on: function( event, cb ) {
				this._ev = this._ev || {};
				this._ev[event] = this._ev[event] || [];
				this._ev[event].push( cb );
			},
			trigger: function( ev, value ) {
				var handlers = this._ev[ev] || {},
					i;
				for( i in handlers ) {
					try {
						handlers[i](value);
					} catch(ex) {
						log(ex, log.levels.info, 'suggestions');
					}
				}
			}
		};

		SuggestionsView = function( viewModel, searchInput, dropdown, wikiId ) {
			var ads = $('[id$=\'TOP_RIGHT_BOXAD\']'),
				self = this,
				keyCodes = [ 13 /*enter*/, 38 /*up*/, 40 /*down*/ ],
				keyEventsActive = true;
			self.buildTitleMarkup = function( result ) {
				if ( result.match && ( result.match.type === 'title' ) ) {
					return result.match.prefix + '<span class="match">' +result.match.match + '</span>' +
						result.match.suffix;
				} else {
					return result.title;
				}
			};

			self.buildRedirectMarkup = function( result ) {
				if ( result.match && ( result.match.type === 'redirect' ) ) {
					return '<span class="redirect"><span class="redirect-from">' +
						$.msg('suggestions-redirect-from') + ': </span>' + result.match.prefix +
							'<span class="match">' + result.match.match + '</span>' + result.match.suffix + '</span>';
				} else {
					return '';
				}
			};

			self.buildSeeAllResultsMarkup = function( i ) {
				++i;
				return '<li class="all" tabindex="' + i + '"><a href="#"><span>' + $.msg('suggestions-see-all') +
					'</span></a></li>';
			};

			self.buildChevronMarkup = function() {
				return '<svg xmlns="http://www.w3.org/2000/svg" class="search-suggest-chevron">' +
					'<g><polyline class="stroke" points="1.5,9 7.5,15 1.5,21"/></g>' +
					'</svg>';
			};

			self.setAsMainSuggestions = function( name ) {
				if ( window.Wikia.autocomplete && window.Wikia.autocomplete[name] ) {
					window.Wikia.autocomplete[name].inUse = false;
				}
			};

			self.setOldSuggestionsOn = function( name ) {
				if ( window.Wikia.autocomplete && window.Wikia.autocomplete[name] ) {
					window.Wikia.autocomplete[name].inUse = true;
				}
				window.Wikia.newSearchSuggestions = false;
				self.showAds();
				dropdown.empty();
				viewModel.setUse( false );
			};

			self.hideAds = function() {
				ads.each(function() {
					$(this).children().css('margin-left', '-9999px');
				});
			};

			self.showAds = function() {
				ads.each(function() {
					$(this).children().css('margin-left', 'auto');
				});
			};

			self.handleNavigation = function(key) {
				var active = document.activeElement,
					next;
				if ( !keyEventsActive ) { return; }
				if ( key === 13 ) {
					window.location.pathname = $(active).children('a').attr('href');
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
			};

			self.blurDropdown = function() {
				setTimeout( function() {
					if ( document.activeElement.parentNode !== dropdown[0] && document.activeElement !== searchInput[0] ) {
						self.showAds();
						dropdown.empty();
					}
				}, 0);
			};

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
						'<span class="title">' + self.buildTitleMarkup( res ) + '</span>' +
						self.buildRedirectMarkup( res ) +
						self.buildChevronMarkup() +
						'</div>' +
						'</div>' +
						'</a>' +
						'</li>';
					$el = $(html).appendTo(dropdown);
					$el.blur( self.blurDropdown );
				}
				if ( results.length ) {
					html = self.buildSeeAllResultsMarkup(i);
					$el = $(html).appendTo(dropdown);
					$el.click( function() { $('#WikiaSearch').submit(); } );
					self.hideAds();
				} else {
					self.showAds();
				}
			});
			searchInput.on( 'blur', self.blurDropdown );
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
					self.handleNavigation(e.keyCode);
					return false;
				}
			});
			dropdown.on( 'keydown', function (e) {
				if ( keyCodes.indexOf(e.keyCode) !== -1 ) {
					self.handleNavigation(e.keyCode);
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
			function updateWiki() {
				viewModel.setWiki( wikiId );
			}
			updateWiki();
		};
		window.Wikia.newSearchSuggestions = new SuggestionsView(
			new SuggestionsViewModel(),
			$('#WikiaSearch input[name="search"]'),
			$('ul.search-suggest'),
			wgCityId
		);
		log('New search suggestions loaded!', log.levels.info, 'suggestions');
		window.Wikia.newSearchSuggestions.setAsMainSuggestions( 'search' );
	});
});
