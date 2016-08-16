require( ['jquery', 'wikia.toc', 'wikia.mustache'], function( $, toc, mustache ) {
	'use strict';

	/**
	 * map container identifier as key, true/false values that determine if TOC was generated for that container
	 * @type {Object}
	 */
	var containerHasTOC = {},
		cacheKey = 'TOCAssets'; // Local Storage key

	/**
	 * Wraps subsections of TOC with <ol> element
	 *
	 * @returns {Function} - custom mustache wrapping function
	 */

	function wrapper() {
		return function( text, render ) {
			if ( text !== '' ) {
				return '<ol>' + render( text ) + '</ol>';
			} else {
				return false;
			}
		};
	}

	/**
	 * Checks and gets valid section heading
	 *
	 * @param {Object} rawHeader - Node element object for single article header
	 *
	 * @returns {Object|Boolean} - returns header jQuery object or false if the header is not valid
	 */
	function getHeader( rawHeader ) {
		rawHeader = $( rawHeader ).children( '.mw-headline' );

		if ( rawHeader.length === 0 || rawHeader.is( ':hidden' ) ) {
			return false;
		}

		// clone node and remove noscript to exclude it from text
		rawHeader = rawHeader.clone();
		rawHeader.find( 'noscript' ).remove();

		return rawHeader;
	}

	/**
	 *
	 * @param {Object} header - Processed element object for single article header
	 *
	 * @param {Integer} tocLevel - The actual level on which the element will be rendered
	 *
	 * @returns {Object} - returns TOC section object
	 */

	function createTOCSection( header, tocLevel ) {
		return {
			title: header.text(),
			id: header.attr( 'id' ),
			class: 'toclevel-' + tocLevel,
			sections: []
		};
	}

	/**
	 * load mustache template or get it from Local Storage
	 *
	 * @return {Object} - promise with mustache template
	 */

	function loadTemplate() {
		var dfd = new $.Deferred();

		require( ['wikia.loader', 'wikia.cache'], function( loader, cache ) {
			var template = cache.getVersioned( cacheKey );

			if ( template ) {
				dfd.resolve( template );
			} else {
				require( ['wikia.throbber'], function( throbber ) {
					var toc = $( '#toc' );

					throbber.show( toc );

					loader( {
						type: loader.MULTI,
						resources: {
							mustache: 'extensions/wikia/TOC/templates/TOC_articleContent.mustache'
						}
					} ).done( function( data ) {
						template = data.mustache[0];

						dfd.resolve( template );

						cache.setVersioned( cacheKey, template, 604800 ); //7days

						throbber.remove( toc );
					} );
				} );
			}
		} );

		return dfd.promise();
	}

	/**
	 * Render TOC for article or preview
	 *
	 * @param {Object} $target - jQuery selector object for event target
	 *                           which gives a context to either article or preview in the editor.
	 */

	function renderTOC( $target ) {
		var $tocContainer = $target.parents( '#toc' ),
			$container = $tocContainer.children( 'ol' ),
			$contentContainer = getContentContainer( $target ),
			$headers = $contentContainer.find( 'h1, h2, h3, h4, h5, h6' ),
			data = toc.getData( $headers, createTOCSection, getHeader );

		data.wrapper = wrapper;

		loadTemplate().done( function( template ) {
			$container.append( mustache.render( template, data ) );
			$tocContainer.trigger('afterLoad.toc').data('loaded', true);

			setHasTOC( $target, true );
		} );
	}

	/**
	 * Set Cookie for hidden TOC
	 *
	 * @param {?Number} isHidden - accepts 'null' or 1
	 */

	function setTOCCookie( isHidden ) {
		$.cookie( 'mw_hidetoc', isHidden, {
			expires: 30,
			path: '/'
		} );
	}

	/**
	 * Shows / hides TOC
	 *
	 * @param {Object} $target - jQuery selector object for event target
	 *                           which gives a context to either article or preview in the editor.
	 */

	function showHideTOC( $target ) {
		var tocWrapper = $target.parents( '#toc' ),
			targetLabel,
			tocCookie;

		tocWrapper.toggleClass( 'show' );

		if ( tocWrapper.hasClass( 'show' ) ) {
			targetLabel = $target.data( 'hide' );
			tocCookie = null;
		} else {
			targetLabel = $target.data( 'show' );
			tocCookie = 1;
		}

		$target.text( targetLabel );
		$target.attr( 'title', targetLabel );

		setTOCCookie( tocCookie );
	}

	/**
	 * Temporary function to check if new TOC exists (article was purged and has new TOC applied)
	 *
	 * TODO: remove this after parser cache for all articles is purged
	 *
	 * @returns {Boolean} - return true if new TOC exists
	 */

	function isNewTOC() {
		return $( '#toc' ).is( 'nav' );
	}

	/**
	 * Initialized the TOC after an article has been loaded
	 */
	function initTOC() {
		var $showLink = $( '#togglelink' );
		if ( !hasTOC( $showLink ) ) {
			renderTOC( $showLink );
		}
		showHideTOC( $showLink );
	}

	/**
	 * Checks if TOC was generated already
	 * @param {Object} $target (jquery collection) TOC open link
	 * @returns {boolean}
	 */
	function hasTOC( $target ) {
		var containerIdentifier = getContainerIdentifier( $target );

		return typeof containerHasTOC[containerIdentifier] !== 'undefined' && containerHasTOC[containerIdentifier];
	}

	/**
	 * Sets that toc was generated or not for selected TOC
	 * @param {Object} $target (jquery collection) TOC open link
	 * @param {boolean} value
	 */
	function setHasTOC( $target, value ) {
		var containerIdentifier = getContainerIdentifier( $target );
		containerHasTOC[containerIdentifier] = value;
	}

	/**
	 * Gets TOC container
	 * @param {Object} $target (jquery collection) TOC open link
	 * @returns {Object} jquery collection
	 */
	function getContentContainer( $target ) {
		// if tabviewer is on site use content from one tab only
		return $target.parents( '.tabBody, #mw-content-text' ).first();
	}

	/**
	 * Get TOC container identifier - used for setting that TOC was already rendered for that container
	 * @param {Object} $target (jquery collection) TOC open link
	 * @returns {string}
	 */
	function getContainerIdentifier( $target ) {
		return getContentContainer( $target ).data( 'tab-body' ) || 'main';
	}

	$( function() {
		/** Attach events */
		$( 'body' ).on( 'click', '#togglelink', function( event ) {
			event.preventDefault();

			if ( isNewTOC() ) {
				var $target = $( event.target );

				if ( !hasTOC( $target ) ) {
					renderTOC( $target );
				}

				showHideTOC( $target );
			}
		} );

		// reset containerHasTOC flags for each time preview modal is opened
		$( window ).on( 'EditPageAfterRenderPreview', function() {
			containerHasTOC = {};
			if ( isNewTOC() && window.wgUserName !== null ) {
				initTOC();
			}
		} );

		/** Auto expand TOC in article for logged-in users with hideTOC cookie set to 'null'  */
		if ( isNewTOC() && window.wgUserName !== null && $.cookie( 'mw_hidetoc' ) === null ) {
			initTOC();
		}
	} );
} );
