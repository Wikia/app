(function ( window, document, wikiaTracker ) {
	'use strict';

	// window.addEventListener polyfill
	!window.addEventListener && ( function ( WindowPrototype, DocumentPrototype, ElementPrototype, addEventListener, registry ) {
		WindowPrototype[ addEventListener ] = DocumentPrototype[ addEventListener ] = ElementPrototype[ addEventListener ] = function ( type, listener ) {
			var target = this;

			registry.unshift( [ target, type, listener, function ( event ) {
				event.currentTarget = target;
				event.preventDefault = function () { event.returnValue = false };
				event.stopPropagation = function () { event.cancelBubble = true };
				event.target = event.srcElement || target;

				listener.call( target, event );
			}]);

			this.attachEvent( "on" + type, registry[ 0 ][ 3 ] );
		};

	})( Window.prototype, HTMLDocument.prototype, Element.prototype, "addEventListener", [] );
	// end of window.addEventListener polyfill

	window.ajax = function( url, callback ) {
		var xhr = new XMLHttpRequest();
		xhr.open( 'GET', url, true );
		xhr.onreadystatechange = function () {
			if ( xhr.readyState === 4 && xhr.status === 200 ) {
				callback( JSON.parse( xhr.responseText ) );
			}
		};

		xhr.send();
	};

	window.toQueryParams = function( json ) {
		return Object.keys( json ).map( function ( k ) {
			return encodeURIComponent( k ) + '=' + encodeURIComponent( json[ k ] );
		} ).join( '&' );
	};

	window.getAncestorNode = function( elem, ancestorNodeName, maxBubbleUp ) {
		var bubble = maxBubbleUp || 4;

		elem = elem.parentNode;
		while ( elem && bubble ) {
			if ( elem.nodeName == ancestorNodeName ) {
				return elem;
			}
			elem = elem.parentNode;
			bubble--;
		}
		return null;
	};

	window.getIndexOfListItem = function( elem ) {
		var itemNode = getAncestorNode( elem, 'LI' );
		if ( itemNode ) {
			var listNode = itemNode.parentNode,
				itemNodesList = Array.prototype.slice.call( listNode.children );

			return itemNodesList.indexOf( itemNode );
		}
		return null;
	}

	window.loadRecommendations = function( numberOfRecommendations, recommendations ) {
		var html = '<section id="wkRelPag" class="RelatedPagesModule noprint">'
				+ '<h2 id="wkRelPagHead">' + window.wgMessages[ 'wikiarelatedpages-heading' ] + '</h2><ul>',
			i = 0,
			recommendationsKeys = Object.keys( recommendations ),
			recommendation,
			recommendationsContainer,
			recommendationsContainerForNLP;

		while ( numberOfRecommendations - i ) {
			recommendation = recommendations[ recommendationsKeys[ i ] ];

			html += '<li><a href="' + recommendation.url + '"';
			if ( recommendation.title ) {
				html += ' title="' + recommendation.title + '"';
			}
			html += '>';

			if ( recommendation.image ) {
				html += '<img width="200" height="100" border="0" src="' + recommendation.image + '"';
				if ( recommendation.title ) {
					html += ' alt="' + recommendation.title + '"';
				}
				html += '>';
			} else if ( recommendation.text ) {
				html += '<div class="articleSnippet"><p>' + recommendation.text + '</p></div>';
			}

			if ( recommendation.title ) {
				html += '<span class="more">' + recommendation.title + '</span>';
			}
			html += '</a></li>';

			i++;
		}
		html += '</ul></section>';

		// disable loading recommendations from Related Pages module
		recommendationsContainer = document.getElementById( 'RelatedPagesModuleWrapper' );
		recommendationsContainerForNLP = document.createElement( 'div' );
		recommendationsContainerForNLP.id = 'RecommendationsModuleWrapper';
		recommendationsContainer.parentNode.replaceChild( recommendationsContainerForNLP, recommendationsContainer );
		recommendationsContainerForNLP.innerHTML = html;
	};

	window.trackClick = function( elemId, useWikiaTracker ) {
		document.getElementById( elemId ).addEventListener( 'mousedown', function ( event ) {
			var target = event.target,
				slotIndex = getIndexOfListItem( target );

			if ( getAncestorNode( target, 'A' ) && slotIndex != null ) {
				var slotNum = slotIndex + 1,
					eventName = 'recommendation-' + slotNum + '-click';

				window[ 'optimizely' ] = window[ 'optimizely' ] || [];
				window.optimizely.push( [ 'trackEvent', eventName ] );
				if ( useWikiaTracker ) {
					wikiaTracker.track( {
						action: wikiaTracker.ACTIONS.CLICK,
						trackingMethod: 'ga',
						category: 'article',
						label: 'related-pages'
					} );
				}
			}
		} );
	};

	// run the test
	// @param Bool randomPick => pick random recommendations from the request response: 1->randomized, 2->ordered
	window.initRecommendationsABTest = function( randomPick ) {
		var requestParams = toQueryParams( {
				controller: 'ReadMoreController',
				method: 'getReadMoreArticles',
				articleId: window.wgArticleId,
				type: randomPick
			} ),
			apiEntryPoint = window.wgServer + window.wgScriptPath + '/wikia.php?';

		// make an ajax call and request and load recommendations
		ajax( apiEntryPoint + requestParams, function ( response ) {
			var recommendations = response.recommendations,
				numberOfRecommendations = 3;

			if ( Object.keys( recommendations ).length >= numberOfRecommendations ) {
				// Load recommendations
				loadRecommendations( numberOfRecommendations, recommendations );

				// add tracking
				trackClick( 'RecommendationsModuleWrapper', true );
			}
		} );
	}
})( window, document, Wikia.Tracker );