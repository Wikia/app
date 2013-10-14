require( [ "jquery", "client", "wikia.log" ], function( $, client, log ) {
	log("New search suggestions loading...", log.levels.info, "suggestions");
	$(function() {
		var SuggestionsViewModel = function() {};
		SuggestionsViewModel.prototype = {
			inUse: true,
			setUse: function( inUse ) {
				this.inUse = inUse;
			},

			setQuery: function( query ) {
				if (!query && this.query === query || !this.inUse) { return; }
				this.query = query;
				this.sendQuery();
				this.trigger( "query changed", query );
			},

			setWiki: function( wiki ) {
				this.wiki = wiki;
				this.sendQuery();
				this.trigger( "wiki changed", wiki );
			},

			sendQuery: function() {
				var self = this;
				var sentQuery = this.query;
				client.getSuggestions( this.wiki, this.query, function(res) {
					self.setResults(res, sentQuery);
				} );
			},

			setResults: function( results, sentQuery ) {
				//trigger only for the last sent query
				if ( sentQuery == this.query ) {
					log("result set for: " + sentQuery, log.levels.info, "suggestions");
					this.results = results;
					this.setDisplayResults( results );
					this.trigger( "results changed", results );
				}
			},


			setDisplayResults: function( results ) {
				this.displayResults = (results || []).slice(0, 8);
				this.trigger( "displayResults changed", results );
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
				var handlers = this._ev[ev] || {};
				for( var i in handlers ) {
					try {
						handlers[i](value);
					} catch(ex) {
						log(ex, log.levels.info, "suggestions");
					}
				}
			}
		};

		var SuggestionsView = function( viewModel, searchInput, dropdown, wikiId ) {
			var self = this;
			self.buildTitleMarkup = function( result ) {
				if ( result.match && ( result.match.type === 'title' ) ) {
					return result.match.prefix + '<b class="match">' + result.match.match + '</b>' + result.match.suffix;
				} else {
					return result.title;
				}
			}

			self.buildRedirectMarkup = function( result ) {
				if ( result.match && ( result.match.type === 'redirect' ) ) {
					return '<span class="redirect"><span class="redirect-from">Redirect from:</span>' + result.match.prefix + '<b class="match">' + result.match.match + '</b>' + result.match.suffix + "</span>";
				} else {
					return '';
				}
			}

			self.setAsMainSuggestions = function( name ) {
				if ( window.Wikia.autocomplete && window.Wikia.autocomplete[name] ) {
					window.Wikia.autocomplete[name].inUse = false;
				}
			}

			self.setOldSuggestionsOn = function( name ) {
				if ( window.Wikia.autocomplete && window.Wikia.autocomplete[name] ) {
					window.Wikia.autocomplete[name].inUse = true;
				}
				window.Wikia.newSearchSuggestions = false;
				dropdown.empty();
				viewModel.setUse( false );
			}

			viewModel.on( "displayResults changed", function() {
				var results = viewModel.getDisplayResults();
				dropdown.empty();
				for( var i in results ) {
					var res = results[i];
					var html = '<li>' +
						'<a href="' + results[i].url + '">' +
						'<img class="search-suggest-image" src="' + res.thumbnail + '" />' +
						'<span class="title">' + self.buildTitleMarkup( res ) + '</span>' +
						self.buildRedirectMarkup( res ) +
						'<span class="abstract">' + res.summary + '</span>' +
						'</a>' +
						'</li>';
					$(html).appendTo(dropdown);
				}
			});
			searchInput.on( "change", function () {
				var value = searchInput.val();
				viewModel.setQuery( value );
			});
			searchInput.on( "keypress", function () {
				window.setTimeout(function() {
					var value = searchInput.val();
					viewModel.setQuery( value );
				}, 0);
			});
			searchInput.on( "keyup", function () {
				var value = searchInput.val();
				viewModel.setQuery( value );
			});
			function updateWiki() {
				viewModel.setWiki( wikiId );
			}
			updateWiki();
		};
		window.Wikia.newSearchSuggestions = new SuggestionsView( new SuggestionsViewModel(), $('input[name="search"]'), $('ul.search-suggest'), wgCityId );
		log("New search suggestions loaded!", log.levels.info, "suggestions");
		window.Wikia.newSearchSuggestions.setAsMainSuggestions( 'search' );
	});
});